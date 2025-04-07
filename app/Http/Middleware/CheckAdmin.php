<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        // Ensure the user is authenticated and has an 'is_admin' flag set to true
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Redirect to login with an error message for unauthorized access
        return redirect('/login')->with('error', 'Unauthorized access.');
    }
}