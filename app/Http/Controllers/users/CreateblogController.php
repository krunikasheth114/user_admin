<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog_category;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;


class CreateblogController extends Controller
{
    public function index(Request $request){
        
        $category=Blog_category::where('status', 1)->get(['category','id']);
        return view('user.blog.createblog',compact('category'));
    }
    public function store(BlogRequest $request){
    $store = new Blog;
    $store->category_id=$request->input('category_id');
    $store->user_id=$request->user_id;
    $store->title=$request->input('title');
    $store->description=$request->input('description');
    $imageName = time() . '.' . $request->image->extension();
    $request->image->move(public_path('images'), $imageName);
    $store->image = $imageName;
    $store->save();
    return redirect()->route('dashboard')->with('success',"Your Blog is created");
    }
}
