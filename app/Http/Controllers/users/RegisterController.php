<?php

namespace App\Http\Controllers\users;

use Mail;
use App\Mail\Welcome;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\DataTables\users\UserDataTable;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use Illuminate\Support\Facades\DB;
use App\Models\View;
use App\Models\Blog_category;
use App\Jobs\RegisterUserEmail;

class RegisterController extends Controller
{

    public function Register(Request $request)
    {
        if (Auth::check()) {
            return view('user.index');
        } else {
            $data = Category::where('status', 1)->get(['category_name', 'id']);
            return view('user.register', ['data' => $data]);
        }
    }


    public function getcat(Request $request)
    {
        $data = Subcategory::where('category_id', $request->catId)
            ->where('status', 1)
            ->get(['subcategory_name', 'id']);

        return response()->json(['status' => true, 'data' => $data]);
    }

    public function store(Request $request)
    {

        // dd($request->all());
        // $validatedData = $request->validated();
        $validatedData = new User;
        $validatedData->firstname = $request->input('firstname');
        $validatedData->lastname = $request->input('lastname');
        $validatedData->email = $request->input('email');
        $validatedData->category_id = $request->input('category');
        $validatedData->subcategory_id = $request->input('subcategory');
        $imageName = time() . '.' . $request->profile->extension();
        $request->profile->move(public_path('images'), $imageName);
        $validatedData->profile = $imageName;
        $validatedData->otp = random_int(1000, 9999);
        $validatedData->password = Hash::make($request->input('password'));
        $validatedData->stripe_cusid = 0;
        $validatedData->save();
        $id = $validatedData->id; // Get current user id

        // $customer = $stripe->customers->create([
        //     'name' => $request->nameoncard,
        //     'email' => $request->email,
        // ]);
        // $cusId = $customer->id;
        // User::where('id', $id)->update([
        //     'stripe_cusid' => $cusId
        // ]);
        RegisterUserEmail::dispatch($validatedData)->delay(now()->addMinutes(1));
        return response()->json(['status' => true, 'data' => $validatedData, 'message' => "Mail sent", 'id' => $id]);
    }

    public function showotpRegister(Request $request, $id)
    {
        $user = User::find($id);
        return view('user.verify_user', compact('user'));
    }

    public function showotpLogin(Request $request, $id)
    {
        $user = User::find($id);
        $user->otp = random_int(1000, 9999);
        $user->update();

        Mail::to($user->email)->send(new Welcome($user->otp));
        return view('user.verify_user', compact('user'));
    }
    public function  VerifyUser(Request $request)
    {
        $data = User::find($request->id);
        $otp = $data->otp;
        $get_user_otp = $request->input('otp');

        if ($otp === (int)$get_user_otp) {
            $data->is_verify = '1';
            $data->update();
            return response()->json(['status' => true, 'data' => $data, 'message' => 'Account verified']);
        } else {
            return response()->json(['status' => false, 'message' => 'Please Enter Correct Otp']);
        }
    }

    public function home(Request $request)
    {
        $blog = Blog::get();
        $blog_view = DB::table('blogs')
            ->leftJoin('views', 'blogs.id', '=', 'views.blog_id')
            ->count();
        $blogs = Blog::latest('created_at')->take(5)->get();
        $category = Blog_category::get(['category', 'id']);

        return view('user.index', compact('blog', 'blog_view', 'blogs', 'category'));
    }
}
