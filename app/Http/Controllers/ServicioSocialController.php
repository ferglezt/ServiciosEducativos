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

    public function editar(Request $request, $id) {
        $solicitud = ServicioSocial::findOrFail($id);

        return view('editarServicioSocial', [
            'carreras' => Carrera::all(),
            'solicitud' => $solicitud 
        ]);
    }

    public function attemptEdit(Request $request) {
        $solicitud = ServicioSocial::findOrFail($request->input('id'));
        $solicitud->registro = $request->input('registro');
        $solicitud->consecutivo = $request->input('consecutivo');
        $solicitud->boleta = $request->input('boleta');
        $solicitud->nombre = $request->input('nombre');
        $solicitud->carrera_id = $request->input('carrera');
        $solicitud->genero = $request->input('genero');
        $solicitud->prestatario = $request->input('prestatario');
        $solicitud->programa = $request->input('programa');
        $solicitud->profesor = $request->input('profesor');
        $solicitud->periodo = $request->input('periodo');
        $solicitud->tipo_ss = $request->input('tipo_ss');
        $solicitud->creditos = $request->input('creditos');
        $solicitud->horario = $request->input('horario');
        $solicitud->fecha_recepcion = $request->input('fecha_recepcion');
        $solicitud->observaciones = $request->input('observaciones');
        $solicitud->anio = $request->input('anio');

        if(is_null($solicitud->registro) || $solicitud->registro == '') {
            return view('editarServicioSocial', [
                'carreras' => Carrera::all(),
                'solicitud' => $solicitud,
                'error' => 'El campo registro es obligatorio'
            ]);
        }

        try {
            $solicitud->save();
        } catch(QueryException $e) {
            return view('editarServicioSocial', [
                'carreras' => Carrera::all(),
                'solicitud' => $solicitud,
                'error' => $e->getMessage()
            ]);
        }

        return view('editarServicioSocial', [
            'carreras' => Carrera::all(),
            'solicitud' => $solicitud,
            'successMessage' => 'Registro editado satisfactoriamente'
        ]);
    }

    public function attemptAltaSolicitudServicioSocial(Request $request) {
    	$solicitud = new ServicioSocial;
    	$solicitud->registro = $request->input('registro');

        if(is_null($solicitud->registro) || $solicitud->registro == '') {
            return view('altaServicioSocial', [
                'carreras' => Carrera::all(),
                'error' => 'El campo registro es obligatorio'
            ]);
        }

    	$solicitud->boleta = $request->input('boleta');
    	$solicitud->nombre = $request->input('nombre');
    	$solicitud->carrera_id = $request->input('carrera');
    	$solicitud->genero = $request->input('genero');
    	$solicitud->prestatario = $request->input('prestatario');
    	$solicitud->programa = $request->input('programa');
    	$solicitud->profesor = $request->input('profesor');
        $periodo_inicio = $request->input('periodo_inicio');
        $periodo_fin = $request->input('periodo_fin');
        $periodo = $periodo_inicio.'-'.$periodo_fin;
    	$solicitud->periodo = $periodo;
    	$solicitud->tipo_ss = $request->input('tipo_ss');
    	$solicitud->creditos = $request->input('creditos');
    	$solicitud->horario = $request->input('horario');
    	$solicitud->fecha_recepcion = $request->input('fecha_recepcion');
    	$solicitud->observaciones = $request->input('observaciones');
        $solicitud->anio = date('Y');

        $consecutivo = 1;

        $latest_solicitud = ServicioSocial::where('anio', '=', $solicitud->anio)->orderBy('anio_consecutivo', 'desc')->first();

        if($latest_solicitud && isset($latest_solicitud->anio_consecutivo)) {
            $consecutivo = $latest_solicitud->anio_consecutivo + 1;
        }

        $solicitud->anio_consecutivo = $consecutivo;
        $solicitud->consecutivo = 'IPN/O2M503/3S.9/'.sprintf('%04d', $consecutivo);
        $solicitud->usuario_id = $request->session()->get('usuario_id', null);

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
                'Editar',
                'Eliminar',
                'Año',
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
    			'Observaciones', 
                'Capturó'
    		]
    	]);
    }

    public function findByRegistro(Request $request, $registro) {
        $solicitud = ServicioSocial::where('registro', '=', $registro)->firstOrFail();
        return response()->json($solicitud, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function eliminar(Request $request, $id) {
        $solicitud = ServicioSocial::findOrFail($id);
        $solicitud->delete();     
    }

    public function buscar(Request $request) {
        $data = [];
        $q = $request->input('q');

        $data = DB::table('servicio_social')
        ->join('carreras', 'carreras.id', '=', 'servicio_social.carrera_id')
        ->leftJoin('usuarios', 'usuarios.id', '=', 'servicio_social.usuario_id')
        ->select(
            'servicio_social.id',
            'servicio_social.registro',
            'servicio_social.consecutivo',
            'servicio_social.boleta',
            'servicio_social.nombre',
            'carreras.nombre as carrera',
            'servicio_social.genero',
            'servicio_social.prestatario',
            'servicio_social.programa',
            'servicio_social.profesor',
            'servicio_social.tipo_ss',
            'servicio_social.periodo',
            'servicio_social.creditos',
            'servicio_social.horario',
            'servicio_social.fecha_recepcion',
            'servicio_social.observaciones',
            'usuarios.nombre as usuario',
            'servicio_social.anio'
        );
        
        if(!is_null($q) && $q != '') {
            $data = $data
            ->where('registro', 'like', '%'.$q.'%')
            ->orWhere('boleta', 'like', '%'.$q.'%')
            ->orWhere('servicio_social.nombre', 'like', '%'.$q.'%');
        }

        $data = $data->get();

        return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
