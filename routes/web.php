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

	Route::post('/editarCapturista/{id}', 'CapturistaController@editarCapturista')
		->name('editarCapturista');

	Route::post('/cambiarContrasenaCapturista/{id}', 'CapturistaController@cambiarContrasenaCapturista')
		->name('cambiarContrasenaCapturista');

	Route::get('/altaEstudiante', 'EstudianteController@altaEstudiante')
		->name('altaEstudiante');

	Route::post('/attemptAltaEstudiante', 'EstudianteController@attemptAltaEstudiante')
		->name('attemptAltaEstudiante');

	Route::get('/findBoleta/{boleta}', 'EstudianteController@findBoleta')
		->name('findBoleta');

	Route::get('/verEstudiantes', 'EstudianteController@verEstudiantes')
		->name('verEstudiantes');

	Route::get('/searchEstudiante', 'EstudianteController@searchEstudiante')
		->name('searchEstudiante');

	Route::get('/searchSolicitud', 'SolicitudController@searchSolicitud')
		->name('searchSolicitud');

	Route::get('/verSolicitudes', 'SolicitudController@verSolicitudes')
		->name('verSolicitudes');

	Route::get('/altaSolicitud', 'SolicitudController@altaSolicitud')
		->name('altaSolicitud');

	Route::post('/attemptAltaSolicitud', 'SolicitudController@attemptAltaSolicitud')
		->name('attemptAltaSolicitud');

	Route::post('/updateEstatusSolicitud/{id}', 'SolicitudController@updateEstatusSolicitud')
		->name('updateEstatusSolicitud');

	Route::get('/ingresoMinimo/latest', 'IngresoMinimoController@getLatest');

	Route::get('/findCarga/{carga_id}', 'CargaController@findCarga');

	Route::get('/findCarreraConCargas/{carrera_id}', 'CargaController@joinCarrerasCargas');

	Route::get('/editarSolicitud/{solicitud_id}', 'SolicitudController@editarSolicitud');

	Route::get('/aceptarTransporteInstitucional/{solicitud_id}/{value}', 'SolicitudController@aceptarTransporteInstitucional');

	Route::get('/aceptarTransporteManutencion/{solicitud_id}/{value}', 'SolicitudController@aceptarTransporteManutencion');

	Route::post('/attemptEdicionSolicitud', 'SolicitudController@attemptEdicionSolicitud');

	Route::get('/estadisticas/{periodo}', 'SolicitudController@estadisticas');

	Route::get('/verEstadisticas', 'SolicitudController@verEstadisticas')
		->name('verEstadisticas');

	Route::get('/findSolicitud', 'SolicitudController@findSolicitud');

	Route::post('/eliminarSolicitud/{solicitud_id}', 'SolicitudController@eliminarSolicitud');

	Route::get('/verBecas', 'BecaController@verBecas');

	Route::post('/eliminarBeca/{id}', 'BecaController@eliminarBeca');

	Route::post('/attemptAltaBeca', 'BecaController@attemptAltaBeca');

	Route::get('/excel/descargarBecas', 'ExcelController@descargarBecas');

	Route::get('/findLatestFolio/{periodo}', 'SolicitudController@findLatestFolio');

	Route::get('/altaServicioSocial', 'ServicioSocialController@altaServicioSocial');

	Route::post('/attemptAltaSolicitudServicioSocial', 'ServicioSocialController@attemptAltaSolicitudServicioSocial');

	Route::get('/verSolicitudesServicioSocial', 'ServicioSocialController@verSolicitudesServicioSocial');
});

Route::get('/login', function() {
	return view('login');
})->name('login');

Route::get('/cerrarSesion', 'LoginController@cerrarSesion')->name('cerrarSesion');
Route::post('/attemptLogin', 'LoginController@attemptLogin');
Route::get('/test', 'TestController@test')->name('test');
