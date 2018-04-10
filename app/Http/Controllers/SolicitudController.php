<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estudiante;
use App\Solicitud;
use App\Carrera;
use App\Beca;
use App\Periodo;
use App\IngresoMinimo;
use Illuminate\Database\QueryException;
use DB;

class SolicitudController extends Controller
{
    const ADMIN = 1;

    public function verEstadisticas(Request $request) {
        return view('verEstadisticas', [
            'periodos' => Periodo::all()->sortBy('anio')
        ]);
    }

    public function estadisticas(Request $request, $periodo) {
        $solicitadas = DB::table('solicitudes')
            ->select(DB::raw(
                'COUNT(*) as total,'.
                "SUM(CASE WHEN estatus_solicitud='PENDIENTE' THEN 1 ELSE 0 END) as pendientes,".
                "SUM(CASE WHEN estatus_solicitud='ACEPTADO' THEN 1 ELSE 0 END) as aceptados,".
                "SUM(CASE WHEN estatus_solicitud='LISTA DE ESPERA' THEN 1 ELSE 0 END) as lista_de_espera,".
                "SUM(CASE WHEN estatus_solicitud='RECHAZADO' THEN 1 ELSE 0 END) as rechazados"
            ))
            ->where('periodo_id', '=', $periodo)
            ->orderBy('total', 'desc')
            ->get();

        $porBeca = DB::table('solicitudes')
            ->select(DB::raw(
                'beca_solicitada, COUNT(*) as total,'.
                "SUM(CASE WHEN estatus_solicitud='PENDIENTE' THEN 1 ELSE 0 END) as pendientes,".
                "SUM(CASE WHEN estatus_solicitud='ACEPTADO' THEN 1 ELSE 0 END) as aceptados,".
                "SUM(CASE WHEN estatus_solicitud='LISTA DE ESPERA' THEN 1 ELSE 0 END) as lista_de_espera,".
                "SUM(CASE WHEN estatus_solicitud='RECHAZADO' THEN 1 ELSE 0 END) as rechazados"
            ))
            ->where('periodo_id', '=', $periodo)
            ->groupBy('beca_solicitada')
            ->orderBy('total', 'desc')
            ->get();

        $porGenero = DB::table('solicitudes')
            ->join('estudiantes', 'estudiantes.id', '=', 'solicitudes.estudiante_id')
            ->select(DB::raw(
                'COUNT(solicitudes.id) as total,'.
                "SUM(CASE WHEN genero='F' THEN 1 ELSE 0 END) as mujeres,".
                "SUM(CASE WHEN genero='M' THEN 1 ELSE 0 END) as hombres"
            ))
            ->where('periodo_id', '=', $periodo)
            ->orderBy('total', 'desc')
            ->get();

        $data = (object)[
            'solicitadas' => $solicitadas,
            'porBeca' => $porBeca,
            'porGenero' => $porGenero
        ];

        return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

    }

    public function altaSolicitud(Request $request) {
        return view('altaSolicitud', [
            'carreras' => Carrera::all(),
            'periodos' => Periodo::all()->sortBy('anio'),
            'ingreso_minimo' => IngresoMinimo::latest('id')->first(),
            'becas' => Beca::all()
        ]);
    }

    public function attemptAltaSolicitud(Request $request) {
        $insertOrUpdateEstudiante = self::insertOrUpdateEstudiante($request);

        if(!$insertOrUpdateEstudiante->result) {
            return view('altaSolicitud', [
                'error' => $insertOrUpdateEstudiante->error,
                'carreras' => Carrera::all(),
                'periodos' => Periodo::all()->sortBy('anio'),
                'ingreso_minimo' => IngresoMinimo::latest('id')->first(),
                'becas' => Beca::all()
            ]);
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
        $solicitud->folio_manutencion = $request->input('folio_manutencion');
        $solicitud->folio_transporte = $request->input('folio_transporte');
        $solicitud->comprobante_ingresos = $request->input('comprobante_ingresos');
        $solicitud->mapa = $request->input('mapa');
        $solicitud->fecha_recibido = $request->input('fecha_recibido');
        $solicitud->ingresos = $request->input('ingresos');
        $solicitud->dependientes = $request->input('dependientes');
        $solicitud->observaciones = $request->input('observaciones');
        $solicitud->numero_caja = $request->input('numero_caja');
        $solicitud->usuario_id = $request->session()->get('usuario_id', null);
        $solicitud->beca_id = $request->input('beca_id');
        $solicitud->beca_solicitada = Beca::find($solicitud->beca_id)->nombre;

        if(strcasecmp($solicitud->beca_solicitada, 'INSTITUCIONAL') == 0) {
            $solicitud->beca_solicitada = 'INSTITUCIONAL '.$request->input('tipo_institucional');
        }

        if(IngresoMinimo::latest('id')->first()) {
            $solicitud->ingreso_minimo_id = IngresoMinimo::latest('id')->first()->id;
        }

        if(is_null($solicitud->folio) || !is_numeric($solicitud->folio)) {
            return view('altaSolicitud', [
                'carreras' => Carrera::all(),
                'periodos' => Periodo::all()->sortBy('anio'),
                'ingreso_minimo' => IngresoMinimo::latest('id')->first(),
                'becas' => Beca::all(),
                'error' => 'El folio debe ser un dato numérico'
            ]);
        }

        $alreadyExists = Solicitud::where([
            ['estudiante_id', '=', $solicitud->estudiante_id],
            ['periodo_id', '=', $solicitud->periodo_id]
        ])->first();

        if($alreadyExists) {
            return view('altaSolicitud', [
                'carreras' => Carrera::all(),
                'periodos' => Periodo::all()->sortBy('anio'),
                'ingreso_minimo' => IngresoMinimo::latest('id')->first(),
                'becas' => Beca::all(),
                'error' => 'Esta solicitud ya existe en la base de datos'
            ]);
        }

        try {
            $solicitud->save();
        } catch(QueryException $e) {
            return view('altaSolicitud', [
                'carreras' => Carrera::all(),
                'periodos' => Periodo::all()->sortBy('anio'),
                'ingreso_minimo' => IngresoMinimo::latest('id')->first(),
                'becas' => Beca::all(),
                'error' => $e->getMessage()
            ]);
        }

        return view('altaSolicitud', [
            'carreras' => Carrera::all(),
            'periodos' => Periodo::all()->sortBy('anio'),
            'ingreso_minimo' => IngresoMinimo::latest('id')->first(),
            'becas' => Beca::all(),
            'successMessage' => 'Solicitud dada de alta satisfactoriamente'
        ]);
    }

    public function editarSolicitud(Request $request, $solicitud_id) {
        $solicitud = Solicitud::findOrFail($solicitud_id);
        $estudiante = Estudiante::findOrFail($solicitud->estudiante_id);

        return view('editarSolicitud', [
            'carreras' => Carrera::all(),
            'periodos' => Periodo::all()->sortBy('anio'),
            'becas' => Beca::all(),
            'estudiante' => $estudiante,
            'solicitud' => $solicitud
        ]);
    }

    public function eliminarSolicitud(Request $request, $solicitud_id) {
        if($request->session()->get('rol_id', 0) != self::ADMIN) {
            abort(401);
        }

        $solicitud = Solicitud::findOrFail($solicitud_id);
        $solicitud->delete();

    }

    public function attemptEdicionSolicitud(Request $request) {
        $solicitud = Solicitud::findOrFail($request->input('solicitud_id'));
        $estudiante = Estudiante::findOrFail($request->input('estudiante_id'));

        $insertOrUpdateEstudiante = self::insertOrUpdateEstudiante($request);

        if(!$insertOrUpdateEstudiante->result) {
            return view('editarSolicitud', [
                'carreras' => Carrera::all(),
                'periodos' => Periodo::all()->sortBy('anio'),
                'becas' => Beca::all(),
                'estudiante' => $estudiante,
                'solicitud' => $solicitud,
                'error' => $insertOrUpdateEstudiante->error
            ]);
        }

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
        $solicitud->folio_manutencion = $request->input('folio_manutencion');
        $solicitud->folio_transporte = $request->input('folio_transporte');
        $solicitud->comprobante_ingresos = $request->input('comprobante_ingresos');
        $solicitud->mapa = $request->input('mapa');
        $solicitud->fecha_recibido = $request->input('fecha_recibido');
        $solicitud->ingresos = $request->input('ingresos');
        $solicitud->dependientes = $request->input('dependientes');
        $solicitud->observaciones = $request->input('observaciones');
        $solicitud->numero_caja = $request->input('numero_caja');
        $solicitud->usuario_id = $request->session()->get('usuario_id', null);

        $solicitud->beca_id = $request->input('beca_id');
        $solicitud->beca_solicitada = Beca::find($solicitud->beca_id)->nombre;

        if(is_null($solicitud->folio) || !is_numeric($solicitud->folio)) {
            return view('editarSolicitud', [
                'carreras' => Carrera::all(),
                'periodos' => Periodo::all()->sortBy('anio'),
                'becas' => Beca::all(),
                'estudiante' => $estudiante,
                'solicitud' => $solicitud,
                'error' => 'El folio debe ser un dato numérico'
            ]);
        }

        try {
            $solicitud->save();
        } catch(QueryException $e) {
            return view('editarSolicitud', [
                'carreras' => Carrera::all(),
                'periodos' => Periodo::all()->sortBy('anio'),
                'becas' => Beca::all(),
                'estudiante' => $estudiante,
                'solicitud' => $solicitud,
                'error' => $e->getMessage()
            ]);
        }

        return view('editarSolicitud', [
            'carreras' => Carrera::all(),
            'periodos' => Periodo::all()->sortBy('anio'),
            'becas' => Beca::all(),
            'estudiante' => $estudiante,
            'solicitud' => $solicitud,
            'successMessage' => 'Solicitud editada satisfactoriamente'
        ]);

    }

    public function findSolicitud(Request $request) {
        $solicitud = Solicitud::where([['periodo_id', '=', $request->input('periodo')],
                            ['etiqueta', '=', $request->input('etiqueta')]])->firstOrFail();
        $estudiante = Estudiante::findOrFail($solicitud->estudiante_id);

        $data = (object)[
            'solicitud' => $solicitud,
            'estudiante' => $estudiante
        ];

        return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
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
                'error' => 'El campo boleta es obligatorio'
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
                'error' => 'No fue posible dar de alta o actualizar al estudiante'
            ];
        }

        return (object)['result' => true, 'error' => null, 'estudiante_id' => $estudiante->id];
    }

	public function verSolicitudes(Request $request) {
		return view('verSolicitudes', [
            'periodos' => Periodo::all()->sortBy('anio'),
            'columnas' => [
                'Estatus Solicitud',
                'Editar',
                'Eliminar',
                'Folio',
                'Etiqueta',
                'Boleta',
                'Curp',
                'Género',
                'Nombre',
                'Carrera',
                'Semestre',
                'Promedio',
                'Estatus Académico',
                'Carga',
                'Tipo Becario',
                'Beca Anterior',
                'Beca Solicitada',
                'Folio Manutención',
                'Folio Transporte',
                'Mapa',
                'Fecha Recibido',
                'Comprobante Oficial',
                'Ingresos',
                'Dependientes',
                'Ingreso Mínimo',
                'Ingresos/Dependientes',
                'Oriundo',
                'Email',
                'Teléfono',
                'Observaciones',
                'Número de caja',
                'Capturó'
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

    	if(!is_null($periodo) && is_numeric($periodo)) {
            $data = DB::table('solicitudes')
            ->join('estudiantes', 'estudiantes.id', '=', 'solicitudes.estudiante_id')
            ->join('carreras', 'carreras.id', '=', 'estudiantes.carrera_id')
            ->join('periodos', 'periodos.id', '=', 'solicitudes.periodo_id')
            ->leftJoin('ingreso_minimo', 'ingreso_minimo.id', '=', 'solicitudes.ingreso_minimo_id')
            ->leftJoin('usuarios', 'usuarios.id', '=', 'solicitudes.usuario_id')
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
                'usuarios.nombre as usuario',
                'solicitudes.numero_caja as numero_caja',
                'ingreso_minimo.ingreso_minimo_por_persona as ingreso_minimo'
            );

            if(!is_null($q) && $q != '') {
                $data = $data->where([
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
                ]);
            } else {
                $data = $data->where('solicitudes.periodo_id', '=', $periodo);
            }
    		
            $data = $data->get();
    	}

    	return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    } 
}
