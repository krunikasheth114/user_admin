<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Product_category;
use Illuminate\Http\Request;
use App\Models\Product;
use AmrShawky\LaravelCurrency\Facade\Currency;
use Illuminate\Support\Facades\DB;
use \App\Models\Order;

use Illuminate\Support\Facades\Auth;
use \App\Models\OrderProduct;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;

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
        $category = Session::get('category');
        $request->session()->save();
        $p = (explode(';', $request->price_range));
        $products = Product::with('getCategory');
        if (!empty($category)) {
            $products = $products->whereIn('category_id', $category);
        }
        if (isset($p) && !empty($p) && count($p) > 1) {
            $products = $products->whereBetween('price', $p);
        }
        $data = $products->get();
        return response()->json(["status" => true, 'data' => $data]);
    }
    public function addToCart(Request $request)
    {
        $cart = Cart::create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);
        return redirect()->route('product.cart-view')->with('success', "Product added in to cart succesfully");
    }

    // $request->session()->forget('cart');
    // $product = Product::findOrFail($request->product_id);
    // $cart = session()->get('cart', []);
    // $quantity = 0;
    // if (isset($cart[$request->product_id])) {
    //     $cart[$request->product_id]['quantity']++;
    // } else {
    //     $cart[$request->product_id] = [
    //         "id" => $request->product_id,
    //         "quantity" => 1,
    //         "image" => $product->image,
    //         "name" => $product->name,
    //         "price" => $product->price,
    //     ];
    // }
    // session()->put('cart', $cart);

    // return response()->json(['status' => true, 'success' => 'Product added to cart successfully!']);

    public function cart()
    {
        $product = Cart::where('user_id', Auth::user()->id)->with('productData')->get()->toArray();
        return view('user.products.cart', compact('product'));
    }
    // public function orderPreview(Request $request)
    // {

    //     $order = Order::create([
    //         'user_id' => Auth::user()->id,
    //         'status' => 0,
    //     ]);
    //     $orderId = $order->id;
    //     $orderSummary = Product::where('id', $request->product_id)->with('getCategory', 'subCategory')->get();
    //     return view('user.products.order-summary ', compact('orderSummary','orderId'));
    // }
    public function cartRemove(Request $request, $id)
    {
        $removeCart = Cart::where(['user_id' => Auth::user()->id, 'product_id' => $id])->delete();
        return redirect()->back()->with('danger', "Removed");
    }
    public function  userOrder(Request $request)
    {
        $price = Product::where('id', $request->product_id)->value('price');


        // dd($price['price']);
        $totalAmount = $price * $request->quantity;
        $order = Order::create([
            'user_id' => Auth::user()->id,
            'status' => 1,
        ]);
        $orderId = $order->id;
        if (isset($orderId)) {
            $data = OrderProduct::create([
                'order_id' => $orderId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'totalamount' =>  $totalAmount,
            ]);
        }
        $lastId = $data->id;
        if (isset($data)) {
            $deleteFromCart = Cart::where(['user_id' => Auth::user()->id, 'product_id' => $request->product_id])->delete();
        }
        return redirect()->route('product.user-order-history')->with('success', "Your Order Placed Succesfully ");;
    }
    public function userOrderHistory()
    {
        $data = Order::where('user_id', Auth::user()->id)->with('userOrder', 'userOrder.getProduct')->get()->toArray();
        return view('user.products.user_order_history', compact('data'));
    }
}
