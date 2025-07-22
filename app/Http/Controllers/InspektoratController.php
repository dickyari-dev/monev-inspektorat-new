<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\JenisDokumen;
use App\Models\JenisJabatan;
use App\Models\JenisLaporan;
use App\Models\KategoriLaporan;
use App\Models\Kecamatan;
use App\Models\Pertanyaan;
use App\Models\Petugas;
use App\Models\StrukturDesa;
use App\Models\StrukturInspektorat;
use App\Models\StrukturKecamatan;
use App\Models\WaktuMonev;
use Illuminate\Http\Request;

class InspektoratController extends Controller
{
    public function dashboard()
    {
        $kecamatanCount =Kecamatan::where('status', 'active')->count();
        $desaCount = Desa::where('status', 'active')->count();
        return view('inspektorat.dashboard', compact('kecamatanCount', 'desaCount'));
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
        $inspektorat = StrukturInspektorat::where('status', 'active')->get();
        $petugas = Petugas::where('status', 'active')->get();
        return view('inspektorat.data-petugas', compact('inspektorat', 'petugas'));
    }



    public function settingLaporan()
    {
        $kategori = KategoriLaporan::where('status', 'active')->get();
        $jenis = JenisLaporan::where('status', 'active')->get();
        $jenisDokumen = JenisDokumen::where('status', 'active')->get();
        $jd = JenisDokumen::where('status', 'active')->get();
        $pertanyaan = Pertanyaan::where('status', 'active')->get();
        return view('inspektorat.setting-laporan', compact('kategori', 'jenis', 'jenisDokumen', 'jd', 'pertanyaan'));
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
        $kecamatans = Kecamatan::where('status', 'active')->get();
        $waktuMonevs = WaktuMonev::where('status', 'active')->get();

        $jadwalMonev = [];

        foreach ($waktuMonevs as $waktu) {
            foreach ($kecamatans as $kec) {
                $jadwalMonev[] = [
                    'waktu_monev' => $waktu,
                    'kecamatan_id' => $kec->id,
                    'nama_kecamatan' => $kec->nama_kecamatan,
                ];
            }
        }
        return view('inspektorat.jadwal-monev', compact('jadwalMonev', 'kecamatans'));
    }

    public function detail($waktu, $kecamatan)
    {
        // Ambil data waktu monev berdasarkan ID
        $waktuMonev = WaktuMonev::with(['kategori', 'jenis'])
            ->where('id', $waktu)
            ->where('status', 'active')
            ->firstOrFail();

        // Ambil data kecamatan
        $kecamatanData = Kecamatan::where('id', $kecamatan)->where('status', 'active')->firstOrFail();

        // Kirim ke view
        return view('jadwal-monev.detail', [
            'waktuMonev' => $waktuMonev,
            'kecamatan' => $kecamatanData,
        ]);
    }

    public function monitoringDesa()
    {
        $kecamatan = Kecamatan::where('status', 'active')->get();
        $kategori = KategoriLaporan::where('status', 'active')->get();
        return view('inspektorat.monitoring-desa', compact('kecamatan', 'kategori'));
    }
}
