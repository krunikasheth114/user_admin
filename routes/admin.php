
<?php
Route::group(['namespace' => 'Auth'], function () {
    # Login Routes
    Route::get('login',     'LoginController@showLoginForm')->name('login');
    Route::post('login',    'LoginController@login');
    Route::post('logout',   'LoginController@logout')->name('logout');
});
Route::group(['middleware' => 'auth:admin'], function () {

    Route::get('dashboard',                   'DashboardController@showDashboared')->name('dashboard');
    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::get('product/category',                   'ProductcategoryController@index')->name('product-category');
        Route::post('product/category/store',                   'ProductcategoryController@store')->name('product-store');
        Route::post('product/category/edit',                   'ProductcategoryController@edit')->name('product-edit');
        Route::post('product/category/update',                   'ProductcategoryController@update')->name('product-update');
        Route::post('product/category/delete',                   'ProductcategoryController@delete')->name('product-delete');
        Route::post('product/category/changestatus',                   'ProductcategoryController@changeStatus')->name('changestatus');
        Route::get('product/sub-category',                   'ProductSubcategoryController@index')->name('product-subcategory');
        Route::post('product/sub-category/store',                   'ProductSubcategoryController@store')->name('product-subcategory-store');
        Route::post('product/sub-category/changestatus',                   'ProductSubcategoryController@changestatus')->name('product-subcategory-changestatus');
        Route::post('product/sub-category/edit',                   'ProductSubcategoryController@edit')->name('product-subcategory-edit');
        Route::post('product/sub-category/update',                   'ProductSubcategoryController@update')->name('product-subcategory-update');
        Route::post('product/sub-category/delete',                   'ProductSubcategoryController@delete')->name('product-subcategory-delete');
        Route::get('product',                   'ProductController@index')->name('product');
        
    });
  
        Route::group(['prefix' => 'admin_user', 'as' => 'admin_user.'], function () {
        Route::post('language',                   'LanguageController@language')->name('language');
        Route::get('index',                   'AdminUserController@index')->name('admin')->middleware('permission:admin_user_view');
        Route::post('store',                   'AdminUserController@store')->name('store_admin')->middleware('permission:admin_user_create');
        Route::post('edit',                   'AdminUserController@edit')->name('edit_admin')->middleware('permission:admin_user_view');
        Route::post('update',                   'AdminUserController@update')->name('update_admin')->middleware('permission:admin_user_update');
        Route::post('delete',                   'AdminUserController@delete')->name('delete_admin')->middleware('permission:admin_user_delete');
    });
    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::get('category',                   'CategoryController@showCategory')->name('showCategory')->middleware('permission:category_view');
        Route::get('/',                           'CategoryController@dataTable')->name('dataTable')->middleware('permission:category_view');
        Route::post('store',                       'CategoryController@store')->name('store')->middleware('permission:category_create');
        Route::post('/getstatus',                   'CategoryController@changeStatus')->name('getstatus')->middleware('permission:category_view');
        Route::post('/getcategory',                   'CategoryController@getcategory')->name('getcategory')->middleware('permission:category_view');
        Route::post('/updatecategory',                   'CategoryController@updatecategory')->name('updatecategory')->middleware('permission:category_update');
        Route::post('/deletecategory',                   'CategoryController@deletecategory')->name('deletecategory')->middleware('permission:category_delete');
    });
    Route::group(['prefix' => 'subcategory', 'as' => 'subcategory.'], function () {
        Route::get('subcategory',                   'SubCategoryController@showCategory')->name('subcategory')->middleware('permission:subcategory_view');
        Route::get('/',                             'SubCategoryController@dataTable')->name('dataTable')->middleware('permission:subcategory_view');
        Route::post('store',                        'SubCategoryController@store')->name('store')->middleware('permission:subcategory_create');
        Route::post('/getstatus',                   'SubCategoryController@changeStatus')->name('getstatus')->middleware('permission:subcategory_view');
        Route::post('/edit',                   'SubCategoryController@edit')->name('edit')->middleware('permission:subcategory_view');
        Route::post('/updatesubcategory',                   'SubCategoryController@updatesubcategory')->name('updatesubcategory')->middleware('permission:subcategory_update');
        Route::post('/deletecategory',                   'SubCategoryController@deletecategory')->name('deletecategory')->middleware('permission:subcategory_delete');;
    });
    Route::get('/',                         'UserController@dataTable')->name('getuser')->middleware('permission:user_view');
    Route::post('/gets',                    'UserController@gets')->name('gets')->middleware('permission:user_view');
    Route::post('/edit',                    'UserController@edit')->name('edit')->middleware('permission:user_view');;
    Route::post('/update',                  'UserController@update')->name('update')->middleware('permission:user_update');;
    Route::post('/getsub',                  'UserController@getsub')->name('getsub')->middleware('permission:user_view');

    Route::post('/delete',                  'UserController@delete')->name('delete')->middleware('permission:user_delete');
    Route::post('/getstate',                 'AddressController@getstate')->name('getstate')->middleware('permission:user_address_view');
    Route::post('/getcity',                 'AddressController@getcity')->name('getcity')->middleware('permission:user_address_view');
    Route::post('/getsubcategory',                 'AddressController@getsubcategory')->name('getsubcategory')->middleware('permission:user_address_view');
    // Route::post('/updateaddres',                 'UserController@updateaddres')->name('updateaddres');
    Route::resource('address',    AddressController::class)->middleware('permission:user_address_create');
    Route::resource('document',   DocumentController::class)->middleware('permission:user_document_view');
    Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {
        Route::get('blog',  'BlogController@blogCategory')->name('blog')->middleware('permission:blog_category_view');
        Route::any('store',  'BlogController@store')->name('store')->middleware('permission:blog_category_create');
        Route::any('/getstatus',  'BlogController@changeStatus')->name('getstatus')->middleware('permission:blog_category_view');
        Route::any('/edit',  'BlogController@edit')->name('edit')->middleware('permission:blog_category_view');
        Route::any('/update',  'BlogController@update')->name('update')->middleware('permission:blog_category_update');
        Route::any('/delete',  'BlogController@delete')->name('delete')->middleware('permission:blog_category_delete');
        Route::any('/blog_list',  'BlogController@blogList')->name('blog_list')->middleware('permission:blog_details_view');
        Route::any('/editblog',  'BlogController@editBlog')->name('editblog')->middleware('permission:blog_details_view');
        Route::any('/updateblog',  'BlogController@updateBlog')->name('updateblog')->middleware('permission:blog_details_update');
        Route::any('/deleteblog',  'BlogController@deleteBlog')->name('deleteblog')->middleware('permission:blog_details_delete');
        Route::any('/bloglikes',  'BlogController@blogLikes')->name('bloglikes')->middleware('permission:blog_details_view');
        Route::any('/blogComment',  'BlogController@blogComment')->name('blogComment')->middleware('permission:blog_comments_view');
        Route::any('/deletecomment',  'BlogController@deleteComment')->name('deletecomment')->middleware('permission:blog_comments_delete');
    });
    Route::group(['prefix' => 'permission', 'as' => 'permission.'], function () {
        Route::get('view',  'PermissionController@view')->name('view');
        Route::post('create',  'PermissionController@create')->name('create');
        Route::post('edit',  'PermissionController@edit')->name('edit');
        Route::post('update',  'PermissionController@update')->name('update');
        Route::post('delete',  'PermissionController@delete')->name('delete');
    });
    Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
        Route::get('viewrole',  'RoleController@viewRole')->name('viewrole')->middleware('permission:Role_permission_view');
        Route::post('store',  'RoleController@create')->name('store')->middleware('permission:Role_permission_create');
        Route::post('deleterole',  'RoleController@deleteRole')->name('deleterole')->middleware('permission:Role_permission_delete');
        Route::get('show/{id}',  'RoleController@show')->name('show')->middleware('permission:Role_permission_view');
        Route::post('assign/{id}',  'RoleController@assign')->name('assign')->middleware('permission:Role_permission_view');
        Route::post('updatepermission',  'RoleController@updatePermission')->name('update-permission')->middleware('permission:Role_permission_view');
    });
});
?>