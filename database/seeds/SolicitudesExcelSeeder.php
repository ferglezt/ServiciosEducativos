<?php

use Illuminate\Database\Seeder;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use App\Estudiante;
use App\Solicitud;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SolicitudesExcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reader = ReaderFactory::create(Type::XLSX); 

		$reader->open('C:\Users\dell\desktop\est.xlsx');

		foreach ($reader->getSheetIterator() as $sheet) {
			if($sheet->getName() != 'FORMATO ORIGINAL') {
				continue;
			}

			$i = 0;

		    foreach ($sheet->getRowIterator() as $row) {
		    	if($i++ == 0) {
		    		continue;
		    	}

		        $curp = $row[4];
		        $boleta = $row[3];
		        $estudiante = null;

		        $curp = str_replace(' ', '', $curp);
		        $boleta = str_replace(' ', '', $boleta);

		       	try {
		       		$estudiante = Estudiante::where([
		       			['boleta', '=', $boleta],
		       			['curp', '=', $curp]
		       		])->firstOrFail();
		       	} catch(ModelNotFoundException $e) {
		       		$this->command->info('Estudiante no encontrado '.$i.' Boleta: '.$boleta.' Curp: '.$curp);
		       		continue;
		       	}

		       	$solicitud = new Solicitud;
		       	$solicitud->anio = $row[0];
		       	$solicitud->folio = $row[1];
		       	$solicitud->etiqueta = $row[2];
		       	$solicitud->estudiante_id = $estudiante->id;
		       	$solicitud->semestre = is_numeric($row[8]) ? $row[8] : null;
		       	$solicitud->promedio = is_numeric($row[9]) ? $row[9] : null;
		       	$solicitud->estatus_estudiante = $row[10];
		       	$solicitud->carga = $row[11] = is_numeric($row[11]) ? $row[11] : null;
		       	$solicitud->estatus_becario = $row[12];
		       	$solicitud->beca_anterior = $row[13];
		       	$solicitud->beca_solicitada = $row[14];
		       	$solicitud->folio_manutencion = $row[15];
		       	$solicitud->folio_transporte = $row[16];
		       	$solicitud->mapa = $row[17];
		       	$solicitud->fecha_recibido = $row[18];
		       	$solicitud->comprobante_ingresos = $row[19];
		       	$solicitud->ingresos = $row[20] = is_numeric($row[20]) ? $row[20] : null;
		       	$solicitud->dependientes = is_numeric($row[21]) ? $row[21] : null;
		       	$solicitud->observaciones = $row[27];

		       	try {
		       		$solicitud->save();
		       	} catch(QueryException $e) {
		       		$this->command->info('Estudiante '.$i.' Boleta: '.$boleta);
		       		$this->command->info('---------------');
		       		$this->command->info($e->getMessage());
		       		$this->command->info('---------------');
		       	}

		    }
		}

		$reader->close();
    }
}
