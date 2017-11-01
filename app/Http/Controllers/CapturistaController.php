<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class CapturistaController extends Controller
{
	const ADMIN = 1;

    public function altaCapturista(Request $request) {
    	//Esta función está reservada únicamente para el administrador
    	if(self::isAdmin($request)) {
    		return view('altaCapturista');
    	}
    	return redirect()->route('home');
    }

    public function attemptAltaCapturista(Request $request) {
    	//Esta función está reservada únicamente para el administrador
    	if(self::isAdmin($request)) {
    		$nombre = $request->input('nombre');
    		$email = $request->input('email');
    		$password = $request->input('password');

    		if(!isset($nombre) || $nombre == '') {
    			return view('altaCapturista', ['error' => 'El campo nombre es obligatorio']);
	    	}

    		if(!isset($email) || $email == '') {
    			return view('altaCapturista', ['error' => 'El campo email es obligatorio']);
	    	}

	    	if(!isset($password) || $password == '') {
	    		return view('altaCapturista', ['error' => 'El campo password es obligatorio']);
	    	}

	    	$usuario = new Usuario;
	    	$usuario->nombre = $nombre;
	    	$usuario->email = $email;
	    	$usuario->password = Hash::make($password);
	    	$usuario->rol_id = 2;

	    	try {
	    		$usuario->save();
	    	} catch(QueryException $e) {
	    		return view('altaCapturista', ['error' => 'Este usuario ya existe']);
	    	}

	    	return view('altaCapturista', ['successMessage' => 'Se ha dado de alta al capturista '.$nombre]);
    	}
    	return redirect()->route('home');
    }

    private function isAdmin(Request $request) {
    	return $request->session()->get('rol_id', 0) == self::ADMIN;
    }
}
