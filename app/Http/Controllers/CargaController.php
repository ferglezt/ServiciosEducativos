<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carga;


class CargaController extends Controller
{
    public function findCarga(Request $request, $carrera_id) {
    	$data = Carga::where('carrera_id', '=', $carrera_id)->firstOrFail();
    	return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
