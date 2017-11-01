<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UsuarioController extends Controller
{
    public function cambioContrasena(Request $request) {
    	return view('cambioContrasena', [
    		'nombre' => $request->session()->get('nombre'),
    		'email' => $request->session()->get('email')
    	]);
    }

    public function attemptCambioContrasena(Request $request) {
    	$email = $request->session()->get('email');
    	$password_actual = $request->input('password_actual');
    	$password_nuevo = $request->input('password_nuevo');
    	$password_confirmar = $request->input('password_confirmar');

		if(!isset($email) || $email == '') {
			return view('cambioContrasena', [
				'email' => $request->session()->get('email'),
				'nombre' => $request->session()->get('nombre'),
				'error' => 'Debe especificarse un email'
			]);
    	}

    	if(!isset($password_actual) || $password_actual == '') {
    		return view('cambioContrasena', [
				'email' => $request->session()->get('email'),
				'nombre' => $request->session()->get('nombre'),
				'error' => 'Debe ingresar su password actual'
			]);
    	}

    	if(!isset($password_nuevo) || $password_nuevo == '') {
    		return view('cambioContrasena', [
				'email' => $request->session()->get('email'),
				'nombre' => $request->session()->get('nombre'),
				'error' => 'Debe ingresar un password nuevo'
			]);
    	}

    	if(!isset($password_confirmar) || $password_confirmar == '') {
    		return view('cambioContrasena', [
				'email' => $request->session()->get('email'),
				'nombre' => $request->session()->get('nombre'),
				'error' => 'Debe confirmar su password'
			]);
    	}

    	if(strcmp($password_nuevo, $password_confirmar) != 0) {
    		return view('cambioContrasena', [
				'email' => $request->session()->get('email'),
				'nombre' => $request->session()->get('nombre'),
				'error' => 'La confirmación de password no coincide'
			]);
    	}

    	$usuario;

    	try {
    		$usuario = Usuario::where('email', $email)->firstOrFail();
    	} catch(ModelNotFoundException $e) {
    		return view('cambioContrasena', [
				'email' => $request->session()->get('email'),
				'nombre' => $request->session()->get('nombre'),
				'error' => 'Usuario inexistente'
			]);
    	}

    	if(!Hash::check($password_actual, $usuario->password)) {
    		return view('cambioContrasena', [
				'email' => $request->session()->get('email'),
				'nombre' => $request->session()->get('nombre'),
				'error' => 'El password actual es erróneo'
			]);
    	}

    	$usuario->password = Hash::make($password_nuevo);

    	try {
    		$usuario->save();
    	} catch(QueryException $e) {
    		return view('cambioContrasena', [
				'email' => $request->session()->get('email'),
				'nombre' => $request->session()->get('nombre'),
				'error' => 'No fue posible cambiar la contraseña'
			]);
    	}

    	return view('cambioContrasena', [
			'email' => $request->session()->get('email'),
			'nombre' => $request->session()->get('nombre'),
			'successMessage' => 'Se ha cambiado exitosamente la contraseña'
		]);

    }
}
