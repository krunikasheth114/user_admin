
<?php



Route::group(['namespace' => 'Auth'], function () {
    # Login Routes
    Route::get('login',     'LoginController@showLoginForm')->name('login');
    Route::post('login',    'LoginController@login');
    Route::post('logout',   'LoginController@logout')->name('logout');
});
Route::group(['middleware' => 'auth:admin'], function () {

    Route::get('dashboard',                   'DashboardController@showDashboared')->name('dashboard');



    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::get('category',                   'CategoryController@showCategory')->name('showCategory');
        Route::get('/',                           'CategoryController@dataTable')->name('dataTable');

        Route::post('store',                       'CategoryController@store')->name('store');
        Route::post('/getstatus',                   'CategoryController@changeStatus')->name('getstatus');
        Route::post('/getcategory',                   'CategoryController@getcategory')->name('getcategory');
        Route::post('/updatecategory',                   'CategoryController@updatecategory')->name('updatecategory');
        Route::post('/deletecategory',                   'CategoryController@deletecategory')->name('deletecategory');
    });
    Route::group(['prefix' => 'subcategory', 'as' => 'subcategory.'], function () {
        Route::get('subcategory',                   'SubCategoryController@showCategory')->name('subcategory');
        Route::get('/',                             'SubCategoryController@dataTable')->name('dataTable');
        Route::post('store',                        'SubCategoryController@store')->name('store');
        Route::post('/getstatus',                   'SubCategoryController@changeStatus')->name('getstatus');
        Route::post('/edit',                   'SubCategoryController@edit')->name('edit');
        Route::post('/updatesubcategory',                   'SubCategoryController@updatesubcategory')->name('updatesubcategory');
        Route::post('/deletecategory',                   'SubCategoryController@deletecategory')->name('deletecategory');
    });

    Route::get('/',                         'UserController@dataTable')->name('getuser');
    Route::post('/gets',                    'UserController@gets')->name('gets');
    Route::post('/edit',                    'UserController@edit')->name('edit');
    Route::post('/update',                  'UserController@update')->name('update');
    Route::post('/delete',                  'UserController@delete')->name('delete');
    Route::post('createDoc',                 'UserController@createDoc')->name('createDoc');
        
    
    //
    // Route::get('/show/{id}',                 'UserController@show')->name('show');
    Route::post('/getstate',                 'AddressController@getstate')->name('getstate');
    Route::post('/getcity',                 'AddressController@getcity')->name('getcity');
    Route::post('/getsubcategory',                 'AddressController@getsubcategory')->name('getsubcategory');
    // Route::post('/updateaddres',                 'UserController@updateaddres')->name('updateaddres');
    Route::resource('address',    AddressController::class);
});
?>