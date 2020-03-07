<?php
Route::get('/', function () {
    return redirect('/admin/home');
});


Route::get('event', function () {
    event(new App\Events\TaskEvent('Hey how are you!'));
});

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');
$this->get('getperformance', 'Stats\AnalyticsController@getStats'); //review for delete, route now by Vue.js

$this->group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    $this->get('/home', 'HomeController@index');

    $this->resource('roles', 'Admin\RolesController');
    $this->post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    $this->resource('users', 'Admin\UsersController');
    $this->post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

    $this->resource('categories', 'Admin\CategoryController');
    $this->post('categories_mass_destroy', ['uses' => 'Admin\CategoryController@massDestroy', 'as' => 'categories.mass_destroy']);
    $this->post('categories_restore/{id}', ['uses' => 'Admin\CategoryController@restore', 'as' => 'categories.restore']);
    $this->delete('categories_perma_del/{id}', ['uses' => 'Admin\CategoryController@perma_del', 'as' => 'categories.perma_del']);

    $this->resource('countries', 'Admin\CountriesController');
    $this->post('countries_mass_destroy', ['uses' => 'Admin\CountriesController@massDestroy', 'as' => 'countries.mass_destroy']);
    $this->post('countries_restore/{id}', ['uses' => 'Admin\CountriesController@restore', 'as' => 'countries.restore']);
    $this->delete('countries_perma_del/{id}', ['uses' => 'Admin\CountriesController@perma_del', 'as' => 'countries.perma_del']);
    $this->resource('customers', 'Admin\CustomersController');
    $this->post('customers_mass_destroy', ['uses' => 'Admin\CustomersController@massDestroy', 'as' => 'customers.mass_destroy']);
    $this->post('customers_restore/{id}', ['uses' => 'Admin\CustomersController@restore', 'as' => 'customers.restore']);
    $this->delete('customers_perma_del/{id}', ['uses' => 'Admin\CustomersController@perma_del', 'as' => 'customers.perma_del']);
    $this->resource('rooms', 'Admin\RoomsController');
    $this->post('rooms_mass_destroy', ['uses' => 'Admin\RoomsController@massDestroy', 'as' => 'rooms.mass_destroy']);
    $this->post('rooms_restore/{id}', ['uses' => 'Admin\RoomsController@restore', 'as' => 'rooms.restore']);
    $this->delete('rooms_perma_del/{id}', ['uses' => 'Admin\RoomsController@perma_del', 'as' => 'rooms.perma_del']);
    $this->resource('bookings', 'Admin\BookingsController', ['except' => 'bookings.create']);
    $this->get('bookings/create/', ['as' => 'bookings.create', 'uses' => 'Admin\BookingsController@create']);
    $this->post('bookings_mass_destroy', ['uses' => 'Admin\BookingsController@massDestroy', 'as' => 'bookings.mass_destroy']);
    $this->post('bookings_restore/{id}', ['uses' => 'Admin\BookingsController@restore', 'as' => 'bookings.restore']);
    $this->delete('bookings_perma_del/{id}', ['uses' => 'Admin\BookingsController@perma_del', 'as' => 'bookings.perma_del']);
    //$this->resource('/find_rooms', 'Admin\FindRoomsController', ['except' => 'create']);
    $this->get('/find_rooms', 'Admin\FindRoomsController@index')->name('find_rooms.index');
    $this->post('/find_rooms', 'Admin\FindRoomsController@index');
    $this->resource('/products', 'Admin\ProductsController', ['except' => 'productsales.create']);
    $this->get('products/create/', ['as' => 'products.create', 'uses' => 'Admin\ProductsController@create', 'as' => 'products.create']);
    $this->post('products_mass_destroy', ['uses' => 'Admin\ProductsController@massDestroy', 'as' => 'products.mass_destroy']);
    $this->get('printInvoice', 'Admin\BookingsController@printInvoice');
    $this->get('checkout', ['uses' => 'Admin\SalesController@checkoutPage', 'as' => 'products.checkout']);
    $this->get('sellDrinks', ['uses' => 'Admin\ProductsController@sellDrinks', 'as' => 'products.drinks_sale']);
    $this->get('printDrinkInvoice', 'Admin\SalesController@generateInvoice')->name('generate.invoice');
    $this->get('saleshistory', ['uses' => 'Admin\SalesController@showAllSales', 'as' => 'products.saleshistory']);
    $this->resource('onlinebooking', 'Admin\OnlineBookingController', ['except' => 'bookings.create']);
});
