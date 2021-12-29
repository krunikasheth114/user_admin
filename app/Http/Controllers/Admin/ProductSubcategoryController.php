<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\Product_subcategoryDataTable;
use App\Http\Requests\Product_subcategoryRequest;
use App\Models\Product_subcategory;
use App\Models\Product_category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductSubcategoryController extends Controller
{
    public function index(Product_subcategoryDataTable $datatable)
    {
        $category = Product_category::get(['name', 'id']);
        return $datatable->render('admin.product_subcategory.index', compact('category'));
    }
    public function store(Product_subcategoryRequest $request)
    {

        $subcategory = new Product_subcategory;
        $subcategory->name = $request->input('subcategory_name');
        $subcategory->category_id = $request->input('category');
        $subcategory->save();
        return response()->json(['status' => true, 'data' => $subcategory, 'message' => "Sub-Category Added Succesfully"]);
    }
    public function changeStatus(Request $request)
    {

        $data = Product_subcategory::where('id', $request->id)->update(['status' => $request->status]);
        return response()->json(['status' => true, 'data' => $data, 'messages' => 'Status Changed succsessfully']);
    }
    public function edit(Request $request)
    {

        $data = Product_subcategory::find($request->id);
        return response()->json(['status' => true, 'data' => $data]);
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'subcategory_name' => [
                'required', Rule::unique('product_sub_categories', 'name')->ignore($id)->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_name);
                }),
            ]
        ]);
        $data = Product_subcategory::find($id);
        $data->category_id = $request->input('category_name');
        $data->name = $request->input('subcategory_name');
        $data->update();
        return response()->json(['status' => true, 'message' => 'Update Success']);
    }
    public function delete(Request $request)
    {

        $data = Product_subcategory::find($request->id);
        $data->delete();
        return response()->json(['status' => true, 'message' => "Delete Successfully"]);
    }
}
