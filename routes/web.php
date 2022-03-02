<?php

use App\Http\Controllers\admin\auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\users\RegisterController;
use App\Http\Controllers\users\UpdateController;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Middleware\CheckStatus;
use App\Http\Controllers\users\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});
// \Auth::logout();'namespace' => 'Auth'
Route::group(['namespace' => 'users'], function () {
    Route::get('/home',              'RegisterController@home')->name('home');
    Route::get('/register',          'RegisterController@Register')->name('register');
    Route::get('/getcat',            'RegisterController@getcat')->name('getcat');
    Route::post('/store',             'RegisterController@store')->name('store');
    Route::get('verify_register_user/{id}',   'RegisterController@showotpRegister')->name('user.showotpRegister');
    Route::get('verify_user/{id}',        'RegisterController@showotpLogin')->name('user.verify_user');
    Route::post('otp_verify',           'RegisterController@VerifyUser')->name('otp_verify');
    Route::get('/user/login',           'LoginController@showLoginForm')->name('user.login');
    Route::post('/attemptLogin',        'LoginController@Login')->name('attemptLogin');
    Route::get('showEmail',             'LoginController@showEmail')->name('user.showEmail');
    Route::post('getEmail',             'LoginController@getEmail')->name('user.getEmail');
    Route::get('get_otp/{id}',          'LoginController@get_otp')->name('user.get_otp');
    Route::post('verify_otp',           'LoginController@verify_otp')->name('user.verify_otp');
    Route::get('reset_pass/{id}',       'LoginController@reset_pass')->name('user.reset_pass');
    Route::post('confirm_pass',         'LoginController@confirm_pass')->name('user.confirm_pass');
    Route::get('logout',                 'LoginController@logout')->name('logout');
    Route::get('/display/{slug}',         'CreateblogController@displayBlog')->name('display');
    Route::group(['middleware' => 'auth:web'], function () {
        Route::any('/dashboard',        'DashboardController@index')->name('dashboard')->middleware('CheckStatus');
        Route::any('/edit',             'UpdateController@edit')->name('edit');
        Route::any('/update',           'UpdateController@update')->name('update');
        Route::post('/getcategory',      'UpdateController@getcategory')->name('getcategory');
        Route::post('/getsubcategory',    'UpdateController@getsubcategory')->name('getsubcategory');

        Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {
            Route::any('/createblog',         'CreateblogController@index')->name('createblog');
            Route::post('/store',             'CreateblogController@store')->name('store');
            Route::get('/edit/{id}',          'CreateblogController@edit')->name('edit');
            Route::post('/update/{slug}',      'CreateblogController@update')->name('update');
            Route::get('/delete/{slug}',        'CreateblogController@deleteBlog')->name('delete');
            Route::post('/like',                 'CreateblogController@like')->name('like');
            Route::post('comment',                 'CreateblogController@comment')->name('comment');
            Route::post('/delete/comment',         'CreateblogController@delete')->name('delete.comment');
            Route::post('/commentReply',           'CreateblogController@commentReply')->name('commentReply');
            Route::post('/response',                'CreateblogController@response')->name('response');
            Route::post('/fetch-comment',            'CreateblogController@fetchComment')->name('fetch_comment');
        });

        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
            Route::get('show',              'ProductController@index')->name('show');
            Route::post('/curency',         'ProductController@changeCurrency')->name('change-currency');
            Route::post('/cat-filter',       'ProductController@catFilter')->name('cat-filter');
            Route::post('cart',              'ProductController@addToCart')->name('cart');
            Route::get('cart-view',           'ProductController@cart')->name('cart-view');
            Route::get('cart-remove/{id}',           'ProductController@cartRemove')->name('user-cart-remove');
            Route::post('order-preview',           'ProductController@orderPreview')->name('order-preview');
            Route::get('/order',       'ProductController@userOrderHistory')->name('order-history');
            // Route::get('/order-preview',       'ProductController@orderPreview')->name('preview');
            Route::post('/view',       'ProductController@userPaymentView')->name('payment');
            Route::post('/add/card',       'ProductController@cardCreate')->name('create-card');
            Route::post('/payment',       'ProductController@userPayment')->name('user-payment');
            Route::post('existing/payment' ,      'ProductController@existingCardPayment')->name('existingpayment');
            Route::post('/create',       'PaymentMethodsController@create')->name('create');
        });
    });
});
