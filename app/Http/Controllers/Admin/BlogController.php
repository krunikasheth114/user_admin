<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog_category;
use App\DataTables\Blog_categoryDataTable;
use App\DataTables\BlogDataTable;
use App\DataTables\LikeDataTable;
use App\DataTables\CommentDataTable;
use App\Models\Blog;

class BlogController extends Controller
{
    public function blogCategory(Blog_categoryDataTable $datatable)
    {
        return $datatable->render('admin.blog-category.index');
    }
    public function changeStatus(Request $request)
    {

        $data = Blog_category::where('id', $request->id)->update(['status' => $request->status]);
        return response()->json(['status' => true, 'data' => $data , 'messages' => 'Status Changed succsessfully' ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|unique:blog_categories,category,NULL,id,deleted_at,NULL',
        ]);
        $catgeory = Blog_category::create([
            'category' => $request->input('category'),
        ]);
        return response()->json(['status' => true, 'data' => $catgeory, 'message' => 'Category added successfully']);
    }
    public function edit(Request $request)
    {
        $edit = Blog_category::find($request->id);
        return response()->json(['status' => true, 'data' => $edit]);;
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'category' => 'required|unique:blog_categories,category,' . $id,
        ]);
        $update = Blog_category::find($request->id);
        $update->category = $request->input('category');
        $update->update();
        return response()->json(['status' => true, 'data' => $update, 'messages' => 'Update Success']);
    }
    public function delete(Request $request)
    {
        $delete = Blog_category::find($request->id);
        $delete->delete();
        return response()->json(['status' => true, 'data' => $delete, 'message' => 'Category Deleted Successfully']);
    }

    public function blogList(BlogDataTable $datatable)
    {
        return $datatable->render('admin.blog_list.index');
    }
    public function blogLikes(LikeDataTable $datatable)
    {

        return $datatable->render('admin.blog_likes.index');
    }
    public function blogComment(CommentDataTable $datatable)
    {

        return $datatable->render('admin.blog_comment.index');
    }
    public function deletecomment(Request $request)
    {
        $delete = \App\Models\Comment::find($request->id);
        $delete->delete();
        return response()->json(['status' => true, 'data' => $delete, 'message' => 'Comment Deleted Successfully']);
    }
    public function deleteBlog(Request $request)
    {


        $delete = Blog::find($request->id);
        $delete->delete();
        return response()->json(['status' => true, 'data' => $delete, 'message' => 'Blog Deleted Successfully']);
    }
    public function editBlog(Request $request)
    {

        $data['blog'] = Blog::find($request->id);
        $data['category'] = Blog_category::get(['id', 'category']);
        return response()->json(['status' => true, 'data' => $data]);;
    }
    public function updateBlog(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image'=>' image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $data = Blog::find($request->id);
        $data->category_id = $request->input('category_id');
        $data->title = $request->input('title');
        $data->description = $request->input('description');
        if (isset($request->image)) {
            $image = $request->image;
            $destinationPath = public_path('images/');
            if (!empty($data->image)) {
                $file_old = $destinationPath . $data->image;
                unlink($file_old);
            }
            $imageName = date('YmdHis') . "." . $image->extension();
            $image->move($destinationPath, $imageName);
            $data->image = $imageName;
        }
        $data->update();
        return response()->json(['status' => true, 'data' => $data, 'message' => 'Data updated']);
    }
}
