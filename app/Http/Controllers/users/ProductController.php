<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Product_category;
use Illuminate\Http\Request;
use App\Models\Product;
use AmrShawky\LaravelCurrency\Facade\Currency;
use Illuminate\Support\Facades\DB;
use \App\Models\Order;
use Stripe;
use Illuminate\Support\Facades\Auth;
use \App\Models\OrderProduct;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use  \App\Models\PaymentMethod;
use App\Models\User;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (!empty(Session::get('category'))) {
            $products = Product::whereIn('category_id', Session::get('category'))->where('status', 1)->get();
        } else {
            $products = Product::where('status', 1)->get();
        }
        $category = Product_category::get();
        return view('user.products.index', compact(['products', 'category']));
    }
    // Change Currency
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
    // Category Filter
    public function catFilter(Request $request)
    {
        $request->session()->put('price_range', $request->price_range);
        $request->session()->put('category', $request->categories);
        $category = Session::get('category');
        $request->session()->save();
        $p = (explode(';', $request->price_range));
        $products = Product::where('status', 1)->with('getCategory');
        if (!empty($category)) {
            $products = $products->whereIn('category_id', $category);
        }
        if (isset($p) && !empty($p) && count($p) > 1) {
            $products = $products->whereBetween('price', $p);
        }
        $data = $products->get();
        return response()->json(["status" => true, 'data' => $data]);
    }
    // Add to cart
    public function addToCart(Request $request)
    {
        $cart = Cart::create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);
        return redirect()->route('product.cart-view')->with('success', "Product added in to cart succesfully");
    }
    // Cart
    public function cart()
    {
        $product = Cart::where('user_id', Auth::user()->id)->with('productData')->get()->toArray();
        return view('user.products.cart', compact('product'));
    }
    // Remove from cart
    public function cartRemove(Request $request, $id)
    {
        $removeCart = Cart::where(['user_id' => Auth::user()->id, 'product_id' => $id])->delete();
        return redirect()->back()->with('danger', "Removed");
    }
    // Order Preview
    public function orderPreview(Request $request)
    {
        $quantity = $request->quantity;
        $userCartPreview = Cart::where(['product_id' => $request->product_id, 'user_id' => Auth::user()->id])->with('productData')->get()->toArray();
        return view('user.products.preview', compact('quantity', 'userCartPreview'));
    }
    // Payment View
    public function userPaymentView(Request $request)
    {
        $data = $request->all();
        $paymentDetails = PaymentMethod::where('user_id', Auth::user()->id)->get();
        return view('user.products.payment.payment', compact('data', 'paymentDetails'));
    }
    // New Card or same Card Payment
    public function  userPayment(Request $request)
    {
        // dd($request->all());
        // Card Update
        if (isset($request->hidden_id) && isset($request->hidden_cusid) && isset($request->hidden_cardid)) {
            $stripe = new \Stripe\StripeClient(
                (env('STRIPE_SECRET'))
            );
            $token = $stripe->tokens->create([
                'card' => [
                    'number' => $request->cardnumber,
                    'exp_month' => $request->expirationmonth,
                    'exp_year' => $request->expirationyear,
                    'cvc' => $request->cvc,
                ],
            ]);
            $stripe->customers->update(
                $request->hidden_cusid,
                ['metadata' => ['name' => $request->nameoncard, 'email' => $request->email]]
            );
            PaymentMethod::where('id', $request->hidden_id)->update([
                'token_id' => $token->id,
                'card_id' => $token->card->id,
                'last4' => $request->cardnumber,
                'cvc' => $request->cvc,
                'exp_month' => $request->expirationmonth,
                'exp_year' => $request->expirationyear,
                'brand' => $token->card->brand
            ]);
            // create
        } else {
            $productData = cart::where('id', $request->cart_id)->first();
            $order = Order::create([
                'user_id' => Auth::user()->id,
                'status' => 1,
            ]);
            $orderId = $order->id;
            if (isset($orderId)) {
                $data = OrderProduct::create([
                    'order_id' => $orderId,
                    'product_id' => $productData->product_id,
                    'quantity' => $request->quantity,
                    'totalamount' =>  $request->total_amount,
                ]);
            }
            $retriveCusId = PaymentMethod::where('user_id', Auth::user()->id)->first();

            $stripe = new \Stripe\StripeClient(
                (env('STRIPE_SECRET'))
            );
            $token = $stripe->tokens->create([
                'card' => [
                    'number' => $request->cardnumber,
                    'exp_month' => $request->expirationmonth,
                    'exp_year' => $request->expirationyear,
                    'cvc' => $request->cvc,
                ],
            ]);
            // if both customer and card exist
            if (isset($retriveCusId->cus_id) && $retriveCusId->last4 == $request->cardnumber) {
                $customer = $stripe->customers->update($retriveCusId->cus_id);
                $stripe->customers->update(
                    $customer->id,
                    ['default_source' => $customer->default_source]
                );
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $charge = \Stripe\Charge::create([
                    'amount' => $request->total_amount * 100, // $15.00 this time
                    'currency' => 'usd',
                    'customer' => $retriveCusId->cus_id, // Previously stored, then retrieved
                    "description" => "Test payment",
                ]);
                $cardDetail = PaymentMethod::where('last4', $request->cardnumber)->update([
                    'token_id' =>  $token->id,
                    'user_id' => Auth::user()->id,
                    'cus_id' => $charge->source->customer,
                    'card_id' => $charge->payment_method,
                    'last4' => $request->cardnumber,
                    'exp_month' => $charge->payment_method_details->card->exp_month,
                    'exp_year' => $charge->payment_method_details->card->exp_year,
                    'brand' => $charge->payment_method_details->card->brand,
                    'cvc' => $request->cvc,
                    'default_method' => 1,
                ]);
                $defalt0 = PaymentMethod::where('user_id', Auth::user()->id)->where('card_id', '!=', $charge->payment_method)->update([
                    'default_method' => 0,
                ]);
                //    card not exist but  customer exist
            } elseif (isset($retriveCusId->cus_id) &&  $retriveCusId->last4 != $request->cardnumber) {

                $customer = $stripe->customers->update($retriveCusId->cus_id);
                $token = $stripe->customers->createSource(
                    $customer->id,
                    [
                        'source' => $token->id,
                    ]
                );
                $stripe->customers->update(
                    $customer->id,
                    ['default_source' => $customer->default_source]
                );
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $charge = \Stripe\Charge::create([
                    'amount' => $request->total_amount * 100, // $15.00 this time
                    'currency' => 'usd',
                    'customer' =>   $customer->id, // Previously stored, then retrieved
                    "description" => "Test payment",
                ]);

                $cardDetail = PaymentMethod::create([
                    'token_id' =>  $token->id,
                    'user_id' => Auth::user()->id,
                    'cus_id' => $charge->source->customer,
                    'card_id' => $token->id,
                    'last4' => $request->cardnumber,
                    'exp_month' => $charge->payment_method_details->card->exp_month,
                    'exp_year' => $charge->payment_method_details->card->exp_year,
                    'brand' => $token->brand,
                    'cvc' => $request->cvc,
                    'default_method' => 1,
                ]);
                // dd($charge);
                $default0 = PaymentMethod::where('user_id', Auth::user()->id)->where('last4', '!=', $request->cardnumber)->update([
                    'default_method' => 0,
                ]);



                // create new one
            } else {
                $stripe = new \Stripe\StripeClient(
                    (env('STRIPE_SECRET'))
                );
                $token = $stripe->tokens->create([
                    'card' => [
                        'number' => $request->cardnumber,
                        'exp_month' => $request->expirationmonth,
                        'exp_year' => $request->expirationyear,
                        'cvc' => $request->cvc,
                    ],
                ]);
                $customer = $stripe->customers->create([
                    'name' => $request->nameoncard,
                    'email' => $request->email,
                ]);

                $id = $customer->id;
                $card = $stripe->customers->createSource(
                    $id,
                    [
                        'source' => $token->id,
                    ]
                );

                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $charge = Stripe\Charge::create([
                    "amount" => $request->total_amount * 100,
                    "currency" => "usd",
                    "customer" => $id,
                    "description" => "Test payment",
                ]);
                $token_id = $token->id;

                $cardDetail = PaymentMethod::create([
                    'token_id' =>  $token_id,
                    'user_id' => Auth::user()->id,
                    'cus_id' => $charge->source->customer,
                    'card_id' => $charge->payment_method,
                    'last4' => $request->cardnumber,
                    'exp_month' => $charge->payment_method_details->card->exp_month,
                    'exp_year' => $charge->payment_method_details->card->exp_year,
                    'brand' => $charge->payment_method_details->card->brand,
                    'cvc' => $request->cvc,
                    'default_method' => 1,
                ]);
                $defalt0 = PaymentMethod::where('user_id', Auth::user()->id)->where('card_id', '!=', $charge->payment_method)->update([
                    'default_method' => 0,
                ]);
            }
            $lastId = $data->id;
            if (isset($data)) {
                $deleteFromCart = Cart::where(['user_id' => Auth::user()->id, 'product_id' =>  $productData->product_id])->delete();
            }
        }
        Session::flash('success', 'Payment successful!');
        return redirect()->route('product.order-history');
    }
    // Existing Card Payment
    public function existingCardPayment(Request $request)
    {
        // dd($request->all());
        $productData = cart::where('id', $request->cart_id)->first();
        $order = Order::create([
            'user_id' => Auth::user()->id,
            'status' => 1,
        ]);
        $orderId = $order->id;
        if (isset($orderId)) {
            $data = OrderProduct::create([
                'order_id' => $orderId,
                'product_id' => $productData->product_id,
                'quantity' => $request->quantity,
                'totalamount' =>  $request->ammount,
            ]);
        }
        $stripe = new \Stripe\StripeClient(
            (env('STRIPE_SECRET'))
        );
        $token = $stripe->tokens->create([
            'card' => [
                'number' => $request->card,
                'exp_month' => $request->exp_month,
                'exp_year' => $request->exp_year,
                'cvc' => $request->cvc,
            ],
        ]);
        // $customer = $stripe->customers->update($request->customer_id);

        $stripe->customers->update(
            $request->customer_id,
            ['default_source' =>  $charge->payment_method]
        );
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $charge = \Stripe\Charge::create([
            'amount' => $request->ammount * 100, // $15.00 this time
            'currency' => 'usd',
            'customer' => $request->customer_id, // Previously stored, then retrieved
            "description" => "Test payment",
        ]);


        $cardDetail = PaymentMethod::where(['user_id' => Auth::user()->id, 'card_id' =>  $charge->payment_method])->update([
            'default_method' => 1,
        ]);
        $defalt0 = PaymentMethod::where('user_id', Auth::user()->id)->where('last4', '!=', $request->card)->update([
            'default_method' => 0,
        ]);
        $lastId = $data->id;
        if (isset($data)) {
            $deleteFromCart = Cart::where(['user_id' => Auth::user()->id, 'product_id' =>  $productData->product_id])->delete();
        }
        return redirect()->route('product.order-history');
    }
    // Edit payment
    public function editPaymentMethod(Request $request)
    {
        $data['editData'] = PaymentMethod::where('id', $request->id)->first();
        $stripe = new \Stripe\StripeClient(
            (env('STRIPE_SECRET'))
        );
        $data['customerData'] = $stripe->customers->retrieve(
            $data['editData']['cus_id'],
        );
        return response()->json(['staus' => true, 'data' => $data]);
    }
    // Remove payment method
    public function removePaymentMethod(Request $request)
    {
        // dd($request->all());
        $stripe = new \Stripe\StripeClient(
            (env('STRIPE_SECRET'))
        );
        $stripe->customers->deleteSource(
            $request->cus_id,
            $request->card_id,
        );
        $delete = PaymentMethod::where(['user_id' => Auth::user()->id, 'card_id' => $request->card_id])->delete();
        return response()->json(['status' => true, 'msg' => "Card Deleted Succesfully"]);
    }
    // Order History
    public function userOrderHistory()
    {
        $data = Order::where('user_id', Auth::user()->id)->with('userOrder', 'userOrder.getProduct')->get()->toArray();
        return view('user.products.user_order_history', compact('data'));
    }
}
