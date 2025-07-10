<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function kecamatanStore(Request $request)
    {
        return view('kecamatan.dashboard');
    }
}
