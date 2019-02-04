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
    return redirect()->route('display.index');
});

Auth::routes();

$routes = ['except' => ['register']];
Route::resource('display','ReportController');
Route::resource('admin','AdminController');