<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::guard('web')->user()) {

            if (Auth::user()->status == 0) {

                return redirect()->route('user.login')->with('danger', 'Please Wait for admin to activate your account');
            } elseif (Auth::user()->is_verify == 0) {
                return redirect()->route('user.verify_user', Auth::user()->id)->with('danger', 'Otp sent On Your Registerd Email');
            }
        }
        return $next($request);
    }
}
