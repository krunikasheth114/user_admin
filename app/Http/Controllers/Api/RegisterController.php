<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyUser;

class RegisterController extends BaseController
{
    public function Register(Request $request)
    {

        $user = new User;
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->category_id = $request->input('category');
        $user->subcategory_id = $request->input('subcategory');
        $imageName = time() . '.' . $request->profile->extension();
        $request->profile->move(public_path('images'), $imageName);
        $user->profile = $imageName;
        $user->otp = random_int(1000, 9999);
        $user->password = Hash::make($request->input('password'));
        $user->save();
        $user['token'] =  $user->createToken('task2')->accessToken['token'];
        $id = $user->id; // Get current user id
        Mail::to($user->email)->send(new VerifyUser($user->otp));
        return $this->sendResponse($user, 'User register successfully.');
    }
}
