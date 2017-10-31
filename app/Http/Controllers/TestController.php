<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol as Rol;

class TestController extends Controller
{
    public function test(Request $request) {
    	$roles = Rol::all();

    	return response()->json($roles, 200);
    }
}
