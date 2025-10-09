<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCertificateClaimRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\BusinessSetting;
use App\Models\CertificateClaim;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class BookingController extends Controller
{
    public function book(Request $request, $slug)
    {
        try {
            $candidate = auth('candidate')->user();

            if ($candidate->is_phone_verified) {

                $exam = Exam::where('slug', $slug)->first();

                if ($exam) {
                    //check booking exist or not

                    $checkBooking = Booking::where('candidate_id', $candidate->id)
                        ->where('exam_id', $exam->id)
                        ->where('status', Booking::CONFIRMED)
                        ->exists();
                    if ($checkBooking) {

                        return $this->responseWithError('You have aleady booking in this exam.');
                    }
                    //store data to booking table
                    $booking = Booking::create([
                        'candidate_id'         => $candidate->id,
                        'exam_id'              => $exam->id,
                        'center_id'            => $request->center_id,
                        // 'status' is optional; will default to 'pending'
                        // 'payment_status' is optional; will default to 'pending'
                        'total_payable'        => $exam->fee ?? 0.0,
                        'result_file'          => null,
                        'result'               => null,
                        'certificate_file'     => null,
                        'is_certificate_claimed' => false,
                        'certificate_claimed_at' => null,
                        'booking_note'         => $request->booking_note,
                    ]);

                    if ($booking) {
                        //procced to payment
                        $sslPayment = new SslCommerzPaymentController;
                        $paymentLink = $sslPayment->payNow($booking);

                        return $this->responseWithSuccess($paymentLink, 'Booking Success. Please complete the payment.');
                    }
                }

                return $this->responseWithError('No Exam Found.');
            }
            return $this->responseWithError('Please verify your mobile number.', ['code' => 444]);
        } catch (Throwable $exception) {
            Log::error($exception->getMessage());
            return $this->responseWithError('Something went wrong.');
        }
    }


    public function list()
    {
        $booking = Booking::where('candidate_id', auth('candidate')->user()->id)->orderBy('created_at', 'desc')->get();

        return $this->responseWithSuccess(BookingResource::collection($booking), 'Booking List.');
    }

    public function resultedBookings()
    {
        $resultedBookings = Booking::with('exam')->where('candidate_id', auth('candidate')->user()->id)->whereNotNull('result')->get();

        return $this->responseWithSuccess(BookingResource::collection($resultedBookings), 'Resulted Bookings Fetched');
    }

    public function bookingsWithCertificate()
    {
        $bookingsWithCertificate = Booking::with('exam')->where('candidate_id', auth('candidate')->user()->id)->whereNotNull('certificate_file')->get();

        return $this->responseWithSuccess($bookingsWithCertificate, 'Booking List.');
    }

    public function view($booking_id)
    {
        try {
            $booking = Booking::findOrFail($booking_id);

            return $this->responseWithSuccess(BookingResource::make($booking), 'Single Booking View.');
        } catch (Throwable $ex) {
         return $this->responseWithError('No booking found.',[]);
        }
    }

    public function storeCertificateClaim(StoreCertificateClaimRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            $businessInfo = BusinessSetting::find(1);

            $data['receiver_number'] = $businessInfo['bkash_number'];
            $data['amount'] = $businessInfo['certificate_amount'];
            $data['reference_number'] = $request->booking_id;

            CertificateClaim::create($data);

            Booking::where('id', $data['booking_id'])->update([
                'is_certificate_claimed' => 1
            ]);

            DB::commit();
            return $this->responseWithSuccess('Certificate Payment Initiated');
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->responseWithError('Error processing certificate claim: ' . $e->getMessage());
        }
    }
}
