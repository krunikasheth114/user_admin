<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Product_category;
use Illuminate\Http\Request;
use App\Models\Product;
use AmrShawky\LaravelCurrency\Facade\Currency;
use Illuminate\Support\Facades\DB;
use Session;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (!empty(Session::get('category'))) {
            $products = Product::whereIn('category_id', Session::get('category'))->get();
        } else {
            $products = Product::get();
        }
        $category = Product_category::get();
        return view('user.products.index', compact(['products', 'category']));
    }
    public function changeCurrency(Request $request)
    {
        \Session::forget('currency1');
        $product = Product::orderBy('id')->get();
        $category = Product_category::get();
        $from = $request->from;
        $currency = \session(['currency1' => $request->to]);
        $data =   \Session::get('currency1');
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
            $converted['category_name'] = $p->getCategory->name;
            $new[] = $converted;
            $converted['session_val'] = $data;
        }
        return response(['status' => true, 'data' => $new]);
    }
    public function catFilter(Request $request)
    {
        $request->session()->put('price_range', $request->price_range);
        $request->session()->put('category', $request->categories);
        $request->session()->save();
        $p = (explode(';', $request->price_range));
        $products = Product::with('getCategory');
        if (!empty($request->categories)) {
            $products = $products->orWhereIn('category_id', $request->categories);
        }
        if (isset($p) && !empty($p) && count($p) > 1) {
            $products = $products->orWhereBetween('price', $p);
        }
        $data = $products->get();
        return response()->json(["status" => true, 'data' => $data]);
    }
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->id);
        // $request->session()->forget('cart');
        $cart = session()->get('cart', []);
        // $quantity = 0;
        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity']++;
        } else {

            $cart[$request->id] = [
                "quantity" => 1,
                "image" => $product->image,
                "name" => $product->name,
                "price" => $product->price,
            ];
        }
        session()->put('cart', $cart);
        return response()->json(['status' => true, 'success' => 'Product added to cart successfully!']);
    }

    public function cart()
    {
        return view('user.products.cart');
    }
}
