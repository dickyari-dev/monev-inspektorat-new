<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\JenisDokumen;
use App\Models\JenisJabatan;
use App\Models\JenisLaporan;
use App\Models\KategoriLaporan;
use App\Models\Kecamatan;
use App\Models\StrukturDesa;
use App\Models\StrukturInspektorat;
use App\Models\StrukturKecamatan;
use App\Models\WaktuMonev;
use Illuminate\Http\Request;

class InspektoratController extends Controller
{
    public function dashboard()
    {
        return view('inspektorat.dashboard');
    }

    public function strukturInspektorat()
    {
        $struktur = StrukturInspektorat::where('status', 'active')->get();
        $jenisJabatan = JenisJabatan::where('status', 'active')->get();
        return view('inspektorat.struktur-inspektorat', compact('struktur', 'jenisJabatan'));
    }

    public function strukturKecamatan()
    {
        $struktur = StrukturKecamatan::where('status', 'active')->get();
        $kecamatan = Kecamatan::where('status', 'active')->get();
        $jenisJabatan = JenisJabatan::where('status', 'active')->get();
        return view('inspektorat.struktur-kecamatan', compact('struktur', 'kecamatan', 'jenisJabatan'));
    }
    public function strukturDesa()
    {
        $struktur = StrukturDesa::where('status', 'active')->get();
        $desa = Desa::where('status', 'active')->get();
        $jenisJabatan = JenisJabatan::where('status', 'active')->get();
        $kecamatan = Kecamatan::where('status', 'active')->get();
        return view('inspektorat.struktur-desa', compact('struktur', 'desa', 'jenisJabatan', 'kecamatan'));
    }
    public function dataPetugas()
    {
        $struktur = [];
        return view('inspektorat.data-petugas', compact('struktur'));
    }



    public function settingLaporan()
    {
        $kategori = KategoriLaporan::where('status', 'active')->get();
        $jenis = JenisLaporan::where('status', 'active')->get();
        $jenisDokumen = JenisDokumen::where('status', 'active')->get();
        return view('inspektorat.setting-laporan', compact('kategori', 'jenis', 'jenisDokumen'));
    }


    public function settingWilayah()
    {
        $kecamatan = Kecamatan::where('status', 'active')->get();
        $desa = Desa::where('status', 'active')->get();
        return view('inspektorat.setting-wilayah', compact('kecamatan', 'desa'));
    }


    public function waktuMonev()
    {
        $kategori = KategoriLaporan::where('status', 'active')->get();
        $waktu_monev = WaktuMonev::where('status', 'active')->get();
        return view('inspektorat.waktu-monev', compact('kategori', 'waktu_monev'));
    }

    public function jadwalMonev()
    {
        $kecamatan = Kecamatan::where('status', 'active')->get();
        $waktu_monev = WaktuMonev::where('status', 'active')->get();

        return view('inspektorat.jadwal-monev', compact('kecamatan', 'waktu_monev'));
    }
}
