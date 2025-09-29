<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CandidateRequest;
use App\Jobs\SendRegistrationEmail;
use App\Jobs\SendRegistrationEmailJob;
use App\Models\Booking;
use App\Models\Candidate;
use App\Notifications\CandidateNotification;
use App\Services\FileStorageService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CandidateController extends Controller
{

    public $fileStorageService;
    public function __construct(FileStorageService $file_storage_service)
    {
        $this->fileStorageService = $file_storage_service;
    }

    public function register(CandidateRequest $request)
    {
        $data = $request->validated();

        try {
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');

                $imageUploadResponse = $this->fileStorageService->uploadImageToCloud($image, 'candidate');
                $data['photo'] = $imageUploadResponse['public_path'];
            }

            // phone number needs to sanitize
            $plainPassword = (string) random_int(100000, 999999);
            $data['password'] = bcrypt($plainPassword);

            $candidate = Candidate::create($data);

            //send congratulation email with password
            dispatch(new SendRegistrationEmailJob($candidate, $plainPassword));

            return $this->responseWithSuccess($candidate, "Candidate registered successfully", 201);
        } catch (Throwable $e) {
            return $this->responseWithError($e->getMessage(), 'Something went wrong.');
        }
    }


    public function doLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError('Something went wrong.', $validator->getMessageBag());
        }

        $candidate = Candidate::where('email', $request->email)->first();

        if ($candidate && $candidate->status == 'active' && Hash::check($request->password, $candidate->password)) {
            try {
                $token = JWTAuth::fromUser($candidate);

                return response()->json([
                    'data' => $candidate,
                    'message' => 'Login successful',
                    'token' => $token,
                ]);
            } catch (JWTException $e) {
                return $this->responseWithError('Could not create token.', $e->getMessage());
            }
        } 
        elseif($candidate && $candidate->status == 'frozen'){
            return $this->responseWithError('Your account is frozen. Please contact with administrator.');
        }
        else {
            return $this->responseWithError('Invalid credentials');
        }
    }

    public function logout()
    {
        Auth::guard('candidate')->logout();
        return $this->responseWithSuccess([], 'Logout successful');
    }

    public function profile()
    {
        $candidate = Candidate::find(auth('candidate')->user()->id);

        return $this->responseWithSuccess($candidate, 'Candidate Profile.');
    }

    public function dashboard()
    {

        $summary = Booking::selectRaw("
            COUNT(*) as total_bookings,
            COUNT(CASE WHEN payment_status = 'success' THEN 1 END) as total_success_payments,
            COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_booking,
            COUNT(CASE WHEN result > 0 THEN 1 END) as total_results_published
        ")->where('candidate_id',auth('candidate')->user()->id)
            ->first();

        $data = [
            'total_bookings' => $summary->total_bookings,
            'total_success_payments' => $summary->total_success_payments,
            'pending_booking' => $summary->pending_booking,
            'total_results_published' => $summary->total_results_published,
        ];

        return $this->responseWithSuccess($data, 'Candidate Dashboard.');
    }


    public function update(CandidateRequest $request)
    {
        $candidate = Candidate::findOrFail(auth('candidate')->user()->id);

        // Get validated data from CandidateRequest
        $data = $request->validated();

        // Handle photo upload/update
        if ($request->hasFile('photo')) {
            if ($candidate->photo) {
                // Update existing file in cloud
                $newFile = $request->file('photo');
                $fileToDelete = $candidate->photo;
                $imageUploadResponse = $this->fileStorageService->updateFileFromCloud($fileToDelete, $newFile);
                $data['photo'] = $imageUploadResponse['public_path'];
            } else {
                // Upload new image
                $image = $request->file('photo');
                $imageUploadResponse = $this->fileStorageService->uploadImageToCloud($image, 'candidate');
                $data['photo'] = $imageUploadResponse['public_path'];
            }
        }

        // Update candidate
        $candidate->update($data);

        return $this->responseWithSuccess($candidate, 'Candidate profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $candidate = Candidate::findOrFail(auth('candidate')->user()->id);

        // Validate input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed', // Must match new_password_confirmation
        ]);

        // Optional: Verify current password
        if (!Hash::check($request->input('current_password'), $candidate->password)) {
            return $this->responseWithError('Current password is incorrect.');
        }

        // Update password
        $candidate->password = Hash::make($request->input('new_password'));
        $candidate->save();

        return $this->responseWithSuccess($candidate, 'Candidate password updated successfully.');
    }

    public function verifyPhoneNumber(): JsonResponse
    {

        try {
            $candidate = auth('candidate')->user();

            if ($candidate->is_phone_verified) {

                return $this->responseWithError('Mobile number already verified.', ["Already Verified."]);
            } elseif ($candidate->otp && $candidate->otp_expired_at > now()) {

                return $this->responseWithError('OTP already sent. Please Check Your Mobile.', ['otp_expired_at'=>$candidate->otp_expired_at]);
            } else {

                $otp = rand(100000, 999999);
                $candidate->update([
                    'otp' => $otp,
                    'otp_expired_at' => Carbon::now()->addMinutes(3),
                ]);

                //for now sending otp to email- it should be using sms

                Mail::send([], [], function ($message) use ($candidate) {
                    $message->to($candidate->email)
                        ->subject("JPT-BD Phone verification code.")
                        ->html('<h1>Welcome!</h1><p>Your mobile OTP is: ' . $candidate->otp . '.</p>');
                });

                return $this->responseWithSuccess($candidate, "OTP sent to your mobile number.");
            }
        } catch (Throwable $ex) {
            return $this->responseWithError($ex->getMessage(), "Something went wrong.");
        }
    }


    public function postVerifyPhoneNumber(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return $this->responseWithError('OTP is required.', $validator->getMessageBag());
        }

        $candidate = Candidate::where('otp', $request->otp)->first();

        if ($candidate) {

            if (!$candidate->is_phone_verified) {

                if ($candidate->otp_expired_at > now()) {

                    $candidate->update([
                        'otp' => null,
                        'otp_expired_at' => null,
                        'is_phone_verified' => 1
                    ]);


                    $data=[
                    'title'=>"Phone Verification Success",
                    'message'=>"Your phone numbner verified successfully. Now you can place booking. ",
                    'url'=>'',

                ];
                $candidate->notify(new CandidateNotification($data));

                    return $this->responseWithSuccess($candidate, 'Verification success.');
                }

                return $this->responseWithError('OTP Expired.', ['please resend OTP']);
            }
            return $this->responseWithError('Aleady verified.');
        }

        return $this->responseWithError('Invalid OTP');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:candidates,email',
        ]);

        $email = $request->input('email');
        $candidate = Candidate::where('email', $email)->first();
        if(!$candidate)
        {
            return $this->responseWithError('Account not found or Inactive',[]);
        }

        if (
            $candidate->token &&
            $candidate->token_expired_at &&
            Carbon::parse($candidate->token_expired_at)->isFuture()
        ) {
            return $this->responseWithError('A reset link was already sent. Please wait before requesting again.',[]);
        }

        $token = Str::random(120);
        $expiry = Carbon::now()->addMinutes(3);
        $resetLink = config('app.frontend.url') . '/password-reset?token=' . $token;

        DB::beginTransaction();

        try {
            $candidate->token = $token;
            $candidate->token_expired_at = $expiry;
            $candidate->save();

            //need to put job
            
            Mail::send('emails.forgot-password', [
                'resetLink' => $resetLink,
                'candidate_name' => $candidate->first_name
            ], function ($message) use ($email) {
                $message->to($email)
                    ->subject('Password Reset Request');
            });

            DB::commit();

            return $this->responseWithSuccess([], 'Reset link sent to your email.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to send reset email: ' . $e->getMessage());
            return $this->responseWithError('Failed to send reset email. Please try again later.', ['exception' => $e->getMessage()]);
        }
    }


    public function updatePasswordUsingResetLink(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:120',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $token = $request->input('token');

        $candidate = Candidate::where('token', $token)
            ->where('token_expired_at', '>', now())
            ->first();

        if (!$candidate) {
            return response()->json(['message' => 'Invalid or expired token.'], 400);
        }

        $candidate->password = Hash::make($request->input('password'));

        $candidate->token = null;
        $candidate->token_expired_at = null;

        $candidate->save();

        return $this->responseWithSuccess(['message' => 'Password updated successfully.',]);
    }
}
