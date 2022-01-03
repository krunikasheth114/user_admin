<?php

namespace App\Repositories;

use App\Models\Product;
use App\Contracts\ProductContract;

class ProductRepository implements ProductContract
{
    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getAll()
    {
        return $this->product->all();
    }

    public function create(array $data)
    {
        if (isset($data['image'])) {
            $image = $data['image'];
            $destinationPath = public_path('images/');
            $profileImage = date('YmdHis') . "." . $image->extension();
            $image->move($destinationPath, $profileImage);
            $data['image'] = $profileImage;
        }
        $product = Product::create([
            'category_id' => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'],
            'name' => $data['name'],
            'price' => $data['price'],
            'image' => $profileImage,

        ]);
        return $product;
    }
    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        return $product;
    }
    public function update(array $data, $id)
    {

        $update = Product::find($id);
        $update->category_id = $data['category_id'];
        $update->subcategory_id = $data['subcategory_id'];
        $update->name = $data['name'];
        $update->price = $data['price'];
        if (isset($update['image'])) {
            $image = $data['image'];
            $destinationPath = public_path('images/');
            $profileImage = date('YmdHis') . "." . $image->extension();
            $image->move($destinationPath, $profileImage);
            $data['image'] = $profileImage;
        }
        $update->image = $profileImage;
        $update->save();
        return $update;
    }
    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return $product;
    }
}
