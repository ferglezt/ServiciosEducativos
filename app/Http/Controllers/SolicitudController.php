<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estudiante;
use App\Solicitud;
use App\Carrera;
use App\Periodo;
use App\IngresoMinimo;
use Illuminate\Database\QueryException;
use DB;

class SolicitudController extends Controller
{
    public function altaSolicitud(Request $request) {
        return view('altaSolicitud', [
            'carreras' => Carrera::all(),
            'periodos' => Periodo::all()
        ]);
    }

    public function attemptAltaSolicitud(Request $request) {
        $insertOrUpdateEstudiante = self::insertOrUpdateEstudiante($request);

        if(!$insertOrUpdateEstudiante->result) {
            return $insertOrUpdateEstudiante->view;
        }

        $solicitud = new Solicitud;

        $solicitud->estudiante_id = $insertOrUpdateEstudiante->estudiante_id;
        $solicitud->anio = $request->input('anio');
        $solicitud->periodo_id = $request->input('periodo_id');
        $solicitud->folio = $request->input('folio');
        $solicitud->etiqueta = $request->input('etiqueta');
        $solicitud->semestre = $request->input('semestre');
        $solicitud->promedio = $request->input('promedio');
        $solicitud->estatus_estudiante = $request->input('estatus_estudiante');
        $solicitud->carga = $request->input('carga');
        $solicitud->estatus_becario = $request->input('estatus_becario');
        $solicitud->beca_anterior = $request->input('beca_anterior');
        $solicitud->beca_solicitada = $request->input('beca_solicitada');
        $solicitud->folio_manutencion = $request->input('folio_manutencion');
        $solicitud->folio_transporte = $request->input('folio_transporte');
        $solicitud->comprobante_ingresos = $request->input('comprobante_ingresos');
        $solicitud->mapa = $request->input('mapa');
        $solicitud->fecha_recibido = $request->input('fecha_recibido');
        $solicitud->ingresos = $request->input('ingresos');
        $solicitud->dependientes = $request->input('dependientes');
        $solicitud->observaciones = $request->input('observaciones');
        $solicitud->usuario_id = $request->session()->get('usuario_id', null);

        if(IngresoMinimo::latest('id')->first()) {
            $solicitud->ingreso_minimo_id = IngresoMinimo::latest('id')->first()->id;
        }

        if(is_null($solicitud->folio) || !is_numeric($solicitud->folio)) {
            return view('altaSolicitud', [
                'carreras' => Carrera::all(),
                'periodos' => Periodo::all(),
                'error' => 'El folio debe ser un dato numérico'
            ]);
        }

        $alreadyExists = Solicitud::where([
            ['etiqueta', '=', $solicitud->etiqueta],
            ['periodo_id', '=', $solicitud->periodo_id]
        ])->first();

        if($alreadyExists) {
            return view('altaSolicitud', [
                'carreras' => Carrera::all(),
                'periodos' => Periodo::all(),
                'error' => 'Esta solicitud ya existe en la base de datos'
            ]);
        }

        try {
            $solicitud->save();
        } catch(QueryException $e) {
            return view('altaSolicitud', [
                'carreras' => Carrera::all(),
                'periodos' => Periodo::all(),
                'error' => $e->getMessage()
            ]);
        }

        return view('altaSolicitud', [
            'carreras' => Carrera::all(),
            'periodos' => Periodo::all(),
            'successMessage' => 'Solicitud dada de alta satisfactoriamente'
        ]);
    }

    private function insertOrUpdateEstudiante(Request $request) {
        $estudiante_id = $request->input('estudiante_id');
        $boleta = $request->input('boleta');
        $nombre = $request->input('nombre');
        $carrera = $request->input('carrera');
        $curp = $request->input('curp');
        $email = $request->input('email');
        $telefono = $request->input('telefono');
        $genero = $request->input('genero');
        $oriundo = $request->input('oriundo');

        if(!isset($boleta) || $boleta == '') {
            return (object)[
                'result' => false,
                'view' => view('altaSolicitud', [
                    'carreras' => Carrera::all(),
                    'periodos' => Periodo::all(),
                    'error' => 'El campo boleta es obligatorio'
                ])
            ];
        }

        $estudiante = Estudiante::where('id', '=', $estudiante_id)->first();

        if(!$estudiante) {
            $estudiante = new Estudiante;
        }

        $estudiante->boleta = $boleta;
        $estudiante->nombre = $nombre;
        $estudiante->carrera_id = $carrera;
        $estudiante->curp = $curp;
        $estudiante->email = $email;
        $estudiante->telefono = $telefono;
        $estudiante->genero = $genero;
        $estudiante->oriundo = $oriundo;

        try {
            $estudiante->save();
        } catch(QueryException $e) {
            return (object)[
                'result' => false,
                'view' => view('altaSolicitud', [
                    'carreras' => Carrera::all(),
                    'periodos' => Periodo::all(),
                    'error' => 'No fue posible dar de alta o actualizar al estudiante'
                ])
            ];
        }

        return (object)['result' => true, 'view' => null, 'estudiante_id' => $estudiante->id];
    }

	public function verSolicitudes(Request $request) {
		return view('verSolicitudes', [
            'periodos' => Periodo::all(),
            'columnas' => [
                (object)['data_column' => 0, 'nombre' => 'Estatus Solicitud'],
                (object)['data_column' => 1, 'nombre' => 'Folio'],
                (object)['data_column' => 2, 'nombre' => 'Etiqueta'],
                (object)['data_column' => 3, 'nombre' => 'Boleta'],
                (object)['data_column' => 4, 'nombre' => 'Curp'],
                (object)['data_column' => 5, 'nombre' => 'Género'],
                (object)['data_column' => 6, 'nombre' => 'Nombre'],
                (object)['data_column' => 7, 'nombre' => 'Carrera'],
                (object)['data_column' => 8, 'nombre' => 'Semestre'],
                (object)['data_column' => 9, 'nombre' => 'Promedio'],
                (object)['data_column' => 10, 'nombre' => 'Estatus Académico'],
                (object)['data_column' => 11, 'nombre' => 'Carga'],
                (object)['data_column' => 12, 'nombre' => 'Tipo Becario'],
                (object)['data_column' => 13, 'nombre' => 'Beca Anterior'],
                (object)['data_column' => 14, 'nombre' => 'Beca Solicitada'],
                (object)['data_column' => 15, 'nombre' => 'Folio Manutención'],
                (object)['data_column' => 16, 'nombre' => 'Folio Transporte'],
                (object)['data_column' => 17, 'nombre' => 'Mapa'],
                (object)['data_column' => 18, 'nombre' => 'Fecha Recibido'],
                (object)['data_column' => 19, 'nombre' => 'Comprobante Oficial'],
                (object)['data_column' => 20, 'nombre' => 'Ingresos'],
                (object)['data_column' => 21, 'nombre' => 'Dependientes'],
                (object)['data_column' => 22, 'nombre' => 'Oriundo'],
                (object)['data_column' => 23, 'nombre' => 'Email'],
                (object)['data_column' => 24, 'nombre' => 'Teléfono'],
                (object)['data_column' => 25, 'nombre' => 'Observaciones'],
            ]
        ]);
	}

    public function updateEstatusSolicitud(Request $request, $id) {
        $solicitud = Solicitud::where('id', '=', $id)->firstOrFail();
        $solicitud->estatus_solicitud = $request->input('estatus_solicitud');
        $solicitud->save();
        return response()->json($solicitud, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function searchSolicitud(Request $request) {
    	$data = [];
    	$periodo = $request->input('periodo');
    	$q = $request->input('q');

    	if(!is_null($q) && !is_null($periodo) && $q != '' && is_numeric($periodo)) {
    		$data = DB::table('solicitudes')
    		->join('estudiantes', 'estudiantes.id', '=', 'solicitudes.estudiante_id')
    		->join('carreras', 'carreras.id', '=', 'estudiantes.carrera_id')
            ->join('periodos', 'periodos.id', '=', 'solicitudes.periodo_id')
            ->leftJoin('ingreso_minimo', 'ingreso_minimo.id', '=', 'solicitudes.ingreso_minimo_id')
    		->where([
    			['solicitudes.periodo_id', '=', $periodo],
    			['estudiantes.boleta', 'like', '%'.$q.'%']
    		])
    		->orWhere([
    			['solicitudes.periodo_id', '=', $periodo],
    			['estudiantes.nombre', 'like', '%'.$q.'%']
    		])
    		->orWhere([
    			['solicitudes.periodo_id', '=', $periodo],
    			['solicitudes.folio', 'like', '%'.$q.'%']
    		])
    		//->limit(100)
    		->select(
                'solicitudes.id as id',
                'solicitudes.estatus_solicitud as estatus_solicitud',
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
    			'solicitudes.observaciones as observaciones',
                'ingreso_minimo.ingreso_minimo_por_persona as ingreso_minimo'
    		)
            ->get();
    	}

    	return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    } 
}
