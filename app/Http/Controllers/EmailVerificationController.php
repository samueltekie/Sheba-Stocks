<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EmailVerificationController extends Controller
{
    public function sendOtp(Request $request)
    {
        $user = auth()->user();

        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10); // OTP valid for 10 minutes

        // Store OTP in the database
        EmailVerification::updateOrCreate(
            ['user_id' => $user->id],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        // Send OTP via email
        Mail::raw("Your OTP for email verification is: $otp", function ($message) use ($user) {
            $message->to($user->email)->subject('Email Verification OTP');
        });

        return response()->json(['message' => 'OTP sent to your email.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $user = auth()->user();
        $otpRecord = EmailVerification::where('user_id', $user->id)->first();

        if (!$otpRecord || $otpRecord->otp !== $request->otp) {
            return response()->json(['error' => 'Invalid OTP'], 422);
        }

        if (Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return response()->json(['error' => 'OTP has expired'], 422);
        }

        // Mark user as email verified (optional)
        $user->email_verified_at = now();
        $user->save();

        // Delete the OTP record after successful verification
        $otpRecord->delete();

        return response()->json(['message' => 'Email verified successfully.']);
    }
}
