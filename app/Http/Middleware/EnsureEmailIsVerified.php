<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && is_null(auth()->user()->email_verified_at)) {
            return redirect()->route('otp.verify')->with('error', 'Please verify your email first.');
        }

        return $next($request);
    }
}