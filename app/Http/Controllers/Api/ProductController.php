<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\ProductContract;
use App\Http\Controllers\Api\BaseController as  BaseController;
use App\Repositories\ProductRepository;
use App\Models\Product;

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
        $product = $this->product->create($request->all());
        return $this->sendResponse($product, 'Product Crearted');
    }
    public function edit(Product $product)
    {
        dd($product);
        $product = $this->product->edit($id);
        if (!empty($product)) {
            return $this->sendResponse($product, 'Product-detail');
        } else {
            return $this->sendError($product, 'data not found');
        }
    }
    public function update(Request $request, $id)
    {
        // $collection = $request->except(['_token','_method']);
        $data = $request->all();
        if (!empty($id)) {
            $product = $this->product->update($data, $id);
            return $this->sendResponse($data, 'Product Updated');
        } 
    }
    public function delete($id)
    {

        $product = $this->product->delete($id);
        if ($product) {
            return $this->sendResponse($product, 'Product deleted');
        } 
    }
}
