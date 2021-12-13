<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\SubCategoryDataTable;
use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Requests\SubCategoryRequest;
use Illuminate\Validation\Rule;

class SubCategoryController extends Controller
{
    public function dataTable(SubCategoryDataTable $datatable)
    {
        $data = Category::get(['category_name', 'id']);

        return $datatable->render('admin.subcategory.index', compact('data'));
    }
    public function updatesubcategory(Request $request)
    {

        $id = $request->id;
      
        $request->validate([
            
            'subcategory_name' =>['required',Rule::unique('sub_categories', 'subcategory_name')->ignore($id)->where(function ($query) use ($request) {
                return $query->where('category_id', $request->category_name);
            }),
        ]]);
        $data = Subcategory::find($request->id);
        $data->category_id = $request->input('category_name');
        $data->subcategory_name = $request->input('subcategory_name');

        $data->update();
        return response()->json(['status' => true, 'message' => 'Update Success']);
    }

    public function showCategory()
    {
        $data = Category::Join('categories', function ($join) {
            $join->on('sub_categories.id', '=', 'categories.category_id');
        })
            ->whereNull('categories.category_id');

        return view('admin.subcategory.index', ['data' => $data]);
    }

    public function store(SubCategoryRequest $request)
    {

        $subcategory = new Subcategory;
        $subcategory->subcategory_name = $request->input('subcategory_name');
        $subcategory->category_id = $request->input('category');
        $subcategory->save();
        return response()->json(['status' => true, 'data' => $subcategory]);
    }
    public function changeStatus(Request $request)
    {
        //   dd($request->all());
        $data = Subcategory::where('id', $request->id)->update(['status' => $request->status]);
        return response()->json(['status' => true, 'data' => $data]);
    }
    public function edit(Request $request)
    {
        $data = Subcategory::find($request->id);
        return response()->json(['status' => true, 'data' => $data]);
    }
    public function deletecategory(Request $request)
    {
        $data = Subcategory::find($request->id);

        $data->delete();
        return response()->json(['status' => true, 'message' => "Delete Successfully"]);
    }
}
