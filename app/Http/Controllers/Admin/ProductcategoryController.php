<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Product_categoryRequest;
use App\DataTables\Product_categoryDataTable;
use App\Models\Product_category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductcategoryController extends Controller
{
    public function index(Product_categoryDataTable $datatable)
    {

        return $datatable->render('admin.product_category.index');
    }
    public function store(Product_categoryRequest $request)
    {

        $validatedData = new Product_category;
        $validatedData->name = $request->input('category_name');
        $validatedData->save();
        return response()->json(['status' => true, 'data' => $validatedData, 'message' =>"Category added Succesfully"]);
    }
    public function edit(Request $request)
    {
        $data = Product_category::find($request->id);
        return response()->json(['status' => true, 'data' => $data]);;
    }
    public function update(Request $request)
    {
        $id = $request->hidden_id;
        $request->validate([
            'category_name' => 'required|unique:product_categories,name,' . $id,
        ]);
        $data = Product_category::find($id);
        $data->name = $request->input('category_name');
        $data->update();
        return response()->json(['status' => true, 'data' => $data, 'message' => "Category Updated"]);
    }
    public function changeStatus(Request $request)
    {

        $data = Product_category::where('id', $request->id)->update(['status' => $request->status]);
        return response()->json(['status' => true, 'data' => $data , 'messages' => 'Status Changed succsessfully']);
    }
    public function delete(Request $request)
    {

        $data = Product_category::find($request->id);
        $data->delete();
        return response()->json(['status' => true, 'message' => "Delete Successfully"]);
    }
}
