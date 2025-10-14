<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\PackageDetail;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSubscriptionDetails;
use App\Notifications\CandidateNotification;
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
            'is_free' => $request->has('is_free') ? 1 : 0,
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
            'is_free' => $request->has('is_free') ? 1 : 0,
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
                    'price' => $package->is_free ? 'FREE' : 'BDT ' . (int)$package->price,
                    'short_description' => $package->short_description,
                    'description' => $package->description,
                    'status' => $package->status,
                    'is_popular' => $package->is_popular,
                    'is_home' => $package->is_home,
                    'is_free' => $package->is_free,
                    'sequence' => $package->order,
                    'package_details' => PackageDetailResource::collection($package->package_details),
                ];
            });

        return $this->responseWithSuccess($packages, 'Packages retrieved successfully');
    }

    // Initiate package payment (without renew)
    // public function subscribe(Request $request, SslCommerzPaymentController $sslController)
    // {
    //     $request->validate([
    //         'package_id' => 'required|exists:packages,id',
    //     ]);

    //     $candidate = Auth::guard('candidate')->user();
    //     if (!$candidate) {
    //         return $this->responseWithError('Unauthorized', 'Please log in to subscribe to a package', 401);
    //     }

    //     $package = Package::with('package_details.exam')->findOrFail($request->package_id);
    //     // Check if the candidate already has an active subscription for this package
                
    //     $existingSubscription = UserSubscription::where('candidate_id', $candidate->id)
    //         ->where('package_id', $package->id)
    //         ->whereIn('payment_status', ['success'])
    //         ->first();

    //         // return response()->json([$existingSubscription]);
    //     if ($existingSubscription) {
    //         return $this->responseWithError('Already Subscribed', 'You already have an active subscription for this package.', 400);
    //     }   

    //     // If the package is_free = true,
    //     $tranId = strtoupper(substr($package->name, 0, 3)) . $package->id . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

    //     if ($package->is_free) {

    //         // Create confirmed + success subscription immediately
    //         $userSubscription = UserSubscription::create([
    //             'candidate_id'   => $candidate->id,
    //             'package_id'     => $package->id,
    //             'tran_id'        => $tranId,
    //             'status'         => 'confirmed',
    //             'payment_status' => 'success',
    //             'total_payable'  => 0,
    //             'updated_by'     => null,
    //             'title'          => 'subscription',
    //         ]);

    //         // Create subscription details immediately (no payment)
    //         foreach ($package->package_details as $detail) {
    //             UserSubscriptionDetails::create([
    //                 'package_details_id'   => $detail->id,
    //                 'user_subscription_id' => $userSubscription->id,
    //                 'exam_id'              => $detail->exam_id,
    //                 'max_exam_attempt'     => $detail->max_exam_attempt,
    //             ]);
    //         }

    //         // Notify candidate
    //         $data = [
    //             'title'   => "Free Subscription Activated!",
    //             'message' => "Your free package '{$package->name}' has been successfully activated.",
    //             'url'     => '',
    //         ];
            
    //         $userSubscription->candidate->notify(new CandidateNotification($data));

    //         // Return success response (no SSL payment)
    //         return $this->responseWithSuccess('Free Subscription Activated Successfully', [
    //             'subscription_id' => $userSubscription->id,
    //             'package'         => $package->name,
    //         ]);
    //     }

    //     $userSubscription = UserSubscription::create([
    //         'candidate_id'       => $candidate->id,
    //         'package_id'         => $package->id,
    //         'tran_id'            => strtoupper(substr($package->name, 0, 3)) . $package->id . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT),
    //         'status'             => 'pending',
    //         'payment_status'     => 'pending',
    //         'total_payable'      => $package->price, // total package price
    //         'updated_by'         => null,
    //         'title'              => 'subscription',
    //     ]);

    //     // foreach ($package->package_details as $detail) {
    //     //     $userSubscriptionDetails = UserSubscriptionDetails::create([
    //     //         'package_details_id'   => $detail->id,
    //     //         'user_subscription_id' => $userSubscription->id,
    //     //         'exam_id'              => $detail->exam_id,
    //     //         'max_exam_attempt'     => $detail->max_exam_attempt,
    //     //     ]);
    //     // }

    //     return $sslController->payNow($userSubscription);
    // }

    //With renew & free package handling
    public function subscribe(Request $request, SslCommerzPaymentController $sslController)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $candidate = Auth::guard('candidate')->user();
        if (!$candidate) {
            return $this->responseWithError('Unauthorized', 'Please log in to subscribe to a package', 401);
        }

        $package = Package::with('package_details.exam')->findOrFail($request->package_id);

        // Find previous successful subscription (if any)
        $existingSubscription = UserSubscription::with('subscriptionDetails')
            ->where('candidate_id', $candidate->id)
            ->where('package_id', $package->id)
            ->where('payment_status', 'success')
            ->latest()
            ->first();

        // If the package is FREE
        if ($package->is_free) {
 
            // Block free re-subscription (only once)
            if ($existingSubscription) {
                return $this->responseWithError('Already Subscribed', 'You already activated this free package.', 400);
            }

            $tranId = strtoupper(substr($package->name, 0, 3)) . $package->id . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

            $userSubscription = UserSubscription::create([
                'candidate_id'   => $candidate->id,
                'package_id'     => $package->id,
                'tran_id'        => $tranId,
                'status'         => 'confirmed',
                'payment_status' => 'success',
                'total_payable'  => 0,
                'title'          => 'subscription',
            ]);

            foreach ($package->package_details as $detail) {
                UserSubscriptionDetails::create([
                    'package_details_id'   => $detail->id,
                    'user_subscription_id' => $userSubscription->id,
                    'exam_id'              => $detail->exam_id,
                    'max_exam_attempt'     => $detail->max_exam_attempt,
                    'used_exam_attempt'    => 0,
                ]);
            }

            // Notify candidate
            $successPath = config('app.frontend.payment_success') . '?subscription_id=' . $userSubscription->id . '&amount=' . '0' . '&tran_id=' . $tranId;

            $userSubscription->candidate->notify(new CandidateNotification([
                'title'   => "Free Subscription Activated!",
                'message' => "Your free package '{$package->name}' has been successfully activated.",
                'url'     => $successPath,
            ]));
            return response()->json([
                'status'          => 'success',
                'subscription_id' => $userSubscription->id,
                'package'         => $package->name,
                'url'             => $successPath,
            ]);
        }

        // PAID PACKAGE
        // $renewNotice = null;

        // if ($existingSubscription) {

        //     // Check exam attempts
        //     $details = $existingSubscription->subscriptionDetails->map(function ($detail) {
        //         $remaining = max($detail->max_exam_attempt - $detail->used_exam_attempt, 0);
        //         return [
        //             'exam_title' => $detail->exam->title,
        //             'max_attempts' => $detail->max_exam_attempt,
        //             'used_attempts' => $detail->used_exam_attempt,
        //             'remaining_attempts' => $remaining,
        //         ];
        //     });

        //     $remainingTotal = $details->sum('remaining_attempts');
        //     if ($remainingTotal > 0) {
        //         return response()->json([
        //             'status' => 'success',
        //             'message' => "You still have {$remainingTotal} remaining exam attempt(s). Renewing will reset your attempts.",
        //             'exam_summary' => $details,
        //         ]);
        //     }
        // }

        if ($existingSubscription) {
            return $this->responseWithError('Already Subscribed', 'You already have an active subscription for this package.', 400);
        }

        // Generate new transaction ID
        $tranId = strtoupper(substr($package->name, 0, 3)) . $package->id . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Create a new pending subscription
        $userSubscription = UserSubscription::create([
            'candidate_id'   => $candidate->id,
            'package_id'     => $package->id,
            'tran_id'        => $tranId,
            'status'         => 'pending',
            'payment_status' => 'pending',
            'total_payable'  => $package->price,
            'title'          => $existingSubscription ? 'renewal' : 'subscription',
        ]);

        $paymentResponse = $sslController->payNow($userSubscription);

        return response()->json($paymentResponse);
    }

    //ok using package id
    // public function renewSubscription(Request $request, SslCommerzPaymentController $sslController)
    // {
    //     $request->validate([
    //         'user_subscription_id' => 'required|exists:user_subscriptions,id',
    //         'confirm'    => 'nullable|boolean',
    //     ]);

    //     $candidate = Auth::guard('candidate')->user();
    //     if (!$candidate) {
    //         return $this->responseWithError('Unauthorized', 'Please log in to renew your package', 401);
    //     }

    //     $package = Package::with('package_details.exam')->findOrFail($request->package_id);

    //     // Find active subscription
    //     $existingSubscription = UserSubscription::with('subscriptionDetails.exam', 'package')
    //         ->where('candidate_id', $candidate->id)
    //         ->where('id', $request->user_subscription_id)
    //         ->where('payment_status', 'success')
    //         ->latest()
    //         ->first();

    //     // $existingSubscription = UserSubscription::with('subscriptionDetails.exam')
    //     //     ->where('candidate_id', $candidate->id)
    //     //     ->where('package_id', $package->id)
    //     //     ->where('payment_status', 'success')
    //     //     ->latest()
    //     //     ->first();

    //     if (!$existingSubscription) {
    //         return $this->responseWithError('No Active Subscription', 'You don’t have any active subscription to renew.', 400);
    //     }

    //     // Show awareness info if not confirmed yet
    //     if (!$request->confirm) {
    //         $details = $existingSubscription->subscriptionDetails->map(function ($detail) {
    //             $remaining = max($detail->max_exam_attempt - $detail->used_exam_attempt, 0);
    //             return [
    //                 'exam_title' => $detail->exam->title ?? 'Unknown',
    //                 'max_attempts' => $detail->max_exam_attempt,
    //                 'used_attempts' => $detail->used_exam_attempt,
    //                 'remaining_attempts' => $remaining,
    //             ];
    //         });

    //         $remainingTotal = $details->sum('remaining_attempts');

    //         return response()->json([
    //             'status' => 'awareness',
    //             'message' => "You still have {$remainingTotal} remaining exam attempt(s). Renewing will reset your attempts.",
    //             'exam_summary' => $details,
    //         ]);
    //     }

    //     // Proceed with actual renewal
    //     $tranId = strtoupper(substr($package->name, 0, 3)) . $package->id . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

    //     $userSubscription = UserSubscription::create([
    //         'candidate_id'   => $candidate->id,
    //         'package_id'     => $package->id,
    //         'tran_id'        => $tranId,
    //         'status'         => 'pending',
    //         'payment_status' => 'pending',
    //         'total_payable'  => $package->price,
    //         'title'          => 'renewal',
    //     ]);

    //     return response()->json($sslController->payNow($userSubscription));
    // }
    public function renewSubscription(Request $request, SslCommerzPaymentController $sslController)
    {
        $request->validate([
            'user_subscription_id' => 'required|exists:user_subscriptions,id',
            'confirm'             => 'nullable|boolean', // optional confirm flag
        ]);

        $candidate = Auth::guard('candidate')->user();
        if (!$candidate) {
            return $this->responseWithError('Unauthorized', 'Please log in to renew your package', 401);
        }

        // Get the existing subscription along with its package and details
        $existingSubscription = UserSubscription::with('subscriptionDetails.exam', 'package')
            ->where('candidate_id', $candidate->id)
            ->where('id', $request->user_subscription_id)
            ->where('payment_status', 'success')
            ->first();

        if (!$existingSubscription) {
            return $this->responseWithError('No Active Subscription', 'You don’t have any active subscription to renew.', 400);
        }

        $package = $existingSubscription->package;

        if (!$package) {
            return $this->responseWithError('Package Not Found', 'The linked package does not exist.', 404);
        }

        // Check remaining exam attempts
        $details = $existingSubscription->subscriptionDetails->map(function ($detail) {
            $remaining = max($detail->max_exam_attempt - $detail->used_exam_attempt, 0);
            return [
                'exam_title' => $detail->exam->title ?? 'Unknown',
                'max_attempts' => $detail->max_exam_attempt,
                'used_attempts' => $detail->used_exam_attempt,
                'remaining_attempts' => $remaining,
            ];
        });

        $remainingTotal = $details->sum('remaining_attempts');

        // If user has remaining attempts and did not confirm yet, return awareness message
        if ($remainingTotal > 0 && !$request->confirm) {
            return response()->json([
                'status' => 'awareness',
                'message' => "You still have {$remainingTotal} remaining exam attempt(s). Renewing will reset your attempts.",
                'exam_summary' => $details,
            ]);
        }

        // Generate new transaction ID for renewal
        $tranId = strtoupper(substr($package->name, 0, 3)) . $package->id . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // $tranId = strtoupper(substr($package->name, 0, 3)) . $package->id . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Create a new pending subscription for renewal
        $userSubscription = UserSubscription::create([
            'candidate_id'   => $candidate->id,
            'package_id'     => $package->id,
            'tran_id'        => $tranId,
            'status'         => 'pending',
            'payment_status' => 'pending',
            'total_payable'  => $package->price,
            'title'          => 'renewal',
        ]);

        // Trigger SSL payment
        $paymentResponse = $sslController->payNow($userSubscription);
        return response()->json($paymentResponse);

        // return response()->json($sslController->payNow($userSubscription));
    }

















    // public function renewSubscription(Request $request, SslCommerzPaymentController $sslController)
    // {
    //     $request->validate([
    //         'package_id' => 'required|exists:packages,id',
    //     ]);

    //     $candidate = Auth::guard('candidate')->user();
    //     if (!$candidate) {
    //         return $this->responseWithError('Unauthorized', 'Please log in to renew your package', 401);
    //     }

    //     $package = Package::with('package_details.exam')->findOrFail($request->package_id);

    //     // Find active subscription
    //     $existingSubscription = UserSubscription::where('candidate_id', $candidate->id)
    //         ->where('package_id', $package->id)
    //         ->where('payment_status', 'success')
    //         ->latest()
    //         ->first();

    //     if (!$existingSubscription) {
    //         return $this->responseWithError('No Active Subscription', 'You don’t have any active subscription to renew.', 400);
    //     }

    //     // Generate transaction ID for renewal
    //     $tranId = strtoupper(substr($package->name, 0, 3)) . $package->id . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

    //     // Create a new pending subscription for renewal
    //     $userSubscription = UserSubscription::create([
    //         'candidate_id'   => $candidate->id,
    //         'package_id'     => $package->id,
    //         'tran_id'        => $tranId,
    //         'status'         => 'pending',
    //         'payment_status' => 'pending',
    //         'total_payable'  => $package->price,
    //         'title'          => 'renewal',
    //     ]);

    //     // Directly start payment
    //     return response()->json($sslController->payNow($userSubscription));
    // }




    
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
