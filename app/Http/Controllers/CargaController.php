<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carga;
use DB;

class CargaController extends Controller
{
    public function findCarga(Request $request, $carrera_id) {
    	$data = Carga::where('carrera_id', '=', $carrera_id)->firstOrFail();
    	return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function joinCarrerasCargas(Request $request, $carrera_id) {
    	$data = DB::table('cargas')
    	->join('carreras', 'carreras.id', '=', 'cargas.carrera_id')
    	->select(
    		'carreras.id as id',
    		'carreras.nombre as nombre',
    		'cargas.carga_minima',
    		'cargas.carga_media',
    		'cargas.carga_maxima'
    	)
    	->where('carreras.id', '=', $carrera_id)
    	->first();

    	if(is_null($data)) {
    		abort(404, 'Not Found');
    	}

    	return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
