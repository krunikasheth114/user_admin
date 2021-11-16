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
                \Auth::logout();    
                return redirect()->route('user.login')->with('danger','
                Accouts has been blocked contact to admin!');
            } elseif (Auth::user()->is_verify == 0) {
                // dd('dsfsdfdsf');
                return redirect()->route('user.verify_user', Auth::user()->id)->with('danger', 'Otp sent On Your Registerd Email');
            } else {
                return $next($request);
            }
        }
    }
}
