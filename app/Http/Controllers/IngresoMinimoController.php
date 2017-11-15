<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IngresoMinimo;

class IngresoMinimoController extends Controller
{
    public function getLatest(Request $request) {
    	$data = IngresoMinimo::latest('ingreso_minimo_por_persona')->firstOrFail();
    	return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
