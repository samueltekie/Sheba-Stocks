<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        // Add debugging line
        dd('Logged in as: ', $user->email, 'is_admin:', $user->is_admin);

        if ($user->email === 'samueltekie203@gmail.com') {
            return redirect()->route('samuel.view');
        }

        if ($user->is_admin == 1) {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome, Admin!');
        }

        return redirect()->route('stocks.list')->with('success', 'Login successful');
    }

    return redirect()->back()->withErrors(['email' => 'Invalid credentials or email not verified']);
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}