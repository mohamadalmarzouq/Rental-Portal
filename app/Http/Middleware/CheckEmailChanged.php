<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckEmailChanged
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
        // Check if user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->login_token == null)
            {

                Auth::logout();
                return redirect()->route('login')->with('error', 'Your email has been changed. Please log in again.');
            }
        }

        return $next($request);
    }
}
