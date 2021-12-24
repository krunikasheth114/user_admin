<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Yajra\DataTables\Exports\DataTablesCollectionExport;

class ProductsExport extends DataTablesCollectionExport implements FromCollection, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::all();
    }
    public function headings(): array
    {
        return [
            'id',
            'category_id',
            'subcategory_id',
            'name',
            'price',
            'status',
            'image',
            'Created at',
            'Updated at'
        ];
    }
    public function map($row): array
    {
        return [
            $row->id, //ID
            $row->category_id,
            $row->subcategory_id,
            $row->name,
            $row->price,
            $row->status,
            $row->ImageUrl, //Image 
            $row->Createdat,
            $row->Updatedat,

        ];
    }
}
