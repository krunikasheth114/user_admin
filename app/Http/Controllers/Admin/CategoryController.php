<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\DataTables\CategoryDataTable;
use App\Models\Category;

class CategoryController extends Controller
{

    public function dataTable(CategoryDataTable $datatable)
    {
        return $datatable->render('admin.category.index');
    }
    public function showCategory()
    {
        return view('admin.category.index');
    }
    public function store(CategoryRequest $request)
    {

       
        $validatedData = new Category;
        $validatedData->category_name = $request->input('category_name');
        $validatedData->save();
        return response()->json(['status' => true, 'data' => $validatedData]);
    }
    public function changeStatus(Request $request)
    {

        $data = Category::where('id', $request->id)->update(['status' => $request->status]);
        return response()->json(['status' => true, 'data' => $data , 'messages' => 'Status Changed succsessfully']);
    }

    public function getcategory(Request $request)
    {


        $data = Category::find($request->id);

        return response()->json(['status' => true, 'data' => $data]);;
    }

    public function updatecategory(Request $request)
    {
        $id = $request->id;
        // dd($id);
        $request->validate([
            'category_name' => 'required|unique:categories,category_name,' . $id,
        ]);
        $data = Category::find($request->id);
        $data->category_name = $request->input('category_name');

        $data->update();
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function deletecategory(Request $request)
    {
        $data = Category::find($request->id);
        $data->delete();
        return response()->json(['status' => true, 'message' => "Delete Successfully"]);
    }
}
