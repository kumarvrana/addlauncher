<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', [
    'uses' => 'ProductContoller@getIndex',
    'as' => 'product.mainCats'
]);
/** start admin panel routes **/
Route::get('/dashboard', [
    'uses' => 'DashboardController@getDashboard',
    'as' => 'dashboard'
]);

 Route::get('/add-product',[
    'uses' => 'ProductContoller@getHTMLContentByMediaType',
    'as' => 'dashboard.getproductvariationshtmlbycat'
    ]);

Route::group([ 'prefix' => 'dashboard'], function(){
    Route::get('/category-list', [
        'uses' => 'DashboardController@getAddList',
        'as' => 'dashboard.addCategoryList'
    ]);

    Route::get('/add-category',[
        'uses' => 'DashboardController@getAddCategory',
        'as' => 'dashboard.addCategory'
    ]);

    Route::post('/add-category',[
        'uses' => 'DashboardController@postAddCategory',
        'as' => 'dashboard.addCategory'
    ]);

    
    Route::get('/delete-category/{catID}', [
        'uses' => 'DashboardController@getDeleteCategory',
        'as' => 'dashboard.getdeletecat'
    ]);

   
    Route::get('/edit-category/{edit}', [
        'uses' => 'DashboardController@getEditCategory',
        'as' => 'dashboard.editcategory'
    ]);
     Route::post('/edit-category/{editcatid}', [
        'uses' => 'DashboardController@postUpdateCategory',
        'as' => 'dashboard.updatecategory'
    ]);

    Route::get('/products', [
        'uses' => 'ProductContoller@getAllProducts',
        'as' => 'dashboard.getproductlist'
    ]);

    Route::get('/add-product', [
        'uses' => 'ProductContoller@getAddProduct',
        'as' => 'dashboard.getproduct'
    ]);

   

    Route::post('/add-product',[
        'uses' => 'ProductContoller@postProduct',
        'as' => 'dashboard.postproduct'
    ]);
    
    Route::get('/delete-product/{productID}', [
        'uses' => 'ProductContoller@getDeleteProduct',
        'as' => 'dashboard.getdeleteproduct'
    ]);
    Route::get('/edit-product/{productID}', [
        'uses' => 'ProductContoller@getEditProduct',
        'as' => 'dashboard.getEditproduct'
    ]);
    
    Route::post('/edit-product/{editProductID}', [
        'uses' => 'ProductContoller@updateProduct',
        'as' => 'dashboard.updateProduct'
    ]);   

});
/** end admin panel routes **/
Route::get('/products', [
    'uses' => 'ProductContoller@getProducts',
    'as' => 'product.index'
]);

Route::get('/{catName}', [
    'uses' => 'ProductContoller@getProductsByCat',
    'as' => 'frontend.adProductsByName'
]);

Route::get('/add-to-cart/{id}', [
    'uses' => 'ProductContoller@getAddToCart',
    'as' => 'product.addtocart'
]);

Route::get('/shopping-cart', [
    'uses' => 'productContoller@getCart',
    'as' => 'product.shoppingCart'
]);

Route::get('/checkout', [
    'uses' => 'ProductContoller@getCheckout',
    'as' => 'checkout',
    'middleware' => 'auth'
]);

Route::post('/checkout', [
    'uses' => 'ProductContoller@postCheckout',
    'as' => 'checkout',
    'middleware' => 'auth'
]);

Route::group([ 'prefix' => 'user'], function(){
    
    Route::group(['middleware' => 'guest'], function(){
        Route::get('/signup', [
        'uses' => 'UserController@getSignup',
        'as' => 'user.signup'
        ]);

        Route::post('/signup', [
            'uses' => 'UserController@postSignup',
            'as' => 'user.signup'
        ]);

        Route::get('/signin', [
            'uses' => 'UserController@getSignin',
            'as' => 'user.signin'
        ]);

        Route::post('/signin', [
            'uses' => 'UserController@PostSignin',
            'as' => 'user.signin'
        ]);
    });
    
    Route::group( ['middleware' => 'auth'], function(){
       
        Route::get('/profile', [
        'uses' => 'UserController@getProfile',
        'as' => 'user.profile'
        ]);

        Route::get('/logout',[
            'uses' => 'UserController@getLogout',
            'as' => 'user.logout'
        ]);

    });
    

});

