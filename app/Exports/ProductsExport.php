<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Product_category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Yajra\DataTables\Exports\DataTablesCollectionExport;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ProductsExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        $query = Product::query();
        return $query;
    }

    public function headings(): array
    {
        return ["Id", "image", "category_id", "subcategory_id", "name", "price", "Created At", "Updated At"];
    }

    public function map($data): array
    {
        // dd($data);
        return [
            !empty($data->id) ? $data->id : '',
            !empty($data->image) ? $data->ImageUrl : '',
            !empty($data->category_id) ? $data->getCategory->name : '',
            !empty($data->subcategory_id) ? $data->subCategory->name : '',
            !empty($data->name) ? $data->name : '',
            !empty($data->price) ? $data->price : '',
            !empty($data->created_at) ? $data->created_at : '',
            !empty($data->updated_at) ? $data->updated_at : '',
        ];
    }
}
