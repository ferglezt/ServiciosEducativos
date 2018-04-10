<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Common\Type;
use DB;

class ExcelController extends Controller
{
    const ADMIN = 1;

    public function descargarBecas(Request $request) {
    	if($request->session()->get('rol_id', 0) != self::ADMIN) {
            abort(401);
        }

        $data = [];
    	$periodo = $request->input('periodo');

    	if(!is_null($periodo) && is_numeric($periodo)) {
            $data = DB::table('solicitudes')
            ->join('estudiantes', 'estudiantes.id', '=', 'solicitudes.estudiante_id')
            ->join('carreras', 'carreras.id', '=', 'estudiantes.carrera_id')
            ->join('periodos', 'periodos.id', '=', 'solicitudes.periodo_id')
            ->leftJoin('usuarios', 'usuarios.id', '=', 'solicitudes.usuario_id')
            ->leftJoin('ingreso_minimo', 'ingreso_minimo.id', '=', 'solicitudes.ingreso_minimo_id')
            ->select(
                'solicitudes.anio as anio',
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
                'ingreso_minimo.ingreso_minimo_por_persona as ingreso_minimo',
                DB::raw('(ingresos / dependientes / ingreso_minimo_por_persona) as x'),
                'estudiantes.oriundo as oriundo',
                'estudiantes.email as email',
                'estudiantes.telefono as telefono',
                'solicitudes.observaciones as observaciones',
                'solicitudes.numero_caja as numero_caja',
                'usuarios.nombre as usuario_nombre'
            )
            ->where('solicitudes.periodo_id', '=', $periodo)
            ->orderBy('folio')
            ->get();
    	}

    	if(empty($data)) {
    		abort(404);
    	}

    	$data = json_decode(json_encode($data), true);
    	$data = self::array_values_recursive($data);

    	$tmpfname = tempnam(sys_get_temp_dir(), 'excel');
    	rename($tmpfname, $tmpfname .= '.xlsx');

    	$styleRows = (new StyleBuilder())
    	   ->setFontSize(8)
           ->setShouldWrapText()
           ->build();

        $styleHeader = (new StyleBuilder())
    	   ->setFontSize(10)
           ->setShouldWrapText()
           ->setFontColor(Color::WHITE)
           ->setBackgroundColor(Color::BLUE)
           ->build();

    	$writer = WriterFactory::create(Type::XLSX);
    	$writer->setDefaultRowStyle($styleRows);
    	$writer->openToFile($tmpfname);

    	$writer->addRowWithStyle([
    		'Año', 'Folio', 'Etiqueta', 'Boleta', 'Curp', 'Género', 'Nombre',
    		'Carrera', 'Semestre', 'Promedio', 'Estatus Académico', 'Carga',
    		'Estatus Becario', 'Beca Anterior', 'Beca Solicitada', 'Folio Manutención',
    		'Folio Transporte', 'Mapa', 'Fecha Recibido', 'Comprobante de Ingresos',
    		'Ingresos', 'Dependientes', 'Ingreso Mínimo', '', 'Oriundo', 'Email',
    		'Teléfono', 'Observaciones', 'Número de caja', 'Capturó'
    	], $styleHeader);

    	$writer->addRowsWithStyle($data, $styleRows);
    	$writer->close();

    	return response()->download($tmpfname);
    }

    private function array_values_recursive($arr) {
	    $arr2=[];

	    foreach ($arr as $key => $value) {
	        if(is_array($value)) {            
	            $arr2[] = self::array_values_recursive($value);
	        } else {
	            $arr2[] =  $value;
	        }
	    }

	    return $arr2;
	}
}
