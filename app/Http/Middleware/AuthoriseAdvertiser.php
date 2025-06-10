<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthoriseAdvertiser
{
    /**
     * Check if authenticated user account type is Advertiser and only then let it to access the route
     * Not authorised user is returned back to the original route which belongs to that customer
     * Not authenticated user is returned back to the login page
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {

            // Advertiser user type = 1
            // Business customer user type = 2

            if(Auth::user()->account_type === 1) {
                return $next($request);
            } else {
                return redirect('/business')->with('not-advertiser-alert', 'You are not advertiser customer');
            }
        } else {
            return redirect('login')->with('message', 'Login first to access this page');
        }

        return $next($request);
    }
}
