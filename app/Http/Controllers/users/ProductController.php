<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Product_category;
use Illuminate\Http\Request;
use App\Models\Product;
use AmrShawky\LaravelCurrency\Facade\Currency;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $products = Product::get();
        $category = Product_category::get();
        return view('user.products.index', compact(['products', 'category']));
    }
    public function changeCurrency(Request $request)
    {
        $product = Product::orderBy('id')->get();
        $category = Product_category::get();
        $from = $request->from;
        $to = $request->to;
        foreach ($product as $p) {
            $converted = $p;
            if ($from == 'INR') {
                $to = 'EUR';
                $newPrice = Currency::convert()
                    ->from($from)
                    ->to($to)
                    ->amount($p->price)
                    ->get();
            } else {
                $newPrice = $p->price;
            }
            $converted['new_price'] = $newPrice;
            $converted['category_name'] =$p->getCategory->name;
            $new[] = $converted;
        }
        return response(['status' => true, 'data' => $new]);
    }
}
