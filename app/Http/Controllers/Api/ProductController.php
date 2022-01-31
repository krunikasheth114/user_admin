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
        } catch (ValidationException | \Exception  $e) {

            return $this->sendError($e, 'Something Went Wrong');
        }
        return $this->sendResponse($product, 'Product Crearted');
    }
    public function edit($id)
    {
        $product = $this->product->edit($id);
        if (is_null($product)) {
            return $this->sendError($product, 'Data Not Found');
        }
        return $this->sendResponse($product, 'Product-detail');
    }
    public function update(Request $request, $id)
    {
        $data = $request->all();
     
            $product = $this->product->update($data, $id);
        return $this->sendResponse($data, 'Product Updated');
    }
    public function delete($id)
    {
        $product = $this->product->delete($id);
        if (is_null($product)) {
            return $this->sendError($product, 'Data Not Found');
        }
        return $this->sendResponse($product, 'Product deleted');
    }
}
