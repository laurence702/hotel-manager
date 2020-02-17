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
Route::get('printInvoice','Admin\BookingsController@printInvoice');
