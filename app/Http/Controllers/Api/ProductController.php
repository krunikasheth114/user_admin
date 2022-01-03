<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\ProductContract;
use App\Http\Controllers\Api\BaseController as  BaseController;
use App\Repositories\ProductRepository;
use App\Models\Product;
use App\Http\Requests\ProductRequest;

class ProductController  extends BaseController
{

    public function __construct(ProductContract $product)
    {
        $this->product = $product;
    }
    public function index()
    {
        $product = $this->product->getAll();
        return $this->sendResponse($product, 'Product details');
    }
    public function create(Request $request)
    {
        try {
            $product = $this->product->create($request->all());
        } catch (ValidationException|\Exception  $e) {

            return $this->sendError($e, 'Something Went Wrong');
        }
        return $this->sendResponse($product, 'Product Crearted');
    }
    public function edit(Product $product)
    {
        try {
            $product = $this->product->edit($id);
        } catch (\Exception $e) {
            return $this->sendError($e, 'data not found');
        }
        return $this->sendResponse($product, 'Product-detail');
    }
    public function update(Request $request, $id)
    {
        $data = $request->all();
        try {
            $product = $this->product->update($data, $id);
        } catch (\Exception $e) {
            return $this->sendError($e, 'Something Went Wrong');
        }
        return $this->sendResponse($data, 'Product Updated');
    }
    public function delete($id)
    {
        
        $product = $this->product->delete($id);
        if ($product) {
            return $this->sendResponse($product, 'Product deleted');
        }else{
            return $this->sendError($product, 'Something Went Wrong');
        }
    }
}
