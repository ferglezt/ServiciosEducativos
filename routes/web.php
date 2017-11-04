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

Route::group(['middleware' => ['custom.session']], function() {
	Route::get('/', 'HomeController@home')
		->name('home');

	Route::get('/altaCapturista', 'CapturistaController@altaCapturista')
		->name('altaCapturista');
		
	Route::post('/attemptAltaCapturista', 'CapturistaController@attemptAltaCapturista')
		->name('/attemptAltaCapturista');

	Route::get('/cambioContrasena', 'UsuarioController@cambioContrasena')
		->name('cambioContrasena');

	Route::post('/attemptCambioContrasena', 'UsuarioController@attemptCambioContrasena')
		->name('attemptCambioContrasena');

	Route::get('/verCapturistas', 'CapturistaController@verCapturistas')
		->name('verCapturistas');

	Route::get('/borrarCapturista/{id}', 'CapturistaController@borrarCapturista')
		->name('borrarCapturista');
});

Route::get('/login', function() {
	return view('login');
})->name('login');

Route::get('/cerrarSesion', 'LoginController@cerrarSesion')->name('cerrarSesion');
Route::post('/attemptLogin', 'LoginController@attemptLogin');
Route::get('/test', 'TestController@test')->name('test');
