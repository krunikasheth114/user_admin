<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;

class MyController extends Controller
{
    public function importExportView()
    {

        return view('admin.products.index');
        
    }
    public function export(){

        // $Products=DB::table('products')->get();
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
}
