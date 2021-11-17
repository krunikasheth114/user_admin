<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Like;

class ViewblogController extends Controller
{
    public function index(Request $request, $slug)
    {
        $view = Blog::where('slug', $slug)->get();

        return view('user.blog.viewblog', compact('view'));
    }
    public function like(Request $request)
    {
        $like = Like::where('blog_id', $request->id)->where('user_id', \Auth::user()->id)->first();

        if (empty($like)) {
            $like = Like::create(['blog_id' => $request->id, 'user_id' => \Auth::user()->id]);

            return response()->json(['status' => true, 'data' => $like]);
        } else {
            $like->delete();

            return response()->json(['status' => false, 'data' => '']);
        }
    }
}
