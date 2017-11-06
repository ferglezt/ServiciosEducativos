<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carrera;
use App\Estudiante;
use Illuminate\Database\QueryException;
use DB;

class EstudianteController extends Controller
{
    public function verEstudiantes(Request $request) {
      return view('verEstudiantes');
    }

    public function altaEstudiante(Request $request) {
    	return view('altaEstudiante', [
    		'carreras' => Carrera::all()
    	]);
    }

   	public function attemptAltaEstudiante(Request $request) {
   		$boleta = $request->input('boleta');
   		$nombre = $request->input('nombre');
   		$carrera = $request->input('carrera');
   		$curp = $request->input('curp');
   		$email = $request->input('email');
   		$telefono = $request->input('telefono');
   		$genero = $request->input('genero');

   		if(!isset($boleta) || $boleta == '' || !preg_match('/[0-9]/', $boleta)) {
   			return view('altaEstudiante', [
    			'carreras' => Carrera::all(),
    			'error' => 'El campo boleta debe ser numérico'
    		]);
   		}

   		if(Estudiante::where('boleta', '=', $boleta)->first()) {
   			return view('altaEstudiante', [
    			'carreras' => Carrera::all(),
    			'error' => 'Este estudiante ya ha sido dado de alta previamente'
    		]);
   		}

   		$estudiante = new Estudiante;
   		$estudiante->boleta = $boleta;
   		$estudiante->nombre = $nombre;
   		$estudiante->carrera_id = $carrera;
   		$estudiante->curp = $curp;
   		$estudiante->email = $email;
   		$estudiante->telefono = $telefono;
   		$estudiante->genero = $genero;

   		$estudiante->save();

   		return view('altaEstudiante', [
			'carreras' => Carrera::all(),
			'successMessage' => 'Estudiante '.$nombre.' dado de alta exitosamente'
		]);

   	}

   	public function findBoleta(Request $request, $boleta) {
   		Estudiante::where('boleta', '=', $boleta)->firstOrFail();
   	}

    public function searchEstudiante(Request $request) {
      $data = [];
      $q = $request->input('q');

      if(isset($q) && $q != '') {
        $data = DB::table('estudiantes')
        ->join('carreras', 'estudiantes.carrera_id', '=', 'carreras.id')
        ->where('estudiantes.boleta', 'like', '%'.$q.'%')
        ->orWhere('estudiantes.nombre', 'like', '%'.$q.'%')
        ->limit(200)
        ->select('estudiantes.*', 'carreras.nombre as carrera')
        ->get();
      }

      return response()->json($data, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
