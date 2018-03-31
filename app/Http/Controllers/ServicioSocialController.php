<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carrera;
use DB;

class ServicioSocialController extends Controller
{
    public function altaServicioSocial(Request $request) {
    	return view('altaServicioSocial', [
    		'carreras' => Carrera::all()
    	]);
    }

    public function attemptAltaSolicitudServicioSocial(Request $request) {

    }
}
