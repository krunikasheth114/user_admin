<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog_category;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;



class CreateblogController extends Controller
{
    public function index(Request $request)
    {
        #BlogCategory
        $category = Blog_category::where('status', 1)->get(['category', 'id']);
        return view('user.blog.createblog', compact('category'));
    }
    public function store(BlogRequest $request)
    {
        $store = new Blog;
        $store->category_id = $request->input('category_id');
        $store->user_id = $request->user_id;
        $store->title = $request->input('title');
        $store->slug = str_slug($store->title);
        $store->description = $request->input('description');
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $store->image = $imageName;
        $store->save();
        return redirect()->route('dashboard')->with('success', "Your Blog is created");
    }

    public function edit($id)
    {

        $blogs = Blog::where('user_id', $id)->get();

        $category = Blog_category::get(['category', 'id']);
        return view('user.blog.editblog', compact('blogs', 'category'));
    }
    public function update(Request $request, $slug)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        $update = Blog::where('slug', $slug)->get();
        foreach ($update as $u) {
            $u->category_id = $request->input('category_id');
            $u->title = $request->input('title');
            $u->description = $request->input('description');
            if (isset($request->image)) {
                $image = $request->image;
                $destinationPath = public_path('images/');
                if (!empty($u->image)) {
                    $file_old = $destinationPath . $u->image;
                    unlink($file_old);
                }
                $imageName = date('YmdHis') . "." . $image->extension();
                $image->move($destinationPath, $imageName);
                $u->image = $imageName;
            }
            $u->update();
        }
        return redirect()->route('blog.edit', Auth::user()->id)->with("success", "Your Blog is Updated");
    }
    public function delete(Request $request, $slug)
    {
        $delete = Blog::where('slug', $slug)->get();
        foreach ($delete as $del) {
            $del->delete();
        }
        return redirect()->route('blog.edit', Auth::user()->id)->with("success", "Your Blog is Deleted");
    }
}
