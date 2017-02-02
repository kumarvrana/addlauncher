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



 Route::get('/add-product',[
    'uses' => 'ProductContoller@getHTMLContentByMediaType',
    'as' => 'dashboard.getproductvariationshtmlbycat'
    ]);
Route::group( ['middleware' => 'admin'], function(){
    Route::get('/dashboard', [
    'uses' => 'DashboardController@getDashboard',
    'as' => 'dashboard'
    ]);
        Route::group([ 'prefix' => 'dashboard'], function(){
            Route::get('/category-list', [
                'uses' => 'MainaddtypeController@getAddList',
                'as' => 'dashboard.addCategoryList'
            ]);
            Route::get('/addproductform', [
                'uses' => 'ProductContoller@getproductform',
                'as' => 'dashboard.multistepproductform'
            ]);

            
            Route::post('/addproductform',[
                'uses' => 'ProductContoller@postProduct',
                'as' => 'dashboard.postproductform'
            ]);

            Route::get('/add-category',[
                'uses' => 'MainaddtypeController@getAddCategory',
                'as' => 'dashboard.addCategory'
            ]);

            Route::post('/add-category',[
                'uses' => 'MainaddtypeController@postAddCategory',
                'as' => 'dashboard.addCategory'
            ]);

            
            Route::get('/delete-category/{catID}', [
                'uses' => 'MainaddtypeController@getDeleteCategory',
                'as' => 'dashboard.getdeletecat'
            ]);

        
            Route::get('/edit-category/{edit}', [
                'uses' => 'MainaddtypeController@getEditCategory',
                'as' => 'dashboard.editcategory'
            ]);
            Route::post('/edit-category/{editcatid}', [
                'uses' => 'MainaddtypeController@postUpdateCategory',
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
Route::group(['middleware' => 'user'], function(){    
    Route::get('/shop/cart', [
        'uses' => 'productContoller@getCart',
        'as' => 'product.shoppingCart',
        'middleware' => 'auth'
    ]);

    Route::get('/shop/checkout', [
        'uses' => 'ProductContoller@getCheckout',
        'as' => 'checkout',
        'middleware' => 'auth'
    ]);

    Route::post('/shop/checkout', [
        'uses' => 'ProductContoller@postCheckout',
        'as' => 'checkout',
        'middleware' => 'auth'
    ]);

});

Route::get('/product/{id}', [
    'uses' => 'ProductContoller@getProductSingle',
    'as'   => 'frontend.productsingle'
]);



Route::group([ 'prefix' => 'user'], function(){
    
    Route::group(['middleware' => 'visiter'], function(){
        
            Route::get('/signup', [
            'uses' => 'RegistrationController@getSignup',
            'as' => 'user.signup'
            ]);

            Route::post('/signup', [
                'uses' => 'RegistrationController@postSignup',
                'as' => 'user.postsignup'
            ]);

            Route::get('/signin', [
                'uses' => 'LoginController@getSignin',
                'as' => 'user.signin'
            ]);

            Route::post('/signin', [
                'uses' => 'LoginController@PostSignin',
                'as' => 'user.postsignin'
            ]);
        
        });
        Route::post('/signout', [
            'uses' => 'LoginController@postLogout',
            'as' => 'user.postsignout'
        ]);

        Route::get('/activate/{email}/{activationCode}', [
            'uses' => 'ActivationController@activate',
            'as' => 'user.activate'
        ]);

        Route::get('/forget-password', [
            'uses' => 'ForgetPasswordController@getForgetPassword',
            'as' => 'user.forgetpassword'
        ]);

        Route::post('/forget-password', [
            'uses' => 'ForgetPasswordController@postForgetPassword',
            'as' => 'user.postforgetpassword'
        ]);

        Route::get('/reset-password/{email}/{code}', [
            'uses' => 'ForgetPasswordController@resetPassword',
            'as' => 'user.resetpassword'
        ]);
        Route::post('/reset-password/{email}/{code}', [
            'uses' => 'ForgetPasswordController@postResetPassword',
            'as' => 'user.postresetpassword'
        ]);

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
    
  
    


