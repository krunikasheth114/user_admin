<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
     public function Login(Request $request)
     {
        Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password]);
        if (Auth::guard('web')->check()) {
            $user = Auth::user(); 
            $user->token =  $user->createToken('task2')->accessToken;
            return $this->sendResponse($user, 'User login successfully.');
        } else {
            
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
     }
}
