<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carrera;
use App\ServicioSocial;
use Illuminate\Database\QueryException;
use DB;

class ServicioSocialController extends Controller
{
    public function altaServicioSocial(Request $request) {
    	return view('altaServicioSocial', [
    		'carreras' => Carrera::all()
    	]);
    }

    public function attemptAltaSolicitudServicioSocial(Request $request) {
    	$solicitud = new ServicioSocial;
    	$solicitud->registro = $request->input('registro');
    	$solicitud->consecutivo = $request->input('consecutivo');
    	$solicitud->boleta = $request->input('boleta');
    	$solicitud->nombre = $request->input('nombre');
    	$solicitud->carrera_id = $request->input('carrera');
    	$solicitud->genero = $request->input('genero');
    	$solicitud->prestatario = $request->input('prestatario');
    	$solicitud->programa = $request->input('programa');
    	$solicitud->profesor = $request->input('profesor');
        $periodo_inicio = $request->input('periodo_inicio');
        $periodo_fin = $request->input('periodo_fin');
        $periodo = $periodo_inicio.' - '.$periodo_fin;
    	$solicitud->periodo = $periodo;
    	$solicitud->tipo_ss = $request->input('tipo_ss');
    	$solicitud->creditos = $request->input('creditos');
    	$solicitud->horario = $request->input('horario');
    	$solicitud->fecha_recepcion = $request->input('fecha_recepcion');
    	$solicitud->observaciones = $request->input('observaciones');

    	try {
    		$solicitud->save();
    	} catch(QueryException $e) {
    		return view('altaServicioSocial', [
    			'carreras' => Carrera::all(),
    			'error' => $e->getMessage()
    		]);
    	}

    	return view('altaServicioSocial', [
    		'carreras' => Carrera::all(),
    		'successMessage' => 'Registro dado de alta satisfactoriamente'
    	]);
    }

    public function verSolicitudesServicioSocial(Request $request) {
    	return view('verSolicitudesServicioSocial', [
    		'columnas' => [
    			'Registro',
    			'Consecutivo',
    			'Boleta', 
    			'Nombre',
    			'Carrera',
    			'Género',
    			'Prestatario',
    			'Programa',
    			'Profesor',
    			'Periodo',
    			'Tipo Servicio Social',
    			'Créditos',
    			'Horario',
    			'Fecha Recepción',
    			'Observaciones'
    		]
    	]);
    }
}
