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
    if ($user = auth()->user()) {
        switch ($user->role_id) {
            case 4:
                return Redirect::route('shipments.index');
            case 8:
                return Redirect::route('users');
        }
    }
    return Redirect::route('login');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request')->middleware('is_admin');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email')->middleware('is_admin');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset')->middleware('is_admin');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->middleware('is_admin');

//Auth::routes();

//Resource Routes
Route::resource('display', 'ReportController');
Route::resource('branch', 'BranchController');
Route::resource('role', 'UserRoleController');
Route::resource('bike_model', 'BikeModelController');
Route::resource('shipments', 'ShipmentController')->middleware('is_warehouse_operator');
Route::resource('returned_items', 'ReturnedItemController');
Route::resource('warehouse_inventory', 'WarehouseInventoryController');
Route::resource('warehouses', 'WarehouseController');
Route::resource('model', 'BikeModelController');
Route::resource('retail', 'RetailReportController');

//Retail Route
Route::get('retailreport', 'RetailReportController@retail_report');
Route::get('addretailreport', 'RetailReportController@add_retail_report');
Route::get('edit/{id}', 'RetailReportController@edit_retail_report');
Route::post('edit', 'RetailReportController@UpdateReport');

//Admin Route
Route::get('users', 'AdminController@user')->name('users')->middleware('is_admin');
Route::get('reports', 'AdminController@report')->name('reports')->middleware('is_admin');
Route::get('reports/detail/{id}', 'AdminController@detail_report')->name('reports')->middleware('is_admin');

//Admin Model Route
Route::get('models', 'AdminController@model')->name('models')->middleware('is_admin');
Route::get('models/add', 'AdminController@showInsertModel')->name('models')->middleware('is_admin');
Route::post('models/add', 'AdminController@InsertModel')->name('models.add')->middleware('is_admin');
Route::get('models/edit/{id}', 'AdminController@showUpdateModelForm')->name('models')->middleware('is_admin');
Route::post('models/edit', 'AdminController@UpdateModel')->name('models.update')->middleware('is_admin');

//Shipments
Route::get('shipments/report/{id}', 'ShipmentController@showAsReport')->middleware('is_warehouse_operator');
Route::post('shipments/finish', 'ShipmentController@finish')->middleware('is_warehouse_operator');
Route::post('shipments/delete/{id}', 'ShipmentController@destroy')->middleware('is_warehouse_operator');

//Datatable data
Route::get('datatable/shipment', 'DataTableController@getShipment')->name('get_shipment');

//Route::get('inv/yolo', 'WarehouseInventoryController@yolo');

//Ajax endpoints
Route::get('key', 'AuthKeyController@generate')->name('generateKey');
Route::post('key/update/{id}', 'AuthKeyController@update')->name('updateKey');
Route::get('bike_model/get/{code}', 'BikeModelController@get');
Route::get('inventory/validate/{bike_model_id}/{vin}', 'WarehouseInventoryController@validateInventoryData');
