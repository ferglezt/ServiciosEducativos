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

Route::get('/', function() {
	return view('adminDashboard'); 
})->middleware('custom.session')->name('home');

Route::get('/login', function() {
	return view('login');
})->name('login');

Route::get('/cerrarSesion', 'LoginController@cerrarSesion');
Route::post('/attemptLogin', 'LoginController@attemptLogin');
Route::get('/test', 'TestController@test')->name('test');
