<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\PackageDetail;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSubscriptionDetails;
use App\Http\Resources\PackageDetailResource;
use App\Http\Controllers\Api\SslCommerzPaymentController;


class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('package_details')
        ->orderByRaw('ISNULL(`order`), `order` ASC')
        // ->orderBy('order', 'asc')
        ->get();
        return view('packages.index', compact('packages'));
    }

    public function create()
    {
        $exams = Exam::all(); 
        return view('packages.create', compact('exams'));
    }

    public function store(Request $request)
    {
        $package = Package::create([
            'name' => $request->name,
            'price' => $request->price,
            'is_popular' => $request->has('is_popular') ? 1 : 0,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'is_home' => $request->has('is_home') ? 1 : 0,
            'order' => $request->order,

            // 'status' => $request->status,
        ]);

        if ($request->exam_id) {
            foreach ($request->exam_id as $key => $exam) {
                PackageDetail::create([
                    'package_id' => $package->id,
                    'exam_id'    => $exam,
                    'max_exam_attempt' => $request->max_exam_attempt[$key],
                ]);
            }
        }

        return redirect()->route('packages.index')->with('success', 'Package created successfully');
    }

    public function edit(Package $package)
    {
        $exams = Exam::all(); 
        $package->load('package_details');
        return view('packages.edit', compact('package','exams'));
    }

    public function update(Request $request, Package $package)
    {
        $package->update([
            'name' => $request->name,
            'price' => $request->price,
            'is_popular' => $request->has('is_popular') ? 1 : 0,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status,
            'is_home' => $request->has('is_home') ? 1 : 0,
            'order' => $request->order,
        ]);

        // Delete old details and re-insert
        $package->package_details()->delete();

        if ($request->exam_id) {
            foreach ($request->exam_id as $key => $exam) {
                PackageDetail::create([
                    'package_id' => $package->id,
                    'exam_id'    => $exam,
                    'max_exam_attempt' => $request->max_exam_attempt[$key],
                ]);
            }
        }

        return redirect()->route('packages.index')->with('success', 'Package updated successfully');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('packages.index')->with('success', 'Package deleted successfully');
    }

    // API to get package details
    // public function show()
    // {
    //     $packages = Package::with(['package_details.exam'])->where('status', 1)->orderBy('order', 'asc')->get()->map(function($package) {
    //         return [
    //             'id' => $package->id,
    //             'name' => $package->name,
    //             'price' => $package->price,
    //             'short_description' => $package->short_description,
    //             'description' => $package->description,
    //             'status' => $package->status,
    //             'is_popular' => $package->is_popular,
    //             'is_home' => $package->is_home,
    //             'sequence' => $package->order,
    //             'package_details' => PackageDetailResource::collection($package->package_details),
    //         ];
    //     });

    //     return $this->responseWithSuccess($packages, 'Packages retrieved successfully');
    // }

    // Buy package
    // public function buy(Package $package)
    // {
    //     foreach ($package->package_details as $detail) {
    //         UserSubscription::create([
    //             'user_id'            => Auth::id(),
    //             'package_details_id' => $detail->id,
    //             'count'              => 0,
    //         ]);
    //     }
    //     return redirect()->back()->with('success', 'Package purchased successfully');
    // }




    public function show(Request $request)
    {
        // Start the query
        $query = Package::with(['package_details.exam'])
            ->where('status', 1)
            ->orderByRaw('ISNULL(`order`), `order` ASC');
            // ->orderBy('order', 'asc');

        // Apply filter dynamically
        if ($request->has('is_home') && $request->is_home == true) {
            $query->where('is_home', true);
        }

        // Add ordering
        $packages = $query->orderBy('order', 'asc')
            ->get()
            ->map(function ($package) {
                return [
                    'id' => $package->id,
                    'name' => $package->name,
                    'price' => $package->price,
                    'short_description' => $package->short_description,
                    'description' => $package->description,
                    'status' => $package->status,
                    'is_popular' => $package->is_popular,
                    'is_home' => $package->is_home,
                    'sequence' => $package->order,
                    'package_details' => PackageDetailResource::collection($package->package_details),
                ];
            });

        return $this->responseWithSuccess($packages, 'Packages retrieved successfully');
    }

    // Initiate package payment
    public function subscribe(Request $request, SslCommerzPaymentController $sslController)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        // Auth::guard('candidate')->id(),
        $candidate = Auth::guard('candidate')->user();
        if (!$candidate) {
            return $this->responseWithError('Unauthorized', 'Please log in to subscribe to a package', 401);
        }
        // dd($candidate);
        $package = Package::with('package_details.exam')->findOrFail($request->package_id);


        $userSubscription = UserSubscription::create([
            'candidate_id'       => $candidate->id,
            'package_id'         => $package->id,
            'tran_id'            => strtoupper(substr($package->name, 0, 3)) . $package->id . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT),
            'status'             => 'pending',
            'payment_status'     => 'pending',
            'total_payable'      => $package->price, // total package price
            'updated_by'         => null,
            'title'              => 'subscription',
        ]);

        foreach ($package->package_details as $detail) {
            $userSubscriptionDetails = UserSubscriptionDetails::create([
                'package_details_id'   => $detail->id,
                'user_subscription_id' => $userSubscription->id,
                'exam_id'              => $detail->exam_id,
                'max_exam_attempt'     => $detail->max_exam_attempt,
            ]);
        }

        return $sslController->payNow($userSubscription);
    }

    
    // Attend exam
    public function attendExam(PackageDetail $detail)
    {
        $subscription = UserSubscription::where('user_id', Auth::id())
            ->where('package_details_id', $detail->id)
            ->first();

        if ($subscription->count >= $detail->max_exam_attempt) {
            return redirect()->back()->withErrors(['error' => 'Your exam limit for this subject has expired.']);
        }

        $subscription->increment('count');
        return redirect()->back()->with('success', 'Exam attended successfully');
    }
}
