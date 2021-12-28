<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use Illuminate\Support\Facades\Validator;
use Redirect;


use Session;




class MyController extends Controller
{
    public function importExportView()
    {
        return view('admin.products.index');
    }

    public function export()
    {

        return Excel::download(new ProductsExport, 'products.csv');

        // return Excel::download(new ProductsExport, 'students.xlsx');
        //return app()->make(ProductsExport::class)->download('items.xlsx');
        // $medicine_file = Excel::raw(new ProductsExport, \Maatwebsite\Excel\Excel::XLSX);
        // Excel::create('Filename', function($excel) {

        // )}->download('xls');
        // dd($medicine_file);
        // $response =  array(
        //     'name' => "medicine_details", //no extention needed
        //     'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($medicine_file) //mime type of used format
        // );
        // $notification_msg = 'Medicine details export success.';
        // return response()->json(['data'=>$response, 'msg'=>$notification_msg], 200);

    }
    public function importjuhi(Request $request)
    {
      
        $this->validate(request(), [
            'file' => ['required', function ($attribute, $value, $fail) {
                if (!in_array($value->getClientOriginalExtension(), ['csv', 'xsl', 'xlsx'])) {
                    $fail('Incorrect :attribute type choose.');
                }
            }]
        ]);
        $send = Excel::import(new ProductsImport, request()->file('file'));
        return  response()->json(['status' => true, 'message' => "File imporeted"]);
    }
}
