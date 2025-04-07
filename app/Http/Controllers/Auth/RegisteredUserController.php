<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use App\Mail\SendOtpMail; // Import the OTP email mailable

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validate user input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile picture upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_picture' => $profilePicturePath,
        ]);

        // Automatically create a wallet for the user
        Wallet::create([
            'user_id' => $user->id,
            'total_balance' => 0,
            'available_balance' => 0,
            'invested_amount' => 0,
            'pending_funds' => 0
        ]);

        // Fire the Registered event
        event(new Registered($user));

        // Generate and save OTP
        $otp = strtoupper(Str::random(6)); // You can also use a numeric OTP if preferred
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10); // Set OTP expiration time
        $user->save();

        // Send OTP email
        Mail::to($user->email)->send(new SendOtpMail($otp));

        // Store user's email in session
        session(['email' => $user->email]);

        // Redirect to OTP verification page
        return redirect()->route('otp.verify')->with('success', 'OTP sent to your email. Please verify.');
    }
}