<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol as Rol;

class TestController extends Controller
{
    public function test(Request $request) {
    	return view('test');
    }
}
