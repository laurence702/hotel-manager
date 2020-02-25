<?php

Route::group(['prefix' => '/v1', 'as' => 'api.'], function () {
        Route::post('testsome', function(){
        return [
            'success' => true,
            'data' => request()->all()
        ];
    });
    Route::post('drinkSaleInvoice','Admin\SalesController@sellDrinks');
});

Route::get('getlastorder','Admin\SalesController@getLastRecord');
Route::get('config-cache', function() {
    return Artisan::call('config:cache');
});
Route::post('drinkSaleInvoice','Admin\SalesController@sellDrinks');
Route::get('clear-cache', function() {
    return Artisan::call('cache:clear');
});
Route::get('ProductsInCart','Admin\SalesController@getLastCart');
Route::get('printInvoice','Admin\BookingsController@printInvoice');
//Route::post('createBooking','Admin\BookingsController@store');

//
Route::post('creatCart','Admin\SalesController@createCart');
Route::get('getcart','Admin\SalesController@getCartItems');

///
Route::post('getselectedProduct','Admin\SalesController@getSelectedProducts');

Route::get('test-email', 'JobController@processQueue');
