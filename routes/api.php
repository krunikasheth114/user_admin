<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', 'RegisterController@Register')->name('register');
Route::get('home', 'RegisterController@home')->name('home');
Route::post('login', 'LoginController@Login')->name('login');

Route::group(['middleware' => 'auth:api'], function () {
    // dd('dsdfg');
    Route::get('blogList', 'HomeController@blogList');
    Route::get('index/{slug}', 'BlogDetailController@index');
    Route::get('like/{id}', 'BlogDetailController@like');
    Route::post('comment', 'BlogDetailController@comment');
    Route::get('delete/{id}', 'BlogDetailController@delete');
    Route::post('commentReply', 'BlogDetailController@commentReply');
    Route::post('response', 'BlogDetailController@response');
    Route::get('fetchComment/{id}', 'BlogDetailController@fetchComment');
    Route::prefix('product')->group(function () {
        Route::get('index', 'ProductController@index');
        Route::post('store', 'ProductController@create');
        Route::get('edit/{id}', 'ProductController@edit');
        Route::post('update/{id}', 'ProductController@update');
        Route::get('delete/{id}', 'ProductController@delete');

    });
});
