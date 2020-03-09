<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::group(['prefix' => '/v1', 'as' => 'api.'], function () {
    $this->post('drinkSaleInvoice', 'Admin\SalesController@sellDrinks');
    $this->resource('discountVoucher', 'Admin\GiftVoucherController');
    $this->post('getperformance', 'Stats\AnalyticsController@getStats');
    $this->get('getperformancetoday', 'Stats\AnalyticsController@getStatsToday');
});

$this->get('getlastorder', 'Admin\SalesController@getLastRecord');
$this->post('drinkSaleInvoice', 'Admin\SalesController@sellDrinks');
$this->get('ProductsInCart', 'Admin\SalesController@getLastCart');
$this->get('printInvoice', 'Admin\BookingsController@printInvoice');
$this->post('getselectedProduct', 'Admin\SalesController@getSelectedProducts');
$this->get('test-email', 'JobController@processQueue');

Route::get('/clear-cache', function () {
    $run = Artisan::call('config:clear');
    $run = Artisan::call('cache:clear');
    $run = Artisan::call('config:cache');
    return 'FINISHED';
});
