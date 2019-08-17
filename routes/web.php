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

Route::get('/', function () {
    return redirect(route('ordersExpired'));
});

/*weather*/
Route::get('/weather', 'WeatherController@index')->name('weather');

/*orders*/
Route::get('/orders/{order}/edit', 'OrdersController@edit')->name('ordersEdit');
Route::patch('/orders/{order}', 'OrdersController@update')->name('ordersUpdate');
Route::get('/orders/expired', 'OrdersController@expired')->name('ordersExpired');
Route::get('/orders/current', 'OrdersController@current')->name('ordersCurrent');
Route::get('/orders/new', 'OrdersController@new')->name('ordersNew');
Route::get('/orders/done', 'OrdersController@done')->name('ordersDone');
Route::get('/orders', 'OrdersController@index')->name('orders');

/*products*/
Route::get('/products', 'ProductsController@index')->name('products');
Route::post('/products/{product}', 'ProductsController@update')->name('productsUpdate');
