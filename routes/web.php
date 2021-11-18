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
// \Auth::logout();
Route::get('/home',          'users\RegisterController@home')->name('home');
Route::get('/register',          'users\RegisterController@showLoginForm')->name('register');
Route::get('/getcat',            'users\RegisterController@getcat')->name('getcat');
Route::post('store',             'users\RegisterController@store')->name('store');
Route::get('verify_register_user/{id}',        'users\RegisterController@showotpRegister')->name('user.showotpRegister');
Route::get('verify_user/{id}',        'users\RegisterController@showotpLogin')->name('user.verify_user');

Route::post('otp_verify',        'users\RegisterController@VerifyUser')->name('otp_verify');
Route::get('/user/login',        'users\LoginController@showLoginForm')->name('user.login');
Route::post('/attemptLogin',     'users\LoginController@Login')->name('attemptLogin');
Route::get('showEmail',        'users\LoginController@showEmail')->name('user.showEmail');
Route::post('getEmail',        'users\LoginController@getEmail')->name('user.getEmail');
Route::get('get_otp/{id}',        'users\LoginController@get_otp')->name('user.get_otp');
Route::post('verify_otp',        'users\LoginController@verify_otp')->name('user.verify_otp');
Route::get('reset_pass/{id}',        'users\LoginController@reset_pass')->name('user.reset_pass');
Route::post('confirm_pass',        'users\LoginController@confirm_pass')->name('user.confirm_pass');
Route::get('logout',            'users\LoginController@logout')->name('logout');
Route::get('/display/{slug}',         'users\ViewblogController@index')->name('display');

Route::group(['middleware' => 'auth:web'], function () {
    // Route::get('customlogout',            'users\LoginController@customlogout')->name('customlogout');

    Route::any('/dashboard',         'users\DashboardController@index')->name('dashboard')->middleware('CheckStatus');

    Route::any('/edit',         'users\UpdateController@edit')->name('edit');
    Route::any('/update',         'users\UpdateController@update')->name('update');
    Route::post('/getcategory',         'users\UpdateController@getcategory')->name('getcategory');
    Route::post('/getsubcategory',         'users\UpdateController@getsubcategory')->name('getsubcategory'); 
    
    Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {
        Route::any('/createblog',         'users\CreateblogController@index')->name('createblog');
        Route::post('/store',         'users\CreateblogController@store')->name('store');
        Route::get('/edit/{id}',         'users\CreateblogController@edit')->name('edit');
        Route::post('/update/{slug}',         'users\CreateblogController@update')->name('update');
        Route::get('/delete/{slug}',         'users\CreateblogController@delete')->name('delete');
        Route::post('/like',         'users\ViewblogController@like')->name('like');
        Route::post('/comment',         'users\ViewblogController@comment')->name('comment');
        Route::post('/delete/comment',         'users\ViewblogController@delete')->name('delete.comment');

       
        

    });
});
