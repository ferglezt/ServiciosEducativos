<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ServicioSocialController extends Controller
{
    public function altaServicioSocial(Request $request) {
    	return view('altaServicioSocial');
    }
}
