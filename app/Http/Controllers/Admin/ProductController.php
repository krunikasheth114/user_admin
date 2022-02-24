<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product_category;
use App\Models\Product_subcategory;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(ProductsDataTable $datatable)
    {
        $category = Product_category::get(['name', 'id']);
        $subcategory = Product_subcategory::get(['name', 'id']);
        return $datatable->render('admin.product.index', compact('category', 'subcategory'));
    }

    public function store(ProductRequest $request)
    {
        $data = new Product;
        $data->category_id = $request->input('category');
        $data->subcategory_id = $request->input('subcategory');
        $data->name = $request->input('product_name');
        $data->price = $request->input('price');
        if (isset($request->image)) {
            $image = $request->image;
            $destinationPath = public_path('images/');
            $profileImage = date('YmdHis') . "." . $image->extension();
            $image->move($destinationPath, $profileImage);
            $data->image = $profileImage;
        }
        $data->save();
        return response()->json(['status' => true, 'message' => 'Product Added']);
    }

    public function changeStatus(Request $request)
    {
        $data = Product::where('id', $request->id)->update(['status' => $request->status]);
        return response()->json(['status' => true, 'data' => $data, 'messages' => 'Status Changed succsessfully']);
    }

    public function edit(Request $request)
    {
        $data['product'] = Product::find($request->id);
        $data['Category'] = Product_category::get(['name', 'id']);
        $data['subcategory'] = Product_subcategory::get(['name', 'id']);
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function update(Request $request)
    {
        $id = $request->hidden_id;
        $request->validate([
            'category' => 'required',
            'subcategory' => 'required',
            'product_name'  => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data = Product::find($id);
        $data->category_id = $request->input('category');
        $data->subcategory_id = $request->input('subcategory');
        $data->name = $request->input('product_name');
        $data->price = $request->input('price');
        if (isset($request->image)) {
            $image = $request->image;
            $destinationPath = public_path('images/');
            if (!empty($data->image)) {
                $file_old = $destinationPath . $data->image;
                unlink($file_old);
            }
            $profileImage = date('YmdHis') . "." . $image->extension();
            $image->move($destinationPath, $profileImage);
            $data->image = $profileImage;
        }
        $data->update();
        return response()->json(['status' => true, 'message' => 'Update Success']);
    }

    public function delete(Request $request)
    {
        $data = Product::find($request->id);

        $data->delete();
        return response()->json(['status' => true, 'message' => "Delete Successfully"]);
    }
    
}
