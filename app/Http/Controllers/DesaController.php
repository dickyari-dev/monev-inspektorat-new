<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesaController extends Controller
{
    public function dashboard()
    {
        return view('desa.dashboard');
    }
}
