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
    Route::get('/logout', 'Admin\AuthController@logout')->name('logout');
});

Route::group(['middleware' => ['auth.admin', 'cors'], 'prefix' => 'admin'], function() {
    Route::get('/', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('/dashboard/orderStatus/{orderStatus}', 'Admin\DashboardController@orderStatus')->name('dashboard.orderStatus');
    Route::get('/dashboard/printInvoice/{id}', 'Admin\DashboardController@printInvoice')->name('dashboard.printInvoice');
    Route::post('/dashboard/getShippingsView', 'Admin\DashboardController@getShippingsView')->name('dashboard.getShippingsView');
    Route::post('/dashboard/getOrdersView', 'Admin\DashboardController@getOrdersView')->name('dashboard.getOrdersView');
    Route::post('/dashboard/transfer', 'Admin\DashboardController@transfer')->name('dashboard.transfer');

    // Route::get('/report', 'Admin\ReportController@index')->name('report');
    Route::get('/report/sales', 'Admin\ReportController@sales')->name('report.sales');
    Route::get('/report/collection', 'Admin\ReportController@collection')->name('report.collection');
    Route::get('/report/stock', 'Admin\ReportController@stock')->name('report.stock');
    Route::get('/report/salescashier', 'Admin\ReportController@salescashier')->name('report.salescashier');
    Route::post('/report/get_member', 'Admin\ReportController@get_member')->name('report.get_member');
    Route::get('/report/collectioncashier', 'Admin\ReportController@collectioncashier')->name('report.collectioncashier');
    Route::get('/report/product', 'Admin\ReportController@product')->name('report.product');
    // Route::post('/dashboard/searchPeriod', 'Admin\DashboardController@searchPeriod')->name('dashboard.searchPeriod');

    Route::get('/finance', 'Admin\FinanceController@index')->name('finance');
    Route::post('/finance/getTranfersView', 'Admin\FinanceController@getTranfersView')->name('finance.getTranfersView');
    Route::post('/finance/getimage', 'Admin\FinanceController@getimage')->name('finance.getimage');
    Route::post('/finance/getOrdersView', 'Admin\FinanceController@getOrdersView')->name('finance.getOrdersView');
    Route::post('/finance/transfer', 'Admin\FinanceController@transfer')->name('finance.transfer');
    Route::post('/finance/getOrderView', 'Admin\FinanceController@getOrderView')->name('finance.getOrderView');

    Route::get('/menu', 'Admin\MenuController@index')->name('menu');
    Route::get('/menu/{id}', 'Admin\MenuController@show')->name('menu.show');
    Route::post('/menu', 'Admin\MenuController@store')->name('menu.store');
    Route::post('/menu/update', 'Admin\MenuController@update')->name('menu.update');
    Route::delete('/menu/{id}', 'Admin\MenuController@destroy')->name('menu.destroy');

    Route::get('/user', 'Admin\UserController@index')->name('user');
    Route::get('/user/create', 'Admin\UserController@create')->name('user.create');
    Route::get('/user/{id}/edit', 'Admin\UserController@edit')->name('user.edit');
    Route::get('/user/{id}', 'Admin\UserController@show')->name('user.show');
    Route::post('/user/reset_password', 'Admin\UserController@reset_password');
    Route::post('/user', 'Admin\UserController@store')->name('user.store');
    Route::post('/user/destroy', 'Admin\UserController@destroy')->name('user.destroy');
    Route::post('/user/{id}', 'Admin\UserController@update')->name('user.update');
    // Route::delete('/user/{id}', 'Admin\UserController@destroy')->name('user.destroy');

    Route::get('/role', 'Admin\RoleController@index')->name('role');
    Route::get('/role/{id}', 'Admin\RoleController@show')->name('role.show');
    Route::post('/role', 'Admin\RoleController@store')->name('role.store');
    Route::post('/role/update', 'Admin\RoleController@update')->name('role.update');
    Route::post('/role/destroy', 'Admin\RoleController@destroy')->name('role.destroy');
    // Route::delete('/role/update', 'Admin\RoleController@update')->name('role.update');
    // Route::delete('/role/{id}', 'Admin\RoleController@destroy')->name('role.destroy');

    Route::get('/company', 'Admin\CompanyController@index')->name('company');
    Route::get('/company/{id}', 'Admin\CompanyController@show')->name('company.show');
    Route::post('/company', 'Admin\CompanyController@store')->name('company.store');
    Route::post('/company/update', 'Admin\CompanyController@update')->name('company.update');
    Route::post('/company/destroy', 'Admin\CompanyController@destroy')->name('company.destroy');
    Route::post('/company/get_amphures', 'Admin\CompanyController@get_amphures')->name('company.get_amphures');
    Route::post('/company/get_districts', 'Admin\CompanyController@get_districts')->name('company.get_districts');
    Route::post('/company/get_zipcode', 'Admin\CompanyController@get_zipcode')->name('company.get_zipcode');

    Route::get('/currency', 'Admin\CurrencyController@index')->name('currency');
    Route::post('/currency/update', 'Admin\CurrencyController@update')->name('currency.update');
    Route::post('/currency/getMoney', 'Admin\CurrencyController@getMoney')->name('currency.getMoney');

    Route::get('/ratepick', 'Admin\RatePickController@index')->name('ratepick');
    Route::post('/ratepick/update', 'Admin\RatePickController@update')->name('ratepick.update');
    Route::get('/ratepack', 'Admin\RatePackController@index')->name('ratepack');
    Route::post('/ratepack/update', 'Admin\RatePackController@update')->name('ratepack.update');
    Route::get('/ratedelivery', 'Admin\RateDeliveryController@index')->name('ratedelivery');
    Route::post('/ratedelivery/update', 'Admin\RateDeliveryController@update')->name('ratedelivery.update');

    Route::get('/box', 'Admin\BoxController@index')->name('box');
    Route::get('/box/{id}', 'Admin\BoxController@show')->name('box.show');
    Route::post('/box', 'Admin\BoxController@store')->name('box.store');
    Route::post('/box/update', 'Admin\BoxController@update')->name('box.update');
    Route::post('/box/destroy', 'Admin\BoxController@destroy')->name('box.destroy');

    Route::get('/product', 'Admin\ProductController@index')->name('product');
    Route::get('/product/create', 'Admin\ProductController@create')->name('product.create');
    Route::get('/product/{id}/edit', 'Admin\ProductController@edit')->name('product.edit');
    Route::post('/product', 'Admin\ProductController@store')->name('product.store');
    Route::post('/product/destroy', 'Admin\ProductController@destroy')->name('product.destroy');
    Route::post('/product/{id}', 'Admin\ProductController@update')->name('product.update');
    Route::get('/product/{id}/qrcode', 'Admin\ProductController@qrcode')->name('product.qrcode');
    Route::get('/product/{id}/history', 'Admin\ProductController@history')->name('product.history');
    // Route::delete('/product/{id}', 'Admin\ProductController@destroy')->name('product.destroy');

    Route::get('/warehouse', 'Admin\WarehouseController@index')->name('warehouse');
    Route::post('/warehouse', 'Admin\WarehouseController@store')->name('warehouse.store');
    Route::post('/warehouse/getqrcode', 'Admin\WarehouseController@getqrcode')->name('warehouse.getqrcode');

    Route::get('/order', 'Admin\OrderController@index')->name('order');
    Route::get('/order/create', 'Admin\OrderController@create')->name('order.create');
    Route::get('/order/{id}/edit', 'Admin\OrderController@edit')->name('order.edit');
    Route::get('/order/{id}/manage', 'Admin\OrderController@manage')->name('order.manage');
    Route::get('/order/{id}/qrcode', 'Admin\OrderController@qrcode')->name('order.qrcode');
    Route::get('/order/{id}/coverSheet', 'Admin\OrderController@coverSheet')->name('order.coverSheet');
    Route::get('/order/{id}/coverSheetGroup', 'Admin\OrderController@coverSheetGroup')->name('order.coverSheetGroup');
    Route::get('/order/documentPrint', 'Admin\OrderController@documentPrint')->name('order.documentPrint');
    Route::get('/order/documentPrintCoverSheet', 'Admin\OrderController@documentPrintCoverSheet')->name('order.documentPrintCoverSheet');

    Route::get('/order/PDFPrintCoverSheet', 'Admin\OrderController@PDFPrintCoverSheet')->name('order.PDFPrintCoverSheet');
    Route::get('/order/PDFPrintPickList', 'Admin\OrderController@PDFPrintPickList')->name('order.PDFPrintPickList');
    Route::get('/order/PDFPrintInvoice', 'Admin\OrderController@PDFPrintInvoice')->name('order.PDFPrintInvoice');

    Route::post('/order/cancel', 'Admin\OrderController@cancel')->name('order.cancel');
    Route::post('/order/adjustStatus', 'Admin\OrderController@adjustStatus')->name('order.adjustStatus');
    Route::post('/order/adjustStatusMultiOrder', 'Admin\OrderController@adjustStatusMultiOrder')->name('order.adjustStatusMultiOrder');
    Route::post('/order/adjustStatusToShipping', 'Admin\OrderController@adjustStatusToShipping')->name('order.adjustStatusToShipping');
    Route::post('/order/adjustStatusSuccessShipping', 'Admin\OrderController@adjustStatusSuccessShipping')->name('order.adjustStatusSuccessShipping');

    Route::post('/order/getTranfersView', 'Admin\OrderController@getTranfersView')->name('order.getTranfersView');
    Route::post('/order/SaveTranfersView', 'Admin\OrderController@SaveTranfersView')->name('order.SaveTranfersView');

    Route::post('/order/openReceiveMoneyModal', 'Admin\OrderController@openReceiveMoneyModal')->name('order.openReceiveMoneyModal');
    Route::post('/order/getOrderToAdjustStatus', 'Admin\OrderController@getOrderToAdjustStatus')->name('order.getOrderToAdjustStatus');
    Route::post('/order/ReceiveMoneyOrder', 'Admin\OrderController@ReceiveMoneyOrder')->name('order.ReceiveMoneyOrder');
    Route::post('/order/openPackingModal', 'Admin\OrderController@openPackingModal')->name('order.openPackingModal');

    Route::post('/order/get_product', 'Admin\OrderController@get_product')->name('order.get_product');
    Route::post('/order/get_product_company', 'Admin\OrderController@get_product_company')->name('order.get_product_company');
    Route::post('/order/get_product2', 'Admin\OrderController@get_product2')->name('order.get_product2');
    Route::post('/order/get_box', 'Admin\OrderController@get_box')->name('order.get_box');
    Route::post('/order/get_customer', 'Admin\OrderController@get_customer')->name('order.get_customer');
    Route::post('/order', 'Admin\OrderController@store')->name('order.store');
    Route::post('/order/{id}', 'Admin\OrderController@update')->name('order.update');

    Route::get('/transfer/{order_id}', 'Admin\TransferController@index')->name('transfer');
    Route::get('/transfer/{order_id}/create', 'Admin\TransferController@create')->name('transfer.create');
    Route::get('/transfer/{transfer_id}/edit', 'Admin\TransferController@edit')->name('transfer.edit');
    Route::post('/transfer/getimage', 'Admin\TransferController@getimage')->name('transfer.getimage');

    Route::post('/transfer/approve', 'Admin\TransferController@approve')->name('transfer.approve');
    Route::post('/transfer/{transfer_id}/update', 'Admin\TransferController@update')->name('transfer.update');
    Route::post('/transfer/{order_id}', 'Admin\TransferController@store')->name('transfer.store');
    Route::post('/transfer', 'Admin\TransferController@store2')->name('transfer.store2');

    Route::get('/pack', 'Admin\PackController@index')->name('pack');
    Route::get('/pack/{order_id}', 'Admin\PackController@create')->name('pack.create');
    Route::post('/pack/getqrcode', 'Admin\PackController@getqrcode')->name('pack.getqrcode');
    Route::post('/pack/destroy', 'Admin\PackController@destroy')->name('pack.destroy');
    Route::delete('/pack/boxdestroy', 'Admin\PackController@destroy2')->name('pack.boxdestroy');
    // Route::delete('/pack/{id}', 'Admin\PackController@destroy')->name('pack.destroy');
    // Route::delete('/pack/box/{id}', 'Admin\PackController@destroy2')->name('pack.boxdestroy');

    Route::get('/track/{order_id}', 'Admin\TrackController@index')->name('track');
    Route::post('/track/{order_id}/update', 'Admin\TrackController@update')->name('track.update');

    Route::get('/invoice/{order_id}', 'Admin\InvoiceController@index')->name('invoice');

    Route::get('/shipping/{id}', 'Admin\ShippingController@index')->name('shipping');

    Route::get('/transport', 'Admin\TransportController@index')->name('transport');

    Route::get('/wallet', 'Admin\WalletController@index')->name('wallet');


    Route::post('/function/thb_to_lak', 'Admin\CenterFunctionController@thb_to_lak')->name('function.thb_to_lak');


    Route::get('/partner', 'Admin\PartnerController@index')->name('partner');

});
?>
