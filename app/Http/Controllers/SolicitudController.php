<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estudiante;
use App\Solicitud;
use Illuminate\Database\QueryException;
use DB;

class SolicitudController extends Controller
{
	public function verSolicitudes(Request $request) {
		return view('verSolicitudes');
	}

    public function searchSolicitud(Request $request) {
    	$data = [];
    	$anio = $request->input('anio');
    	$q = $request->input('q');

    	if(!is_null($q) && !is_null($anio) && $q != '' && is_numeric($anio)) {
    		$data = DB::table('solicitudes')
    		->join('estudiantes', 'estudiantes.id', '=', 'solicitudes.estudiante_id')
    		->join('carreras', 'carreras.id', '=', 'estudiantes.carrera_id')
    		->where([
    			['solicitudes.anio', '=', $anio],
    			['estudiantes.boleta', 'like', '%'.$q.'%']
    		])
    		->orWhere([
    			['solicitudes.anio', '=', $anio],
    			['estudiantes.nombre', 'like', '%'.$q.'%']
    		])
    		->orWhere([
    			['solicitudes.anio', '=', $anio],
    			['solicitudes.folio', 'like', '%'.$q.'%']
    		])
    		//->limit(100)
    		->select(
    			'solicitudes.folio as folio',
    			'solicitudes.etiqueta as etiqueta',
    			'estudiantes.boleta as boleta',
    			'estudiantes.curp as curp',
    			'estudiantes.genero as genero',
    			'estudiantes.nombre as nombre',
    			'carreras.nombre as carrera',
    			'solicitudes.semestre as semestre',
    			'solicitudes.promedio as promedio',
    			'solicitudes.estatus_estudiante as estatus_estudiante',
    			'solicitudes.carga as carga',
    			'solicitudes.estatus_becario as estatus_becario',
    			'solicitudes.beca_anterior as beca_anterior',
    			'solicitudes.beca_solicitada as beca_solicitada',
    			'solicitudes.folio_manutencion as folio_manutencion',
    			'solicitudes.folio_transporte as folio_transporte',
    			'solicitudes.mapa as mapa',
    			'solicitudes.fecha_recibido as fecha_recibido',
    			'solicitudes.comprobante_ingresos as comprobante_ingresos',
    			'solicitudes.ingresos as ingresos',
    			'solicitudes.dependientes as dependientes',
    			'estudiantes.oriundo as oriundo',
    			'estudiantes.email as email',
    			'estudiantes.telefono as telefono',
    			'solicitudes.observaciones as observaciones'
    		)
    		->get();
    	}

    	return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    } 
}
