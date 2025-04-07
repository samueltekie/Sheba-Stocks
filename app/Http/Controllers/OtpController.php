<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Mail\SendOtpMail;

class OtpController extends Controller
{
    public function showVerificationForm()
    {
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate(['otp' => 'required|string']);

        $user = User::where('email', session('email'))->first();

        if (!$user) {
            return redirect()->route('otp.verify')->with('error', 'User not found.');
        }

        // Check if the OTP matches and is still valid
        if ($user->otp === $request->otp && Carbon::now()->lessThanOrEqualTo($user->otp_expires_at)) {
            // Mark email as verified
            $user->email_verified_at = Carbon::now();
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();

            // Redirect the user to the login page with a success message
            return redirect()->route('login')->with('success', 'Email verified successfully. Please log in.');
        }

        // If the OTP is incorrect or expired
        return redirect()->route('otp.verify')->with('error', 'Invalid or expired OTP. Please try again.');
    }
    public function resendOtp(Request $request)
    {
        $user = User::where('email', session('email'))->first();

        if (!$user) {
            return redirect()->route('otp.verify')->with('error', 'User not found.');
        }

        // Generate and save a new OTP
        $otp = Str::random(6); // You can use numeric OTP if needed
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10); // Set new OTP expiration time
        $user->save();

        // Send the new OTP via email
        Mail::to($user->email)->send(new SendOtpMail($otp));

        return redirect()->route('otp.verify')->with('success', 'A new OTP has been sent to your email.');
    }

}