<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\JenisJabatan;
use App\Models\JenisLaporan;
use App\Models\KategoriLaporan;
use App\Models\Kecamatan;
use App\Models\Petugas;
use App\Models\StrukturDesa;
use App\Models\StrukturInspektorat;
use App\Models\WaktuMonev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesaController extends Controller
{
    public function dashboard()
    {
        $kecamatanCount = Kecamatan::where('status', 'active')->count();
        $desaCount = Desa::where('status', 'active')->count();
        return view('desa.dashboard', compact('kecamatanCount', 'desaCount'));
    }

    public function strukturDesa()
    {
        $desaAuth = Desa::where('user_id', Auth::user()->id)->first();
        $struktur = StrukturDesa::where('status', 'active')->where('id_desa', $desaAuth->id)->get();
        $desa = Desa::where('status', 'active')->where('id', $desaAuth->id)->get();
        $jenisJabatan = JenisJabatan::where('status', 'active')->get();
        $kecamatan = Kecamatan::where('status', 'active')->where('id', $desaAuth->kecamatan_id)->get();
        return view('desa.struktur-desa', compact('struktur', 'desa', 'jenisJabatan', 'kecamatan'));
    }

    public function dataPetugas()
    {
        $desaAuth = Desa::where('user_id', Auth::user()->id)->first();
        $inspektorat = StrukturInspektorat::where('status', 'active')->get();
        $petugas = Petugas::where('status', 'active')->where('struktur_desa_id', $desaAuth->id)->get();
        return view('desa.data-petugas', compact('inspektorat', 'petugas'));
    }

    public function getByKecamatan($kecamatanId)
    {
        $desa = Desa::where('kecamatan_id', $kecamatanId)->get();

        return response()->json([
            'status' => 'success',
            'data' => $desa
        ]);
    }

    public function waktuMonev()
    {
        $kategori = KategoriLaporan::where('status', 'active')->get();
        $waktu_monev = WaktuMonev::where('status', 'active')->get();

        $userId = Auth::user()->id;

        $desa = Desa::where('user_id', $userId)->first();
        // Ambil 1 kecamatan milik user (asumsi 1 user = 1 kecamatan)
        $kecamatan = Kecamatan::where('id', $desa->kecamatan_id)->first();

        return view('desa.waktu-monev', compact('kategori', 'waktu_monev', 'desa', 'kecamatan'));
    }

    public function monitoringDesa()
    {
        $Auth = Auth::user();
        $desaAuth = Desa::where('user_id', $Auth->id)->first();
        $kecamatanAuth = Kecamatan::where('id', $desaAuth->kecamatan_id)->first();
        $desa = Desa::where('status', 'active')->where('id', $desaAuth->id)->get();
        $kecamatan = Kecamatan::where('status', 'active')->where('id', $kecamatanAuth->id)->get();
        $kategori = KategoriLaporan::where('status', 'active')->get();
        $jenis = JenisLaporan::where('status', 'active')->get();
        return view('desa.monitoring-desa', compact('desa', 'kecamatan', 'kecamatanAuth', 'kategori', 'jenis'));
    }
}
