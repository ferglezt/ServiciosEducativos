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

    public function cambiarContrasenaCapturista(Request $request, $id) {
        //Esta función está reservada únicamente para el administrador
        if(!self::isAdmin($request)) {
           abort(401);
        }

        $password = $request->input('password');

        if(!isset($password) || $password == '') {
            abort(500);
        }

        $usuario = Usuario::findOrFail($id);

        //No se permite cambiarle la contraseña a otro admin
        if($usuario->rol_id == self::ADMIN) {
            abort(401);
        }

        $usuario->password = Hash::make($password);

        $usuario->save();

    }

    public function editarCapturista(Request $request, $id) {
        //Esta función está reservada únicamente para el administrador
        if(!self::isAdmin($request)) {
           abort(401); 
        }

        $usuario = Usuario::findOrFail($id);

        $usuario->nombre = $request->input('nombre');
        $usuario->email = $request->input('email');
        $usuario->rol_id = $request->input('rol_id');

        $usuario->save();
    }

    public function borrarCapturista(Request $request, $id) {
        //Esta función está reservada únicamente para el administrador
        if(!self::isAdmin($request)) {
           abort(401);
        }

        $usuario = Usuario::findOrFail($id);

        $usuario->delete();

    }

    public function verCapturistas(Request $request) {
        //Esta función está reservada únicamente para el administrador
        if(!self::isAdmin($request)) {
           abort(401);  
        }

        return view('verCapturistas', [
            'capturistas' => Usuario::all(),
            'roles' => Rol::all()
        ]);
    }

    public function altaCapturista(Request $request) {
    	//Esta función está reservada únicamente para el administrador
    	if(!self::isAdmin($request)) {
    	   return redirect()->route('home');	
    	}
        
        return view('altaCapturista', [
            'roles' => Rol::all()
        ]);
    }

    public function attemptAltaCapturista(Request $request) {
    	//Esta función está reservada únicamente para el administrador
        if(!self::isAdmin($request)) {
            abort(401);
        }
    	
		$nombre = $request->input('nombre');
		$email = $request->input('email');
		$password = $request->input('password');
        $rol = $request->input('rol');

		if(!isset($nombre) || $nombre == '') {
			return view('altaCapturista', [
                'roles' => Rol::all(),
                'error' => 'El campo nombre es obligatorio'
            ]);
    	}

		if(!isset($email) || $email == '') {
			return view('altaCapturista', [
                'roles' => Rol::all(),
                'error' => 'El campo email es obligatorio']
            );
    	}

    	if(!isset($password) || $password == '') {
    		return view('altaCapturista', [
                'roles' => Rol::all(),
                'error' => 'El campo password es obligatorio']
            );
    	}

        if(!isset($rol) || $rol == 0) {
            return view('altaCapturista', [
                'roles' => Rol::all(),
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
                'roles' => Rol::all(),
                'error' => 'Este usuario ya existe'
            ]);
    	}

    	return view('altaCapturista', [
            'roles' => Rol::all(),
            'successMessage' => 'Se ha dado de alta al capturista '.$nombre
        ]);
    	
    }

    private function isAdmin(Request $request) {
    	return $request->session()->get('rol_id', 0) == self::ADMIN;
    }
}
