<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckSessionTimeout
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Session::has('lastActivity')) {
            $timeout = config('session.lifetime') * 60; 

            if (time() - Session::get('lastActivity') > $timeout) {
                Auth::logout(); // Log out the user
                return redirect()->route('login')->with('status', 'You have been logged out due to inactivity.');
            }
        }

        Session::put('lastActivity', time()); // Update last activity time

        return $next($request);
    }
}
