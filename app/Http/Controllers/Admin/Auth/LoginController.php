<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "Admin/dashboard";

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    protected function attemptlogin(Request $request)
    {
        // $data = $request->validated();
        Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password]);
        return $this->guard('admin')->attempt(
                $this->credentials($request),
              
            );
        if (Auth::guard('admin')->check()) {

            return redirect()->route('dashboard');
        } else {
            return redirect()->route('admin.login');
        }

        
    }

    public function logout(Request $request)
    {
       
        $this->guard()->logout();
        return redirect()->route('admin.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
    
}



