<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\JenisJabatan;
use App\Models\Kecamatan;
use App\Models\StrukturDesa;
use App\Models\StrukturInspektorat;
use App\Models\StrukturKecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('kecamatan.dashboard');
    }
      public function strukturKecamatan()
    {
        $struktur = StrukturKecamatan::where('status', 'active')->get();
        $kecamatan = Kecamatan::where('status', 'active')->get();
        $jenisJabatan = JenisJabatan::where('status', 'active')->get();
        return view('kecamatan.struktur-kecamatan', compact('struktur', 'kecamatan', 'jenisJabatan'));
    }

    public function strukturDesa()
    {
        $struktur = StrukturDesa::where('status', 'active')->get();
        $desa = Desa::where('status', 'active')->get();
        $jenisJabatan = JenisJabatan::where('status', 'active')->get();
        $kecamatan = Kecamatan::where('status', 'active')->get();
        return view('kecamatan.struktur-desa', compact('struktur', 'desa', 'jenisJabatan', 'kecamatan'));
    }
    
}
