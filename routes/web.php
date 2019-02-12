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
    if ($user = auth()->user()){
        if ($user->is_admin)
        {
            return redirect()->route('users');
        }
    }
    return redirect()->route('display.index');
});

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware('is_admin');
$this->post('register', 'Auth\RegisterController@register')->middleware('is_admin');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

//Auth::routes();

//Display Route
Route::resource('display','ReportController');
Route::resource('branch','BranchController');

//Admin Route
Route::get('users','AdminController@user')->name('users')->middleware('is_admin');
Route::get('reports','AdminController@report')->name('reports')->middleware('is_admin');
Route::get('models','AdminController@model')->name('models')->middleware('is_admin');


