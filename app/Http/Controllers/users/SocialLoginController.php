<?php

namespace App\Http\Controllers\users;
use App\Http\Controllers\users\LoginController;
use Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialLoginController extends Controller
{
    public function socialLogin($social)
    {
     
        return Socialite::driver($social)->redirect();
    }

       public function handleProviderCallback($social)
       {
           $userSocial = Socialite::driver($social)->user();

           $user = User::where(['email' => $userSocial->getEmail()])->first();
           if($user){
               Auth::login($user);
               return redirect()->action('HomeController@index');
           }else{
               return view('auth.register',['name' => $userSocial->getName(), 'email' => $userSocial->getEmail()]);
           }
        }
}
