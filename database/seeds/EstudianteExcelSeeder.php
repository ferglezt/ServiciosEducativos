<?php

use Illuminate\Database\Seeder;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use App\Estudiante;
use Illuminate\Database\QueryException;

class EstudianteExcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reader = ReaderFactory::create(Type::XLSX); 

		$reader->open('C:\Users\Becas_Adriana\Downloads\est.xlsx');

		foreach ($reader->getSheetIterator() as $sheet) {
			if($sheet->getName() != 'FORMATO ORIGINAL') {
				continue;
			}

			$i = 0;

		    foreach ($sheet->getRowIterator() as $row) {
		    	if($i++ == 0) {
		    		continue;
		    	}

		        $nombre = $row[6];
		        $curp = $row[4];
		        $boleta = $row[3];
		        $genero = $row[5];
		        $carrera = $row[7];
		        $email = $row[25];
		        $telefono = $row[26];
		        $oriundo = $row[24];

		        $carrera = str_replace(' ', '', $carrera);
		        $boleta = str_replace(' ', '', $boleta);
		        $curp = str_replace(' ', '', $curp);

		        if(strcasecmp($carrera, 'IN') == 0) {
		        	$carrera = 1;
		        } else if(strcasecmp($carrera, 'CI') == 0) {
		        	$carrera = 2;
		        } else if(strcasecmp($carrera, 'II') == 0) {
		        	$carrera = 3;
		        } else if(strcasecmp($carrera, 'AI') == 0) {
		        	$carrera = 4;
		        } else if(strcasecmp($carrera, 'IT') == 0) {
		        	$carrera = 5;
		        } else {
		        	$this->command->info('Inconsistencia carrera: '.$carrera.' '.$i);
		        	$carrera = 6;
		        }

		        $genero = str_replace(' ', '', $genero);

		        if(strcasecmp($genero, 'MASCULINO') == 0 || strcasecmp($genero, 'M') == 0 || strcasecmp($genero, 'H') == 0) {
		        	$genero = 'M';
		        } else if(strcasecmp($genero, 'FEMENINO') == 0 || strcasecmp($genero, 'F') == 0) {
		        	$genero = 'F';
		        } else {
		        	$this->command->info('Inconsistencia de genero: '.$genero.' Fila: '.$i.' Boleta: '.$boleta.' Nombre: '.$nombre);
		        	continue;
		        }

		        $estudiante = new Estudiante;

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
		   			$this->command->info($e->getMessage());
		   		}

		    }
		}

		$reader->close();
    }
}
