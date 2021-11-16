<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog_category;
use App\DataTables\Blog_categoryDataTable;
use App\DataTables\BlogDataTable;

class BlogController extends Controller
{
    public function blogCategory(Blog_categoryDataTable $datatable)
    {
        return $datatable->render('admin.blog-category.index');
    }
    public function changeStatus(Request $request)
    {

        $data = Blog_category::where('id', $request->id)->update(['status' => $request->status]);
        return response()->json(['status' => true, 'data' => $data]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|unique:blog_categories,category',
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

    public function blogList(BlogDataTable $datatable){
        return $datatable->render('admin.blog_list.index');
    }
}
