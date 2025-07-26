<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\JadwalMonev;
use App\Models\JenisDokumen;
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
use Illuminate\Support\Facades\DB;

class DesaController extends Controller
{
    public function dashboard()
    {
        $kecamatanCount = Kecamatan::where('status', 'active')->count();
        $desaCount = Desa::where('status', 'active')->count();
        $jenisDokumenCount = JenisDokumen::where('status', 'active')->count();

        // Ambil data pendukung
        $kategori = KategoriLaporan::where('status', 'active')->get();
        $desa = Desa::where('status', 'active')->get();
        $jenisDokumen = JenisDokumen::where('status', 'active')->get();

        // Hitung jumlah desa yang belum lengkap upload dokumen (status 'terima')
        $jumlahDesaBelumLengkap = DB::table('desa')
            ->leftJoin('dokumen_jawaban', function ($join) {
                $join->on('desa.id', '=', 'dokumen_jawaban.desa_id')
                    ->where('dokumen_jawaban.status', 'terima');
            })
            ->leftJoin('jenis_dokumen', function ($join) {
                $join->on('dokumen_jawaban.jenis_dokumen_id', '=', 'jenis_dokumen.id')
                    ->where('jenis_dokumen.status', 'active');
            })
            ->select('desa.id', DB::raw('COUNT(dokumen_jawaban.id) as total_terima'))
            ->groupBy('desa.id')
            ->havingRaw('COUNT(dokumen_jawaban.id) < ?', [$jenisDokumenCount])
            ->get()
            ->count();
        $desaLengkap = DB::table('desa')
            ->leftJoin('dokumen_jawaban', function ($join) {
                $join->on('desa.id', '=', 'dokumen_jawaban.desa_id')
                    ->where('dokumen_jawaban.status', 'terima');
            })
            ->leftJoin('jenis_dokumen', function ($join) {
                $join->on('dokumen_jawaban.jenis_dokumen_id', '=', 'jenis_dokumen.id')
                    ->where('jenis_dokumen.status', 'active');
            })
            ->select('desa.id', 'desa.nama_desa', DB::raw('COUNT(DISTINCT dokumen_jawaban.jenis_dokumen_id) as total_terima'))
            ->groupBy('desa.id', 'desa.nama_desa')
            ->havingRaw('COUNT(DISTINCT dokumen_jawaban.jenis_dokumen_id) = ?', [$jenisDokumenCount])
            ->get()
            ->count();

        $rankingDesa = DB::table('desa')
            ->leftJoin('dokumen_jawaban', function ($join) {
                $join->on('desa.id', '=', 'dokumen_jawaban.desa_id')
                    ->where('dokumen_jawaban.status', 'terima');
            })
            ->leftJoin('jenis_dokumen', function ($join) {
                $join->on('dokumen_jawaban.jenis_dokumen_id', '=', 'jenis_dokumen.id')
                    ->where('jenis_dokumen.status', 'active');
            })
            ->select(
                'desa.id',
                'desa.nama_desa',
                DB::raw('COUNT(DISTINCT dokumen_jawaban.jenis_dokumen_id) as total_laporan_terima')
            )
            ->groupBy('desa.id', 'desa.nama_desa')
            ->orderByDesc('total_laporan_terima')
            ->get()
            ->map(function ($item) use ($jenisDokumenCount) {
                $item->jumlah_seharusnya = $jenisDokumenCount;
                $item->persentase = $jenisDokumenCount > 0 ? round(($item->total_laporan_terima / $jenisDokumenCount) * 100, 1) : 0;
                $item->status = $item->total_laporan_terima >= $jenisDokumenCount ? 'Lengkap' : 'Belum Lengkap';
                return $item;
            });

        return view('desa.dashboard', compact(
            'kecamatanCount',
            'desaCount',
            'kategori',
            'desa',
            'jenisDokumen',
            'jenisDokumenCount',
            'jumlahDesaBelumLengkap',
            'desaLengkap',
            'rankingDesa'
        ));
    }

    public function strukturDesa()
    {
        $desaAuth = Desa::where('user_id', Auth::user()->id)->first();
        $struktur = StrukturDesa::where('status', 'active')->where('id_desa', $desaAuth->id)->get();
        $desa = Desa::where('status', 'active')->where('id', $desaAuth->id)->get();
        $jenisJabatan = JenisJabatan::where('status', 'active')->get();
        $kecamatan = Kecamatan::where('status', 'active')->where('id', $desaAuth->kecamatan_id)->get();
        return view('desa.struktur-desa', compact('struktur', 'desa', 'jenisJabatan', 'kecamatan','desaAuth'));
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
    public function monitoringDetail($waktu_monev_id, $kecamatan_id)
    {
        $waktu_monev = WaktuMonev::find($waktu_monev_id);
        $kecamatanAuth = Kecamatan::find($kecamatan_id);
        $strukturDesa = StrukturDesa::where('status', 'active')->get();
        $desa = Desa::where('status', 'active')->where('kecamatan_id', $kecamatanAuth->id)->get();

        $jadwalMonev = JadwalMonev::where('id_waktu', $waktu_monev_id)->where('id_kecamatan', $kecamatan_id)->get();
        return view('desa.monitoring-detail', compact('waktu_monev', 'kecamatanAuth', 'strukturDesa', 'desa', 'jadwalMonev'));
    }
}
