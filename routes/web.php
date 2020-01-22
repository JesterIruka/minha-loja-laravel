<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('index');
Route::get('/categories', 'HomeController@categories')->name('categories');
Route::get('/categories/{category}', 'HomeController@products')->name('products');
Route::get('/product/{id}', 'HomeController@single')->name('single');

Route::prefix('/ratings')->name('ratings.')->group(function () {
    Route::get('/', 'RatingController@index')->name('index');
    Route::get('/create', 'RatingController@create')->name('create');
    Route::post('/store', 'RatingController@store')->name('store');
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', 'CartController@index')->name('index');
    Route::post('add', 'CartController@add')->name('add');
    Route::delete('remove', 'CartController@remove')->name('remove');
    Route::delete('destroy', 'CartController@destroy')->name('destroy');
    Route::post('checkout', 'CartController@checkout')->name('checkout');

    Route::get('shipping_methods', 'CartController@shippingMethods');
});

Route::match(['get','post'], 'login', 'Admin\\AdminController@login')->name('login');
Route::post('logout', 'Admin\\AdminController@logout')->name('logout');

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth')->group(function () {
    Route::redirect('/', '/admin/dashboard')->name('dashboard');

    Route::get('dashboard', 'AdminController@index');
    Route::resource('categories', 'CategoryController');
    Route::resource('products', 'ProductController');
    Route::resource('users', 'UserController');

    Route::get('sales', 'SaleController@index')->name('sales.index');
    Route::delete('sales/{sale}/destroy', 'SaleController@destroy')->name('sales.destroy');
    Route::post('sales/dispatch', 'SaleController@despatch')->name('sales.dispatch');

    Route::post('variations/add', 'ProductController@addVar');
    Route::post('variations/{id}/destroy', 'ProductController@destroyVar');
    Route::put('variations/{id}', 'ProductController@alterVar');
    Route::post('products/image/{id}/destroy', 'ProductController@destroyImage');
});

Route::prefix('ipn')->namespace('IPN')->group(function () {
    Route::any('mercadopago', 'MercadoPago@rest');
    Route::any('pagseguro', 'PagSeguro@rest');
});
