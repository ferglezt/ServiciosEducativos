<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class CapturistaController extends Controller
{
	const ADMIN = 1;

    public function verCapturistas(Request $request) {
        //Esta función está reservada únicamente para el administrador
        if(!self::isAdmin($request)) {
           return redirect()->route('home');    
        }

        return view('verCapturistas', [
            'capturistas' => Usuario::where('rol_id', '!=', self::ADMIN)->get()
        ]);
    }

    public function altaCapturista(Request $request) {
    	//Esta función está reservada únicamente para el administrador
    	if(!self::isAdmin($request)) {
    	   return redirect()->route('home');	
    	}
        
        return view('altaCapturista', [
            'roles' => self::getAllRolesExceptAdmin()
        ]);
    }

    public function attemptAltaCapturista(Request $request) {
    	//Esta función está reservada únicamente para el administrador
        if(!self::isAdmin($request)) {
            return redirect()->route('home');
        }
    	
		$nombre = $request->input('nombre');
		$email = $request->input('email');
		$password = $request->input('password');
        $rol = $request->input('rol');

		if(!isset($nombre) || $nombre == '') {
			return view('altaCapturista', [
                'roles' => self::getAllRolesExceptAdmin(),
                'error' => 'El campo nombre es obligatorio'
            ]);
    	}

		if(!isset($email) || $email == '') {
			return view('altaCapturista', [
                'roles' => self::getAllRolesExceptAdmin(),
                'error' => 'El campo email es obligatorio']
            );
    	}

    	if(!isset($password) || $password == '') {
    		return view('altaCapturista', [
                'roles' => self::getAllRolesExceptAdmin(),
                'error' => 'El campo password es obligatorio']
            );
    	}

        if(!isset($rol) || $rol == 0) {
            return view('altaCapturista', [
                'roles' => self::getAllRolesExceptAdmin(),
                'error' => 'Debe elegir un rol para el usuario']
            );
        }

    	$usuario = new Usuario;
    	$usuario->nombre = $nombre;
    	$usuario->email = $email;
    	$usuario->password = Hash::make($password);
    	$usuario->rol_id = $rol;

    	try {
    		$usuario->save();
    	} catch(QueryException $e) {
    		return view('altaCapturista', [
                'roles' => self::getAllRolesExceptAdmin(),
                'error' => 'Este usuario ya existe'
            ]);
    	}

    	return view('altaCapturista', [
            'roles' => self::getAllRolesExceptAdmin(),
            'successMessage' => 'Se ha dado de alta al capturista '.$nombre
        ]);
    	
    }

    private function isAdmin(Request $request) {
    	return $request->session()->get('rol_id', 0) == self::ADMIN;
    }

    private function getAllRolesExceptAdmin() {
        return Rol::where('id', '!=', self::ADMIN)->get();
    }
}
