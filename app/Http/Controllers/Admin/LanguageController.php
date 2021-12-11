<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function language(Request $request)
    {

        if (!empty($request->lang)) {
            \Session::put('locale', $request->lang);
        }
        return response()->json(['status' => true, 'message' => ""]);
    }
}
