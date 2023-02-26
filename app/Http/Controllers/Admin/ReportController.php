<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReportDataTable;
use App\Http\Controllers\Controller;
use App\Imports\ReportsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;

class ReportController extends Controller
{

    public function index(ReportDataTable $datatable, Request $request)
    {
        // if($request->ajax()){

        //     if(!empty($request)){

        //         dd($request->all());
        //     }
    
        // }
        
        return $datatable->render('admin.reports.index');

        // return view("admin.reports.index");
    }
    public function importReport(Request $request)
    {
        $this->validate(request(), [
            'file' => ['required', function ($attribute, $value, $fail) {
                if (!in_array($value->getClientOriginalExtension(), ['csv', 'xsl', 'xlsx'])) {
                    $fail('Incorrect :attribute type choose.');
                }
            }]
        ]);
        $send = Excel::import(new ReportsImport, request()->file('file'));
        return  response()->json(['status' => true, 'message' => "File imporeted"]);
    }

    public function exportReport(Request $request)
    {

        // $response = Excel::download(new ReportsExport($request['reports']), 'Reports.csv');
        // $output = Excel::store('items', function($excel) use($response) {
        //     $excel->sheet('ExportFile', function($sheet) use($response) {
        //         $sheet->fromArray($response);
        //     });
        // })->export('xls');
        // return $output;
        //  return Excel::download(new ReportsExport($request['reports']), 'Reports.csv', \Maatwebsite\Excel\Excel::CSV);

        return Excel::download(new ReportsExport($request['reports']), 'Reports.csv');
    }
}
