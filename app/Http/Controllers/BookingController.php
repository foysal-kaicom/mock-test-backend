<?php

namespace App\Http\Controllers;

use App\Exports\ConfirmedBookingsExport;
use App\Http\Requests\StoreBookingRequest;
use App\Jobs\SendBatchRegistrationEmailJob;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\Candidate;
use App\Models\Center;
use App\Models\Exam;
use App\Models\FileProcesses;
use App\Models\Payment;
use App\Notifications\CandidateNotification;
use App\Services\FileStorageService;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use ZipArchive;

class BookingController extends Controller
{

    protected $fileStorageService;
    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $status = strtolower($request->get('status', 'all'));
            $examId = $request->get('exam_id');

            $bookings = Booking::with(['candidate:id,prefix,first_name,last_name,surname', 'exam:id,title', 'center:id,name'])->orderBy('id','desc');

            if (in_array($status, ['confirmed', 'pending', 'cancelled'])) {
                $bookings->where('status', $status);
            }

            if (!empty($examId) && $examId !== 'all') {
                $bookings->where('exam_id', $examId);
            }

            return DataTables::of($bookings)
                ->addColumn('candidate_name', function ($booking) {
                    if ($booking->candidate) {
                        $fullName = "{$booking->candidate->prefix} {$booking->candidate->first_name} {$booking->candidate->last_name} {$booking->candidate->surname}";
                        return '<span style="color: #007bff;">' . e($fullName) . '</span>';
                    }
                    return 'N/A';
                })
                ->filterColumn('candidate_name', function ($query, $keyword) {
                    $query->whereHas('candidate', function ($q) use ($keyword) {
                        $q->where('first_name', 'like', "%{$keyword}%")
                          ->orWhere('last_name', 'like', "%{$keyword}%")
                          ->orWhere('surname', 'like', "%{$keyword}%");
                    });
                })                
                ->addColumn('exam_title', fn($booking) => $booking->exam->title ?? 'N/A')
                ->addColumn('center_name', fn($booking) => $booking->center->name ?? 'N/A')
                ->addColumn('action', function ($booking) {
                    $viewUrl = route('booking.view', $booking->id);
                    $editUrl = route('booking.edit', $booking->id);
                    return '<div style="display: flex; gap: 6px;">
                                <a href="' . $viewUrl . '" class="px-4 py-1 rounded-lg text-sm font-medium bg-sky-500 text-white hover:bg-sky-600 shadow-md transition">View</a>
                                <a href="' . $editUrl . '" class="px-4 py-1 rounded-lg text-sm font-medium bg-green-500 text-white hover:bg-green-600 shadow-md transition">Edit</a>
                            </div>';
                })
                ->addColumn('status', function ($booking) {
                    $status = strtolower($booking->status);
                    $color = $status === 'confirmed' ? 'green-500 ' : ($status === 'cancelled' ? 'red-400' : 'gray-400');
                    return '<span class=" bg-'.$color.' text-white" style="padding: 3px 12px; border-radius: 25px; font-size: 12px; font-weight:600">' . ucfirst($status) . '</span>';
                })
                ->rawColumns(['action', 'candidate_name', 'status'])
                ->make(true);
        }

        $exams = Exam::select('id', 'title','exam_date')->orderBy('exam_date')->get();
        return view('bookings.list', compact('exams'));
    }


    public function viewBooking($id)
    {
        $booking = Booking::with(['candidate', 'exam', 'center', 'payment'])->where('id', $id)->first();
        return view('bookings.view', compact('booking'));
    }

    public function showEditPage($id)
    {
        $booking = Booking::findOrFail($id);
        $candidates = Candidate::all();
        $exams = Exam::all();
        $centers = Center::all();

        return view('bookings.edit', compact('booking', 'candidates', 'exams', 'centers'));
    }

    public function update(StoreBookingRequest $request, $id)
    {

        $booking = Booking::with('candidate:id,prefix,first_name,last_name,surname')->findOrFail($id);
        $data = $request->validated();

        if (isset($data['status']) && $data['status'] === Booking::CONFIRMED) {
            if ($booking->payment_status !== 'success') {
                $data['status'] = $booking->status;
                Toastr::warning('Booking cannot be confirmed because payment status is not success.');
                return redirect()->back();
            }
        }

        if ($booking->status === Booking::CONFIRMED){
            if ($request->hasFile('result_file')) {

                if ($booking->result_file) {
                    $resutl_path = $this->fileStorageService->updateFileFromCloud($booking->result_file, $request->file('result_file'));
                } else {
                    $resutl_path = $this->fileStorageService->uploadImageToCloud($request->file('result_file'), 'result');
                }
    
                $data['result_file'] = $resutl_path['public_path'];
            }
    
            if ($request->hasFile('admit_card_file')) {
                if ($booking->admit_card_file) {
                    $admit_card_path = $this->fileStorageService->updateFileFromCloud($booking->admit_card_file, $request->file('admit_card_file'));
                } else {
                    $admit_card_path = $this->fileStorageService->uploadImageToCloud($request->file('admit_card_file'), 'admit_card');
                }
    
                $data['admit_card_file'] = $admit_card_path['public_path'];
            }
    
    
            if ($request->hasFile('certificate_file')) {
                if ($booking->certificate_file) {
                    $certificate_file = $this->fileStorageService->updateFileFromCloud($booking->certificate_file, $request->file('certificate_file'));
                } else {
                    $certificate_file = $this->fileStorageService->uploadImageToCloud($request->file('certificate_file'), 'certificate');
                }
                $data['certificate_file'] = $certificate_file['public_path'];
            }

        }
        else {
            if ($request->hasFile('result_file') || $request->hasFile('admit_card_file') || $request->hasFile('certificate_file')) {
                Toastr::warning('Files can only be uploaded after booking is confirmed.');
                return redirect()->back();
            }
        }

        $data['result'] = $data['listening_score'] + $data['reading_score'];

        $booking->update($data);

        //notify candidate
        $data=[
            'title'=>"Booking Update !",
            'message'=>"Your booking of Exam Date: ". $booking->exam->title ." has been updated. Check your profile. ",
            'url'=>'',

        ];
        $booking->candidate->notify(new CandidateNotification($data));


        Toastr::success('Booking Information updated.');
        return redirect()->route('booking.list');
    }

    public function importBookingPage(){
        $fileProcesses = FileProcesses::where('process_name', 'booking_csv_import')
        ->orderBy('created_at', 'desc')
        ->get();

        $agents = Agent::all();

        return view('import.import-booking', compact('fileProcesses', 'agents'));
    }
    

    public function importCSV(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv|max:5120',
            'agent_id' => 'nullable|int',
        ]);

        $validatedData = $validate->validated();
    
        if ($validate->fails()) {
            Toastr::error($validate->getMessageBag());
            return redirect()->back();
        }
    
        DB::beginTransaction();

        $fileProcess = null;
        $newCandidates = [];
    
        try {
            $file = $request->file('csv_file');
            $path = $file->getRealPath();
            $originalName = $file->getClientOriginalName();
    
            // create process log
            $fileProcess = FileProcesses::create([
                'user_id'      => auth()->id(),
                'process_name' => 'booking_csv_import',
                'file_name'    => $originalName,
                'status'       => 'processing',
            ]);
    
            $expectedHeaders = [
                'Name Prefix',
                'First Name',
                'Last Name',
                'Sur Name',
                'Email',
                'Date of Birth',
                'Phone',
                'Nationality',
                'NID/Passport',
                'Address',
                'Payment'
            ];
    
            $rows = [];
            if (($handle = fopen($path, 'r')) !== false) {
                while (($data = fgetcsv($handle, 0, ',')) !== false) {
                    $rows[] = $data;
                }
                fclose($handle);
            }
    
            if (empty($rows)) {
                throw new \Exception("CSV file is empty.");
            }
    
            // first row = headers, second row = column names (based on your current logic)
            $headers = array_map('trim', $rows[0]);
            $columnHeaders = array_map('trim', $rows[1]);
    
            if (count($columnHeaders) !== count($expectedHeaders)) {
                throw new \Exception("CSV file has wrong number of columns.");
            }
    
            // Check header names match (case-insensitive)
            foreach ($expectedHeaders as $i => $expected) {
                if (strtolower($columnHeaders[$i]) !== strtolower($expected)) {
                    throw new \Exception("Invalid CSV format. Expected '{$expected}', got '{$columnHeaders[$i]}' at column " . ($i + 1));
                }
            }
    
            // remove the first row only, to keep your original behavior
            unset($rows[0]);
    
            $center = Center::first();
            if (!$center) {
                $center = Center::create([
                    'name' => 'Institute of Modern Languages (IML)',
                    'seat_capacity' => 100,
                    'location' => 'Dhaka',
                    'address' => 'Institute of Modern Languages (IML), University of Dhaka, Dhaka',
                    'contact_phone' => '01847291886',
                    'contact_email' => 'jpttestbd@gmail.com',
                    'status' => 1,
                ]);
            }
    
            $center_id = $center->id;
    
            $exam_name = trim($headers[4]);
            $exam = Exam::where('title', $exam_name)->first();
    
            if (!$exam) {
                $exam = Exam::create([
                    'title' => $exam_name,
                    'slug' => Str::slug($exam_name),
                    'description' => $exam_name . ' Description',
                    'exam_date' => now()->addWeek(),
                    'application_deadline' => now(),
                    'fee' => 3500,
                    'start_time' => '09:00:00',
                    'end_time' => '12:00:00',
                    'created_by' => auth()->id() ?? 1,
                ]);
            }
    
            $successCount = 0;
            $bookingExistCount = 0;
            $exam_id = $exam->id;
    
            $skippedFirstRow = false;
            foreach ($rows as $row) {
                if (!$skippedFirstRow) {
                    $skippedFirstRow = true;
                    continue;
                }
    
                $row = array_map('trim', $row);
                if (count($row) < 11) continue;
    
                // Skip if the row is completely empty
                if (empty(array_filter($row))) {
                    continue;
                }
    
                [$prefix, $first, $last, $surname, $email, $dob, $phone, $nationality, $nid, $address, $payment] = $row;
    
                if (!$email) {
                    continue; // no email, skip
                }
    
                $candidate = Candidate::where('email', $email)->first();

                $dateOfBirth = ($dob === '') ? null : Carbon::parse($dob)->format('Y-m-d');

                $initial_password = random_int(100000, 999999);

                if (!$candidate) {
                    $candidate = Candidate::create([
                        'prefix' => $prefix,
                        'first_name' => $first,
                        'last_name' => $last,
                        'surname' => $surname,
                        'email' => $email,
                        'password' => Hash::make($initial_password),
                        'date_of_birth' => $dateOfBirth,
                        'phone_number' => $phone,
                        'nationality' => $nationality,
                        'national_id' => $nid,
                        'address' => $address,
                        'gender' => ($prefix === 'Mr.') ? 'male' : (($prefix === 'Ms.' || $prefix === 'Mrs.') ? 'female' : 'unknown'),
                        'status' => 'active',
                    ]);

                    $newCandidates[] = [
                        'email' => $email,
                        'password' => $initial_password
                    ];
                }else{
                    Log::debug($candidate->email."exist");
                }
    
                $exists = Booking::where('candidate_id', $candidate->id)
                    ->where('exam_id', $exam_id)
                    ->where('center_id', $center_id)
                    ->where('status', 'confirmed')
                    ->exists();

                if ($validatedData['agent_id']) {
                    $agent = Agent::find($validatedData['agent_id']);
                    $commission_percentage = $agent ? $agent->commission_percentage : null;
                    $exam_fee = Exam::where('id', $exam_id)->pluck('fee')->first();
                    $commission_amount = $exam_fee * ($commission_percentage / 100);
                }    

                if (!$exists) {
                    Booking::create([
                        'candidate_id' => $candidate->id,
                        'exam_id' => $exam_id,
                        'center_id' => $center_id,
                        'agent_id' => $validatedData['agent_id'] ?? null,
                        'status' => 'confirmed',
                        'commission_percentage' => $commission_percentage ?? null,
                        'commission_amount' => $commission_amount ?? null,
                        'total_payable' => 3500,
                        'payment_status' => ($payment === 'completed') ? 'success' : 'pending',
                        'is_certificate_claimed' => false,
                    ]);
    
                    $successCount++;
                } else {
                    $bookingExistCount++;
                }
            }

            if ($newCandidates > 0) {
                dispatch(new SendBatchRegistrationEmailJob($newCandidates));
                Log::info('job done');
            }
            else{
                Log::info('no new candidates');
            }
    
            DB::commit();
    
            $fileProcess->update([
                'status'        => 'success',
                'error_message' => null,
            ]);
    
            Toastr::success('Data Exist: ' . $bookingExistCount . '. New Data Imported With Booking: ' . $successCount);
            return redirect()->back();
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            if ($fileProcess) {
                $fileProcess->update([
                    'status'        => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
            }
    
            Log::error($e->getMessage());
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function exportConfirmed(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_id' => 'required'
        ]);

        if ($validator->fails()) {
            Toastr::error($validator->getMessageBag());
            return redirect()->back();
        }

        $examId = request()->exam_id;
        $status = request()->status;

        $bookings = Booking::with(['candidate', 'exam', 'center'])
            ->when($examId, fn($q) => $q->where('exam_id', $examId))
            ->when($status, fn($q) => $q->where('status', $status))
            ->get();

        $date = Carbon::now()->format('Y-m-d');
        $fileName = "confirmed_bookings_{$date}.csv";

        return Excel::download(new ConfirmedBookingsExport($bookings), $fileName);
    }

    public function exportImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            Toastr::error($validator->getMessageBag());
            return redirect()->back();
        }
    
        $examId = $request->exam_id;
        $status = $request->status;
    
        $bookings = Booking::with(['candidate', 'exam'])
            ->when($examId, fn($q) => $q->where('exam_id', $examId))
            ->when($status, fn($q) => $q->where('status', $status))
            ->get();
    
        $date = Carbon::now()->format('Y-m-d');
        $zipFileName = "candidate_photos_{$date}.zip";
    
        $zipDir = public_path('temp/zip');
        if (!file_exists($zipDir)) {
            mkdir($zipDir, 0777, true);
        }
    
        $zipPath = $zipDir . '/' . $zipFileName;
    
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            Log::debug("Could not create ZIP file at {$zipPath}");
            return back()->withErrors(['msg' => 'Could not create ZIP file']);
        }
    
        // simple sanitizer for filenames
        $sanitize = static function (?string $str): string {
            $s = preg_replace('/[^A-Za-z0-9_\-]+/', '_', $str ?? '');
            $s = trim($s, '_');
            return $s !== '' ? $s : 'unknown';
        };
    
        foreach ($bookings as $booking) {
            $candidate = $booking->candidate;
            if ($candidate && $candidate->photo) {
                $photoUrl = $candidate->photo;
    
                if ($this->remoteFileExists($photoUrl)) {
                    $tempFilePath = sys_get_temp_dir() . '/' . basename($photoUrl);
                    $imageContents = @file_get_contents($photoUrl);
    
                    if ($imageContents !== false) {
                        file_put_contents($tempFilePath, $imageContents);
                        if (file_exists($tempFilePath)) {
    
                            $extension = pathinfo(parse_url($photoUrl, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION);
                            $candidateName = $sanitize($candidate->full_name);
                            $examTitle = $sanitize(optional($booking->exam)->title ?? 'exam');
                            $customFileName = "{$candidateName}_{$examTitle}_{$candidate->id}." . strtolower($extension ?: 'jpg');
    
                            $zip->addFile($tempFilePath, $customFileName);
    
                            // Don't unlink here — unlink after closing zip!
                        }
                    }
                }
            }
        }
    
        $zip->close();
    
        foreach ($bookings as $booking) {
            $candidate = $booking->candidate;
            if ($candidate && $candidate->photo) {
                $tempFilePath = sys_get_temp_dir() . '/' . basename($candidate->photo);
                if (file_exists($tempFilePath)) {
                    @unlink($tempFilePath);
                }
            }
        }
    
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function remoteFileExists(string $url): bool
    {
        $headers = @get_headers($url);
        return $headers && strpos($headers[0], '200') !== false;
    }

    public function storeBookingPayment(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'amount' => 'required|numeric|min:0',
                'payment_method' => 'required|string',
                'reference' => 'nullable|string',
                'additionals' => 'nullable|string',
                'booking_id' => 'required|exists:bookings,id',
                'status' => 'required|in:success',
                'type' => 'required|in:booking',
            ]);
    
            $payment = Payment::create($validatedData);

            if (!$payment) {
                Toastr::error('Payment could not be processed. Please try again.');
                return back()->withError('Payment could not be processed. Please try again.')->withInput();
            }

            $booking = Booking::findOrFail($validatedData['booking_id']);

            $booking->payment_status = 'success';
            $booking->save();

            DB::commit();
    
            Toastr::success('Booking payment information added successfully.');
            return redirect()->route('booking.edit', $validatedData['booking_id'])->with('success', 'Payment added successfully!');
        }catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('An unexpected error occurred. Please try again later.');
            return back()->withError('An unexpected error occurred.')->withInput();
        }
    }

}
