<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Product_category;
use App\Models\Product_subcategory;
// use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;
use File;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $category_id = Product_category::where('name', $row['category_id'])->first();
        $sub_category_id = Product_subcategory::where('name', $row['subcategory_id'])->first();
        $files = File::allFiles(public_path('images/'));
        $random = array_random($files);
        $Image = $random->getFilename();
    
        return new Product([
            'category_id'     => $category_id->id ?? NULL,
            'subcategory_id'     => $sub_category_id->id ?? NULL,
            'name'     => $row['name'],
            'price'     => $row['price'],
            'image'     => $Image,
            'created_at'     => $row['created_at'],
            'updated_at'     => $row['updated_at'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
