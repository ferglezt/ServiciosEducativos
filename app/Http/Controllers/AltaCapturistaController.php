<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AltaCapturistaController extends Controller
{
	const ADMIN = 1;

    public function altaCapturista(Request $request) {
    	//Esta función está reservada únicamente para el administrador
    	if($request->session()->get('rol_id', 0) == self::ADMIN) {
    		return view('altaCapturista');
    	}
    	return redirect()->route('home');
    }
}
