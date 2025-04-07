<?php

// app/Http/Middleware/IsAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and has an is_admin flag
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Redirect to home page or show unauthorized access message
        return redirect('/')->with('error', 'Unauthorized access');
    }
}
