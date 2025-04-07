<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check for specific admin credentials
        if ($request->email === 'admin1234@gmail.com' && $request->password === 'him12345') {
            // Manually log in the admin
            $admin = \App\Models\User::where('email', 'admin1234@gmail.com')->first();
            if ($admin) {
                Auth::login($admin);
                return redirect()->route('admin.dashboard'); // Redirect to the admin dashboard
            }
        }

        // Default login logic for other users if needed
        if (Auth::attempt($request->only('email', 'password'))) {
            // Redirect to the stock list after successful login
            return redirect()->route('stock.list'); // Ensure 'stock.list' route is correctly defined
        }

        // If the credentials don't match, redirect back with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}