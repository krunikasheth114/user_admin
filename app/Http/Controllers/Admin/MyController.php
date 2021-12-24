<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;

class MyController extends Controller
{
    public function importExportView()
    {

        return view('admin.products.index');
    }
   

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlx,xls,xlsx',
        ]);
        Excel::import(new ProductsImport,request()->file('file'));

        return redirect()->back();
    }
}
