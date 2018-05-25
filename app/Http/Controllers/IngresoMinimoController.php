<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IngresoMinimo;

class IngresoMinimoController extends Controller
{
    const ADMIN = 1;

    public function nuevoIngresoMinimo(Request $request) {
        if($request->session()->get('rol_id', 0) != self::ADMIN) {
            abort(401);
        }
        return view('nuevoIngresoMinimo');
    }

    public function getLatest(Request $request) {
    	$data = IngresoMinimo::latest('id')->firstOrFail();
    	return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function insert(Request $request) {
        if($request->session()->get('rol_id', 0) != self::ADMIN) {
            abort(401);
        }
    	$ingresoMinimo = new IngresoMinimo;
    	$ingresoMinimo->ingreso_minimo_por_persona = $request->input('ingreso_minimo_por_persona');
    	$ingresoMinimo->dependientes_maximos = $request->input('dependientes_maximos');
    	$ingresoMinimo->save();
    }
}
