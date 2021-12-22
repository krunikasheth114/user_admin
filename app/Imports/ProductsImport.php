<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'category_id'     => $row['category_id'],
            'subcategory_id'     => $row['subcategory_id'],
            'name'     => $row['name'],
            'price'     => $row['price'],
            'status'     => $row['status'],
            'image'     => $row['image'],
        ]);
    }
}
