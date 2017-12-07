<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Beca;
use DB;

class BecaController extends Controller
{
	const ADMIN = 1;

    public function verBecas(Request $request) {
    	if($request->session()->get('rol_id', 0) != self::ADMIN) {
            abort(401);
        }
        
    	return view('verBecas', [
    		'becas' => Beca::all()
    	]);
    }

    public function eliminarBeca(Request $request, $id) {
    	if($request->session()->get('rol_id', 0) != self::ADMIN) {
            abort(401);
        }

    	$beca = Beca::findOrFail($id);
    	$beca->delete();
    }

    public function attemptAltaBeca(Request $request) {
        if($request->session()->get('rol_id', 0) != self::ADMIN) {
            abort(401);
        }

        $beca = new Beca;
        $beca->nombre = $request->input('nombre');
        $beca->save();
    }
}
