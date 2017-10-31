<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

	public function cerrarSesion(Request $request) {
		$request->session()->flush();
		return redirect()->route('home');
	}

    public function attemptLogin(Request $request) {
    	$email = $request->input('email');
    	$password = $request->input('password');
    	
    	if(!isset($email) || $email == '') {
    		return view('login', ['error' => 'El campo email es obligatorio']);
    	}

    	if(!isset($password) || $password == '') {
    		return view('login', ['error' => 'El campo password es obligatorio']);
    	}

    	$usuario;
    	try {
    		$usuario = Usuario::where('email', $email)->firstOrFail();
    	} catch (ModelNotFoundException $e) {
    		return view('login', ['error' => 'Usuario no encontrado', 'email' => $email]);
    	}

    	if(!Hash::check($password, $usuario->password)) {
    		return view('login', ['error' => 'Contraseña errónea', 'email' => $email]);
    	}

    	$request->session()->put('email', $email);
    	$request->session()->put('rolId', $usuario->rolId);

    	return redirect()->route('home');
    }
}
