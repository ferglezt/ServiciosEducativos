<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
	const ADMIN = 1;

    public function home(Request $request) {
    	return view('dashboard');
    }
}
