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


            //start Adevertising Consolution media type routing

            Route::get('/cat/advertisingconsolution-list', [
                'uses' => 'AdvertisingconsolutionController@getDashboardAdvertisingConsolutionList',
                'as' => 'dashboard.getAdvertisingConsolutionList'
            ]);


             Route::get('/cat/add-advertisingconsolution', [
                'uses' => 'AdvertisingconsolutionController@getDashboardAdvertisingConsolutionForm',
                'as' => 'dashboard.getAdvertisingConsolutionForm'
            ]);

            //End Airport media type routing

     // *************************************  //

            //start Airport media type routing

            Route::get('/cat/airport-list', [
                'uses' => 'AirportController@getDashboardAirportList',
                'as' => 'dashboard.getAirportList'
            ]);


             Route::get('/cat/add-airport', [
                'uses' => 'AirportController@getDashboardAirportForm',
                'as' => 'dashboard.getAirportForm'
            ]);

             Route::post('/cat/add-airport', [
                'uses' => 'AirportController@postDashboardAirportForm',
                'as' => 'dashboard.postAirportForm'
            ]);

            Route::get('/cat/delete-airport/{airportadID}', [
                'uses' => 'AirportController@getDeleteAirportad',
                'as' => 'dashboard.deleteAirportad'
            ]);
            Route::get('/cat/edit-airport/{ID}', [
                'uses' => 'AirportController@getUpdateeAirportad',
                'as' => 'dashboard.editairportsad'
            ]);
            Route::get('/cat/edit-removeuncheckoptions/', [
                'uses' => 'AirportController@getuncheckAirportadOptions',
                'as' => 'dashboard.deleteUncheckPrice'
            ]);
            
            Route::post('/cat/edit-airport/{ID}', [
                'uses' => 'AirportController@postUpdateeAirportad',
                'as' => 'dashboard.Postairportsad'
            ]);

            //End Airport media type routing

     // *************************************  //

             //start Autos media type routing

            Route::get('/cat/auto-list', [
                'uses' => 'AutoController@getDashboardAutoList',
                'as' => 'dashboard.getAutoList'
            ]);


             Route::get('/cat/add-auto', [
                'uses' => 'AutoController@getDashboardAutoForm',
                'as' => 'dashboard.getAutoForm'
            ]);

                        
            Route::post('/cat/add-auto', [
                'uses' => 'AutoController@postDashboardAutoForm',
                'as' => 'dashboard.postAutoForm'
            ]);

            Route::get('/cat/delete-auto/{autoadID}', [
                'uses' => 'AutoController@getDeleteAutoad',
                'as' => 'dashboard.deleteAutoad'
            ]);
            Route::get('/cat/edit-auto/{ID}', [
                'uses' => 'AutoController@getUpdateeAutoad',
                'as' => 'dashboard.editautosad'
            ]);
            Route::get('/cat/edit-removeuncheckoptions/', [
                'uses' => 'AutoController@getuncheckAutoadOptions',
                'as' => 'dashboard.deleteUncheckPrice'
            ]);
            
            Route::post('/cat/edit-auto/{ID}', [
                'uses' => 'AutoController@postUpdateeAutoad',
                'as' => 'dashboard.Postbusesad'
            ]);
            
           

            //End Autos media type routing

     // *************************************  //

             //start Billboard media type routing

            Route::get('/cat/billboard-list', [
                'uses' => 'BillboardController@getDashboardBillboardList',
                'as' => 'dashboard.getBillboardList'
            ]);


             Route::get('/cat/add-billboard', [
                'uses' => 'BillboardController@getDashboardBillboardForm',
                'as' => 'dashboard.getBillboardForm'
            ]);

                Route::post('/cat/add-billboard', [
                'uses' => 'BillboardController@postDashboardBillboardForm',
                'as' => 'dashboard.postBillboardForm'
            ]);

            Route::get('/cat/delete-billboard/{billboardadID}', [
                'uses' => 'BillboardController@getDeleteBillboardad',
                'as' => 'dashboard.deleteBillboardad'
            ]);
            Route::get('/cat/edit-billboard/{ID}', [
                'uses' => 'BillboardController@getUpdateeBillboardad',
                'as' => 'dashboard.editbillboardsad'
            ]);
            Route::get('/cat/edit-removeuncheckoptions/', [
                'uses' => 'BillboardController@getuncheckBillboardadOptions',
                'as' => 'dashboard.deleteUncheckPrice'
            ]);
            
            Route::post('/cat/edit-billboard/{ID}', [
                'uses' => 'BillboardController@postUpdateeBillboardad',
                'as' => 'dashboard.Postcaresad'
            ]);

            //End Billboard media type routing

     // *************************************  //


            //start bus media type routing

            Route::get('/cat/bus-list', [
                'uses' => 'BusController@getDashboardBusList',
                'as' => 'dashboard.getBusList'
            ]);

            Route::get('/cat/add-bus', [
                'uses' => 'BusController@getDashboardBusForm',
                'as' => 'dashboard.getBusForm'
            ]);
                        
            Route::post('/cat/add-bus', [
                'uses' => 'BusController@postDashboardBusForm',
                'as' => 'dashboard.postBusForm'
            ]);

            Route::get('/cat/delete-bus/{busadID}', [
                'uses' => 'BusController@getDeleteBusad',
                'as' => 'dashboard.deleteBusad'
            ]);
            Route::get('/cat/edit-bus/{ID}', [
                'uses' => 'BusController@getUpdateeBusad',
                'as' => 'dashboard.editbusesad'
            ]);
            Route::get('/cat/edit-removeuncheckoptions/', [
                'uses' => 'BusController@getuncheckBusadOptions',
                'as' => 'dashboard.deleteUncheckPrice'
            ]);
            
            Route::post('/cat/edit-bus/{ID}', [
                'uses' => 'BusController@postUpdateeBusad',
                'as' => 'dashboard.Postbusesad'
            ]);
            
           //End Bus media type routing
           


    // *************************************  //


           //start Bus stop media type routing
             Route::get('/cat/busstop-list', [
                'uses' => 'BusStopController@getDashboardBusstopList',
                'as' => 'dashboard.getBusstopList'
            ]);

             Route::get('/cat/add-busstop', [
                'uses' => 'BusStopController@getDashboardBusstopForm',
                'as' => 'dashboard.getBusstopForm'
            ]);

             Route::post('/cat/add-busstop', [
                'uses' => 'BusStopController@postDashboardBusstopForm',
                'as' => 'dashboard.postBusstopForm'
            ]);

            Route::get('/cat/delete-busstop/{busstopadID}', [
                'uses' => 'BusStopController@getDeleteBusstopad',
                'as' => 'dashboard.deleteBusstopad'
            ]);
            Route::get('/cat/edit-busstop/{ID}', [
                'uses' => 'BusStopController@getUpdateeBusstopad',
                'as' => 'dashboard.editbusstopsad'
            ]);
            Route::get('/cat/edit-removeuncheckoptions/', [
                'uses' => 'BusStopController@getuncheckBusstopadOptions',
                'as' => 'dashboard.deleteUncheckPrice'
            ]);
            
            Route::post('/cat/edit-busstop/{ID}', [
                'uses' => 'BusStopController@postUpdateeBusstopad',
                'as' => 'dashboard.Postbusstopsad'
            ]);
            

           //End Bus stop media type routing
           

     // *************************************  //

              //start Car media type routing

            Route::get('/cat/car-list', [
                'uses' => 'CarController@getDashboardCarList',
                'as' => 'dashboard.getCarList'
            ]);


             Route::get('/cat/add-car', [
                'uses' => 'CarController@getDashboardCarForm',
                'as' => 'dashboard.getCarForm'
            ]);

              Route::post('/cat/add-car', [
                'uses' => 'CarController@postDashboardCarForm',
                'as' => 'dashboard.postCarForm'
            ]);

            Route::get('/cat/delete-car/{caradID}', [
                'uses' => 'CarController@getDeleteCarad',
                'as' => 'dashboard.deleteCarad'
            ]);
            Route::get('/cat/edit-car/{ID}', [
                'uses' => 'CarController@getUpdateeCarad',
                'as' => 'dashboard.editcarsad'
            ]);
            Route::get('/cat/edit-removeuncheckoptions/', [
                'uses' => 'CarController@getuncheckCaradOptions',
                'as' => 'dashboard.deleteUncheckPrice'
            ]);
            
            Route::post('/cat/edit-car/{ID}', [
                'uses' => 'CarController@postUpdateeCarad',
                'as' => 'dashboard.Postcarsad'
            ]);

            //End Car media type routing

     // *************************************  //


             //start Cinema media type routing

            Route::get('/cat/cinema-list', [
                'uses' => 'CinemaController@getDashboardCinemaList',
                'as' => 'dashboard.getCinemaList'
            ]);


             Route::get('/cat/add-cinema', [
                'uses' => 'CinemaController@getDashboardCinemaForm',
                'as' => 'dashboard.getCinemaForm'
            ]);


            Route::post('/cat/add-cinema', [
                'uses' => 'CinemaController@postDashboardCinemaForm',
                'as' => 'dashboard.postCinemaForm'
            ]);

            Route::get('/cat/delete-cinema/{cinemaadID}', [
                'uses' => 'CinemaController@getDeleteCinemaad',
                'as' => 'dashboard.deleteCinemaad'
            ]);
            Route::get('/cat/edit-cinema/{ID}', [
                'uses' => 'CinemaController@getUpdateeCinemaad',
                'as' => 'dashboard.editcinemasad'
            ]);
            Route::get('/cat/edit-removeuncheckoptions/', [
                'uses' => 'CinemaController@getuncheckCinemaadOptions',
                'as' => 'dashboard.deleteUncheckPrice'
            ]);
            
            Route::post('/cat/edit-cinema/{ID}', [
                'uses' => 'CinemaController@postUpdateeCinemaad',
                'as' => 'dashboard.Postcaresad'
            ]);

            //End Cinema media type routing

     // *************************************  //

             //start Metro media type routing

            Route::get('/cat/metro-list', [
                'uses' => 'MetroController@getDashboardMetroList',
                'as' => 'dashboard.getMetroList'
            ]);


             Route::get('/cat/add-metro', [
                'uses' => 'MetroController@getDashboardMetroForm',
                'as' => 'dashboard.getMetroForm'
            ]);

             Route::post('/cat/add-metro', [
                'uses' => 'MetroController@postDashboardMetroForm',
                'as' => 'dashboard.postMetroForm'
            ]);

            Route::get('/cat/delete-metro/{metroadID}', [
                'uses' => 'MetroController@getDeleteMetroad',
                'as' => 'dashboard.deleteMetroad'
            ]);
            Route::get('/cat/edit-metro/{ID}', [
                'uses' => 'MetroController@getUpdateeMetroad',
                'as' => 'dashboard.editmetrosad'
            ]);
            Route::get('/cat/edit-removeuncheckoptions/', [
                'uses' => 'MetroController@getuncheckMetroadOptions',
                'as' => 'dashboard.deleteUncheckPrice'
            ]);
            
            Route::post('/cat/edit-metro/{ID}', [
                'uses' => 'MetroController@postUpdateeMetroad',
                'as' => 'dashboard.Postmetrosad'
            ]);

            //End Metro media type routing

     // *************************************  //

             //start Newspaper media type routing

            Route::get('/cat/newspaper-list', [
                'uses' => 'NewspaperController@getDashboardNewspaperList',
                'as' => 'dashboard.getNewspaperList'
            ]);


             Route::get('/cat/add-newspaper', [
                'uses' => 'NewspaperController@getDashboardNewspaperForm',
                'as' => 'dashboard.getNewspaperForm'
            ]);

                 Route::post('/cat/add-newspaper', [
                'uses' => 'NewspaperController@postDashboardNewspaperForm',
                'as' => 'dashboard.postNewspaperForm'
            ]);

            Route::get('/cat/delete-newspaper/{newspaperadID}', [
                'uses' => 'NewspaperController@getDeleteNewspaperad',
                'as' => 'dashboard.deleteNewspaperad'
            ]);
            Route::get('/cat/edit-newspaper/{ID}', [
                'uses' => 'NewspaperController@getUpdateeNewspaperad',
                'as' => 'dashboard.editnewspapersad'
            ]);
            Route::get('/cat/edit-removeuncheckoptions/', [
                'uses' => 'NewspaperController@getuncheckNewspaperadOptions',
                'as' => 'dashboard.deleteUncheckPrice'
            ]);
            
            Route::post('/cat/edit-newspaper/{ID}', [
                'uses' => 'NewspaperController@postUpdateeNewspaperad',
                'as' => 'dashboard.Postcaresad'
            ]);

            //End Newspaper media type routing

     // *************************************  //


             //start Shoppingmall media type routing

            Route::get('/cat/shoppingmall-list', [
                'uses' => 'ShoppingmallController@getDashboardShoppingmallList',
                'as' => 'dashboard.getShoppingmallList'
            ]);


             Route::get('/cat/add-shoppingmall', [
                'uses' => 'ShoppingmallController@getDashboardShoppingmallForm',
                'as' => 'dashboard.getShoppingmallForm'
            ]);


            Route::post('/cat/add-shoppingmall', [
                'uses' => 'ShoppingmallController@postDashboardShoppingmallForm',
                'as' => 'dashboard.postShoppingmallForm'
            ]);

            Route::get('/cat/delete-shoppingmall/{shoppingmalladID}', [
                'uses' => 'ShoppingmallController@getDeleteShoppingmallad',
                'as' => 'dashboard.deleteShoppingmallad'
            ]);
            Route::get('/cat/edit-shoppingmall/{ID}', [
                'uses' => 'ShoppingmallController@getUpdateeShoppingmallad',
                'as' => 'dashboard.editshoppingmallsad'
            ]);
            Route::get('/cat/edit-removeuncheckoptions/', [
                'uses' => 'ShoppingmallController@getuncheckShoppingmalladOptions',
                'as' => 'dashboard.deleteUncheckPrice'
            ]);
            
            Route::post('/cat/edit-shoppingmall/{ID}', [
                'uses' => 'ShoppingmallController@postUpdateeShoppingmallad',
                'as' => 'dashboard.Postshoppingmallsad'
            ]);

            //End Shoppingmall media type routing

     // *************************************  //

             //start Socialmedia media type routing

            Route::get('/cat/socialmedia-list', [
                'uses' => 'SocialmediaController@getDashboardSocialmediaList',
                'as' => 'dashboard.getSocialmediaList'
            ]);


             Route::get('/cat/add-socialmedia', [
                'uses' => 'SocialmediaController@getDashboardSocialmediaForm',
                'as' => 'dashboard.getSocialmediaForm'
            ]);

            //End Socialmedia media type routing

     // *************************************  //









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

Route::get('/media-type/{catName}', [
    'uses' => 'ProductContoller@getProductsByCat',
    'as' => 'frontend.adProductsByName'
]);

/*Route::get('/add-to-cart/{id}', [
    'uses' => 'ProductContoller@getAddToCart',
    'as' => 'product.addtocart'
]);*/
Route::group(['middleware' => 'user'], function(){    
    /*Route::get('/shop/cart', [
        'uses' => 'productContoller@getCart',
        'as' => 'product.shoppingCart',
        'middleware' => 'auth'
    ]);*/

   

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

        Route::group( ['middleware' => 'admin'], function(){
       
            Route::get('/profile', [
            'uses' => 'ProfileController@getProfile',
            'as' => 'user.profile'
            ]);

            Route::get('/logout',[
                'uses' => 'UserController@getLogout',
                'as' => 'user.logout'
            ]);

        });
        
    });



    // FRONTEND MEDIA STARTS



// **********************************    
  
    // airport frontend starts
    Route::get('/media/airports-ads', [
        'uses' => 'AirportController@getfrontendAllAirportads',
        'as' => 'frontend.getallairports'
    ]);
    Route::get('/media/airport/{id}', [
        'uses' => 'AirportController@getfrontAirportad',
        'as' => 'frontend.airportsingle'
    ]);

    Route::get('/media/airport/add-to-cart/{id}/{variation}', [
        'uses' => 'AirportController@getAddToCart',
        'as' => 'airport.addtocart'
    ]);
    Route::get('/media/airport/remove-from-cart/{id}/{variation}', [
        'uses' => 'AirportController@getRemoveFromCart',
        'as' => 'airport.removefromcart'
    ]);
    
    // airport frontend ends

// **********************************

    // auto frontend starts
    Route::get('/media/autos-ads', [
        'uses' => 'AutoController@getfrontendAllAutoads',
        'as' => 'frontend.getallautos'
    ]);
    Route::get('/media/auto/{id}', [
        'uses' => 'AutoController@getfrontAutoad',
        'as' => 'frontend.autosingle'
    ]);

    Route::get('/media/auto/add-to-cart/{id}/{variation}', [
        'uses' => 'AutoController@getAddToCart',
        'as' => 'auto.addtocart'
    ]);
    Route::get('/media/auto/remove-from-cart/{id}/{variation}', [
        'uses' => 'AutoController@getRemoveFromCart',
        'as' => 'auto.removefromcart'
    ]);
    
    // auto frontend ends

// **********************************

    // billboard frontend starts
    Route::get('/media/billboards-ads', [
        'uses' => 'BillboardController@getfrontendAllBillboardads',
        'as' => 'frontend.getallbillboards'
    ]);
    Route::get('/media/billboard/{id}', [
        'uses' => 'BillboardController@getfrontBillboardad',
        'as' => 'frontend.billboardsingle'
    ]);

    Route::get('/media/billboard/add-to-cart/{id}/{variation}', [
        'uses' => 'BillboardController@getAddToCart',
        'as' => 'billboard.addtocart'
    ]);
    Route::get('/media/billboard/remove-from-cart/{id}/{variation}', [
        'uses' => 'BillboardController@getRemoveFromCart',
        'as' => 'billboard.removefromcart'
    ]);
    
    // billboard frontend ends


// **********************************

        // bus frontend starts
    Route::get('/media/buses-ads', [
        'uses' => 'BusController@getfrontendAllBusads',
        'as' => 'frontend.getallbuses'
    ]);
    Route::get('/media/bus/{id}', [
        'uses' => 'BusController@getfrontBusad',
        'as' => 'frontend.bussingle'
    ]);

    Route::get('/media/bus/add-to-cart/{id}/{variation}', [
        'uses' => 'BusController@getAddToCart',
        'as' => 'bus.addtocart'
    ]);
    Route::get('/media/bus/remove-from-cart/{id}/{variation}', [
        'uses' => 'BusController@getRemoveFromCart',
        'as' => 'bus.removefromcart'
    ]);
    
    // bus frontend ends

// **********************************    

    // busstop frontend starts
    Route::get('/media/busstops-ads', [
        'uses' => 'BusStopController@getfrontendAllBusstopads',
        'as' => 'frontend.getallbusstops'
    ]);
    Route::get('/media/busstop/{id}', [
        'uses' => 'BusStopController@getfrontBusstopad',
        'as' => 'frontend.busstopsingle'
    ]);

    Route::get('/media/busstop/add-to-cart/{id}/{variation}', [
        'uses' => 'BusStopController@getAddToCart',
        'as' => 'busstop.addtocart'
    ]);
    Route::get('/media/busstop/remove-from-cart/{id}/{variation}', [
        'uses' => 'BusStopController@getRemoveFromCart',
        'as' => 'busstop.removefromcart'
    ]);
    
    // busstop frontend ends

// **********************************

    // car frontend starts
    Route::get('/media/cars-ads', [
        'uses' => 'CarController@getfrontendAllCarads',
        'as' => 'frontend.getallcars'
    ]);
    Route::get('/media/car/{id}', [
        'uses' => 'CarController@getfrontCarad',
        'as' => 'frontend.carsingle'
    ]);

    Route::get('/media/car/add-to-cart/{id}/{variation}', [
        'uses' => 'CarController@getAddToCart',
        'as' => 'car.addtocart'
    ]);
    Route::get('/media/car/remove-from-cart/{id}/{variation}', [
        'uses' => 'CarController@getRemoveFromCart',
        'as' => 'car.removefromcart'
    ]);
    
    // car frontend ends

// **********************************

    // cinema frontend starts
    Route::get('/media/cinemas-ads', [
        'uses' => 'CinemaController@getfrontendAllCinemaads',
        'as' => 'frontend.getallcinemas'
    ]);
    Route::get('/media/cinema/{id}', [
        'uses' => 'CinemaController@getfrontCinemaad',
        'as' => 'frontend.cinemasingle'
    ]);

    Route::get('/media/cinema/add-to-cart/{id}/{variation}', [
        'uses' => 'CinemaController@getAddToCart',
        'as' => 'cinema.addtocart'
    ]);
    Route::get('/media/cinema/remove-from-cart/{id}/{variation}', [
        'uses' => 'CinemaController@getRemoveFromCart',
        'as' => 'cinema.removefromcart'
    ]);
    
    // cinema frontend ends

// **********************************

    // metro frontend starts
    Route::get('/media/metros-ads', [
        'uses' => 'MetroController@getfrontendAllMetroads',
        'as' => 'frontend.getallmetros'
    ]);
    Route::get('/media/metro/{id}', [
        'uses' => 'MetroController@getfrontMetroad',
        'as' => 'frontend.metrosingle'
    ]);

    Route::get('/media/metro/add-to-cart/{id}/{variation}', [
        'uses' => 'MetroController@getAddToCart',
        'as' => 'metro.addtocart'
    ]);
    Route::get('/media/metro/remove-from-cart/{id}/{variation}', [
        'uses' => 'MetroController@getRemoveFromCart',
        'as' => 'metro.removefromcart'
    ]);
    
    // metro frontend ends

// **********************************

    // newspaper frontend starts
    Route::get('/media/newspapers-ads', [
        'uses' => 'NewspaperController@getfrontendAllNewspaperads',
        'as' => 'frontend.getallnewspapers'
    ]);
    Route::get('/media/newspaper/{id}', [
        'uses' => 'NewspaperController@getfrontNewspaperad',
        'as' => 'frontend.newspapersingle'
    ]);

    Route::get('/media/newspaper/add-to-cart/{id}/{variation}', [
        'uses' => 'NewspaperController@getAddToCart',
        'as' => 'newspaper.addtocart'
    ]);
    Route::get('/media/newspaper/remove-from-cart/{id}/{variation}', [
        'uses' => 'NewspaperController@getRemoveFromCart',
        'as' => 'newspaper.removefromcart'
    ]);
    
    // newspaper frontend ends

// **********************************

    // shoppingmall frontend starts
    Route::get('/media/shoppingmalls-ads', [
        'uses' => 'ShoppingmallController@getfrontendAllShoppingmallads',
        'as' => 'frontend.getallshoppingmalls'
    ]);
    Route::get('/media/shoppingmall/{id}', [
        'uses' => 'ShoppingmallController@getfrontShoppingmallad',
        'as' => 'frontend.shoppingmallsingle'
    ]);

    Route::get('/media/shoppingmall/add-to-cart/{id}/{variation}', [
        'uses' => 'ShoppingmallController@getAddToCart',
        'as' => 'shoppingmall.addtocart'
    ]);
    Route::get('/media/shoppingmall/remove-from-cart/{id}/{variation}', [
        'uses' => 'ShoppingmallController@getRemoveFromCart',
        'as' => 'shoppingmall.removefromcart'
    ]);
    
    // shoppingmall frontend ends

// **********************************

    // socialmedia frontend starts
    Route::get('/media/socialmedias-ads', [
        'uses' => 'SocialmediaController@getfrontendAllSocialmediaads',
        'as' => 'frontend.getallsocialmedias'
    ]);
    Route::get('/media/socialmedia/{id}', [
        'uses' => 'SocialmediaController@getfrontSocialmediaad',
        'as' => 'frontend.socialmediasingle'
    ]);

    Route::get('/media/socialmedia/add-to-cart/{id}/{variation}', [
        'uses' => 'SocialmediaController@getAddToCart',
        'as' => 'socialmedia.addtocart'
    ]);
    Route::get('/media/socialmedia/remove-from-cart/{id}/{variation}', [
        'uses' => 'SocialmediaController@getRemoveFromCart',
        'as' => 'socialmedia.removefromcart'
    ]);
    
    // socialmedia frontend ends







// ***************--CART OPTIONS--***************

    // Cart options start
      Route::get('/shop/cart', [
        'uses' => 'CartController@getCart',
        'as' => 'cart.shoppingCart',
    ]);

    Route::get('/shop/cart/{id}', [
        'uses' => 'CartController@removeItemFromCart',
        'as' => 'Cart.removeItemCart',
    ]);

     Route::get('/shop/checkout', [
        'uses' => 'CheckoutController@getCheckout',
        'as' => 'checkout'
       
    ]);

    Route::post('/shop/checkout', [
        'uses' => 'CheckoutController@postCheckout',
        'as' => 'checkout'
       
    ]);


