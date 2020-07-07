<?php

use Illuminate\Support\Facades\Route;

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


Route::middleware(['auth.shopify'])->group(function () {
    Route::get('/','WelcomeController@index')->name('home');
});
Route::middleware(['cors'])->group(function () {
});

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/user/logout', 'Auth\LoginController@userlogout')->name('user.logout');

// //admin auth routes
// Route::prefix('admin')->group(function(){
// 	Route::get('/', 'AdminController@index')->name('admin');
// 	Route::get('/login','Auth\admin\AdminLoginController@showloginform')->name('admin.login');
// 	Route::post('/login','Auth\admin\AdminLoginController@login')->name('admin.login.submit');
// 	Route::get('/logout', 'Auth\admin\AdminLoginController@adminlogout')->name('admin.logout');
	
// 	// admin password reset
// 	Route::post('/password/email', 'Auth\admin\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
//     Route::get('/password/reset', 'Auth\admin\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
//     Route::post('/password/reset', 'Auth\admin\AdminResetPasswordController@reset')->name('admin.password.update');
//     Route::get('/password/reset/{token}', 'Auth\admin\AdminResetPasswordController@showResetForm')->name('admin.password.reset');	
// });
