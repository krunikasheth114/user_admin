<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use AmrShawky\LaravelCurrency\Facade\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
   public function changeCurrency(Request $request){
    //    dd($request->all());
    $from = $request->from;
    $to = $request->to;
    $amount= $request->amount;
    $converted=Currency::convert()
        ->from($from) //currncy you are converting
        ->to($to)     // currency you are converting to
        ->amount(100) // amount in USD you converting to EUR
        ->get();

return view('blade_name',compact('converted'));
   }
}
