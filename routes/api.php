<?php

$this->group(['prefix' => '/v1', 'as' => 'api.'], function () {
    $this->post('drinkSaleInvoice', 'Admin\SalesController@sellDrinks');
    $this->resource('discountVoucher', 'Admin\GiftVoucherController');
    $this->get('getperformance', 'Stats\AnalyticsController@getStats');
});

$this->get('getlastorder', 'Admin\SalesController@getLastRecord');
$this->get('config-cache', function () {
    return Artisan::call('config:cache');
});
$this->post('drinkSaleInvoice', 'Admin\SalesController@sellDrinks');
$this->get('clear-cache', function () {
    return Artisan::call('cache:clear');
});
$this->get('ProductsInCart', 'Admin\SalesController@getLastCart');
$this->get('printInvoice', 'Admin\BookingsController@printInvoice');

$this->post('getselectedProduct', 'Admin\SalesController@getSelectedProducts');

$this->get('test-email', 'JobController@processQueue');
