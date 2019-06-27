<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    		$usuario = User::where('email', $email)->firstOrFail();
    	} catch (ModelNotFoundException $e) {
    		return view('login', ['error' => 'Usuario no encontrado', 'email' => $email]);
    	}

    	if(!Hash::check($password, $usuario->password)) {
    		return view('login', ['error' => 'Contraseña errónea', 'email' => $email]);
    	}

        $request->session()->put('usuario_id', $usuario->id);
    	$request->session()->put('email', $email);
    	$request->session()->put('rol_id', $usuario->rol_id);
    	$request->session()->put('nombre', $usuario->nombre);

    	return redirect()->route('home');
    }
}
