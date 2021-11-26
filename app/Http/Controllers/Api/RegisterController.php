<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyUser;
use App\Models\Blog;

class RegisterController extends BaseController
{
    public function Register(RegisterRequest $request)
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
        $user['token'] =  $user->createToken('task2')->accessToken;
        $id = $user->id; // Get current user id
        Mail::to($user->email)->send(new VerifyUser($user->otp));
        return $this->sendResponse($user, 'User register successfully.');
    }
    public function home(Request $request)
    {
        $blog = Blog::get();
        if (!empty($blog)) {
            $blog_view = DB::table('blogs')
                ->leftJoin('views', 'blogs.id', '=', 'views.blog_id')
                ->count();
            $data = [$blog, $blog_view];
            return $this->sendResponse($data, 'data-list');
        } else {
            return $this->sendError($blog, 'Data not found');
        }
    }
}
