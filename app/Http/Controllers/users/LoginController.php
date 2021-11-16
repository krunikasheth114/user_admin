<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Mail;
use App\Mail\Forgetpass;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "dashboard";

    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        $this->middleware('guest:web')->except('logout');
    }

    public function showLoginForm()
    {
        return view('user.login');
    }


    public function Login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password]);
        if (Auth::guard('web')->check()) {

            return redirect()->route('dashboard');
        } else {

            return redirect()->route('user.login')->with('danger', 'Invalid credentials');
        }
    }

    public function logout(Request $request)
    {
        $this->guard('web')->logout();
        return redirect()->route('user.login');
    }


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    // public function register()
    // {

    //     return view('user.register');
    // }


    public function  showEmail(Request $request)
    {

        return view('user.get_email');
    }
    public function  getEmail(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!empty($user)) {
            if ($request->email === $user->email) {
                $user->otp = random_int(1000, 9999);
                $user->update();
                Mail::to($request->email)->send(new Forgetpass($user->otp));
                return response()->json(['status' => true, 'data' => $user, 'message' => 'Otp Successfully Sent On Your Mail']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please Enter registerd Email']);
        }
    }
    public function get_otp($id)
    {
        return view('user.get_otp', compact('id'));
    }
    public function verify_otp(Request $request)
    {
        $data = User::find($request->id);
        $otp = $data->otp;
        $get_user_otp = $request->input('otp');
        if ($otp === (int)$get_user_otp) {
            return response()->json(['status' => true, 'data' => $data, "message" => "Account verified now you can change Your Password"]);
        } else {
            return response()->json(['status' => false, 'message' => 'Please Enter Correct Otp']);
        }
    }
    public function reset_pass($id)
    {
        return view('user.reset_pass', compact('id'));
    }

    public function confirm_pass(Request $request)
    {

        $get_user_pass = User::find($request->id);
        $get_user_pass->password = Hash::make($request->input('pass'));
        $get_user_pass->update();
        return response()->json(['status' => true, 'data' => $get_user_pass, "message" => "Your Password is now changed"]);
    }
}
