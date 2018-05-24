<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IngresoMinimo;

class IngresoMinimoController extends Controller
{
    public function getLatest(Request $request) {
    	$data = IngresoMinimo::latest('id')->firstOrFail();
    	return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function insert(Request $request) {
    	$ingresoMinimo = new IngresoMinimo;
    	$ingresoMinimo->ingreso_minimo_por_persona = $request->input('ingreso_minimo_por_persona')
    	$ingresoMinimo->dependientes_maximos = $request->input('dependientes_maximos')
    	$ingresoMinimo->save();
    }
}
