<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use AmrShawky\LaravelCurrency\Facade\Currency;
use Illuminate\Http\Request;
use App\Models\Product;
use Session;

class CurrencyController extends Controller
{
    public function changeCurrency(Request $request)
    {  
        Session::pull('currency');
        $currency = Session::put('currency',$request->from);
        $data =   Session::get('currency');
        return response()->json(['status' => true, 'message' => 'Update Success' ,'currency' => $data]);
    }
}
