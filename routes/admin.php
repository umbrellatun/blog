<?php

/*
  |--------------------------------------------------------------------------
  | Admin Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->group(function () {
    Route::get('/login', 'Admin\AuthController@login');
    Route::post('/CheckLogin', 'Admin\AuthController@CheckLogin');
});

Route::group(['middleware' => ['auth.admin'], 'prefix' => 'admin'], function() {
    Route::get('/', 'Admin\DashboardController@index')->name('dashboard');

    Route::get('/menu', 'Admin\MenuController@index')->name('menu');
    Route::get('/menu/{id}', 'Admin\MenuController@show')->name('menu.show');
    Route::post('/menu', 'Admin\MenuController@store')->name('menu.store');
    Route::post('/menu/update', 'Admin\MenuController@update')->name('menu.update');
    Route::delete('/menu/update', 'Admin\MenuController@update')->name('menu.update');
    Route::delete('/menu/{id}', 'Admin\MenuController@destroy')->name('menu.destroy');

    Route::get('/user', 'Admin\UserController@index')->name('user');
    Route::get('/user/create', 'Admin\UserController@create')->name('user.create');
    Route::get('/user/{id}/edit', 'Admin\UserController@edit')->name('user.edit');
    Route::get('/user/{id}', 'Admin\UserController@show')->name('user.show');
    Route::post('/user/reset_password', 'Admin\UserController@reset_password');
    Route::post('/user', 'Admin\UserController@store')->name('user.store');
    Route::post('/user/{id}', 'Admin\UserController@update')->name('user.update');
    Route::delete('/user/{id}', 'Admin\UserController@destroy')->name('user.destroy');

    Route::get('/role', 'Admin\RoleController@index')->name('role');
    Route::get('/role/{id}', 'Admin\RoleController@show')->name('role.show');
    Route::post('/role', 'Admin\RoleController@store')->name('role.store');
    Route::post('/role/update', 'Admin\RoleController@update')->name('role.update');
    Route::delete('/role/update', 'Admin\RoleController@update')->name('role.update');
    Route::delete('/role/{id}', 'Admin\RoleController@destroy')->name('role.destroy');

    Route::get('/product', 'Admin\ProductController@index')->name('product');
    Route::get('/product/create', 'Admin\ProductController@create')->name('product.create');
    Route::get('/product/{id}/edit', 'Admin\ProductController@edit')->name('product.edit');
    Route::post('/product', 'Admin\ProductController@store')->name('product.store');
    Route::post('/product/{id}', 'Admin\ProductController@update')->name('product.update');
    Route::get('/product/{id}/qrcode', 'Admin\ProductController@qrcode')->name('product.qrcode');
    Route::delete('/product/{id}', 'Admin\ProductController@destroy')->name('product.destroy');

    Route::get('/warehouse', 'Admin\WarehouseController@index')->name('warehouse');
    Route::post('/warehouse', 'Admin\WarehouseController@store')->name('warehouse.store');
    Route::post('/warehouse/getqrcode', 'Admin\WarehouseController@getqrcode')->name('warehouse.getqrcode');

    Route::get('/order', 'Admin\OrderController@index')->name('order');
    Route::get('/order/create', 'Admin\OrderController@create')->name('order.create');
    Route::get('/order/{id}/edit', 'Admin\OrderController@edit')->name('order.edit');
    Route::get('/order/{id}/manage', 'Admin\OrderController@manage')->name('order.manage');
    Route::get('/order/{id}/qrcode', 'Admin\OrderController@qrcode')->name('order.qrcode');

    Route::post('/order/get_product', 'Admin\OrderController@get_product')->name('order.get_product');
    Route::post('/order/get_product2', 'Admin\OrderController@get_product2')->name('order.get_product2');
    Route::post('/order/get_box', 'Admin\OrderController@get_box')->name('order.get_box');
    Route::post('/order/get_customer', 'Admin\OrderController@get_customer')->name('order.get_customer');
    Route::post('/order', 'Admin\OrderController@store')->name('order.store');
    Route::post('/order/{id}', 'Admin\OrderController@update')->name('order.update');

    Route::get('/transfer/{order_id}', 'Admin\TransferController@index')->name('transfer');
    Route::get('/transfer/{order_id}/create', 'Admin\TransferController@create')->name('transfer.create');
    Route::post('/transfer/getimage', 'Admin\TransferController@getimage')->name('transfer.getimage');
    Route::post('/transfer/{order_id}', 'Admin\TransferController@store')->name('transfer.store');

    Route::post('/function/thb_to_lak', 'Admin\CenterFunctionController@thb_to_lak')->name('function.thb_to_lak');

});
?>
