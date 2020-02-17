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
Route::get('clear-cache', function() {
    return Artisan::call('cache:clear');
});
Route::get('printInvoice','Admin\BookingsController@printInvoice');

Route::post('createBooking','Admin\BookingsController@store');
