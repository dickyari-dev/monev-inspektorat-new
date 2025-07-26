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
use App\Models\StrukturKecamatan;
use App\Models\WaktuMonev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KecamatanController extends Controller
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

        return view('kecamatan.dashboard', compact(
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

    public function strukturKecamatan()
    {
        $auth = Auth::user()->id;
        $kecamatanAuth = Kecamatan::where('user_id', $auth)->first();
        $struktur = StrukturKecamatan::where('status', 'active')->where('id_kecamatan', $kecamatanAuth->id)->get();
        $kecamatan = Kecamatan::where('status', 'active')->where('user_id', $auth)->first();
        $kecamatanFilter = Kecamatan::where('status', 'active')->where('user_id', $auth)->first();
        $jenisJabatan = JenisJabatan::where('status', 'active')->get();
        return view('kecamatan.struktur-kecamatan', compact('struktur', 'kecamatan', 'jenisJabatan', 'kecamatanFilter'));
    }

    public function strukturDesa()
    {
        $auth = Auth::user()->id;
        $kecamatanAuth = Kecamatan::where('user_id', $auth)->first();
        $struktur = StrukturDesa::where('status', 'active')->where('id_kecamatan', $kecamatanAuth->id)->get();
        $desa = Desa::where('status', 'active')->where('kecamatan_id', $kecamatanAuth->id)->get();
        $jenisJabatan = JenisJabatan::where('status', 'active')->get();
        $kecamatan = Kecamatan::where('status', 'active')->where('id', $kecamatanAuth->id)->get();
        return view('kecamatan.struktur-desa', compact('struktur', 'desa', 'jenisJabatan', 'kecamatan'));
    }

    public function dataPetugas()
    {
        $inspektorat = StrukturInspektorat::where('status', 'active')->get();
        $petugas = Petugas::where('status', 'active')->get();
        return view('kecamatan.data-petugas', compact('inspektorat', 'petugas'));
    }

    public function waktuMonev()
    {
        $kategori = KategoriLaporan::where('status', 'active')->get();
        $waktu_monev = WaktuMonev::where('status', 'active')->get();

        $userId = Auth::user()->id;

        // Ambil 1 kecamatan milik user (asumsi 1 user = 1 kecamatan)
        $kecamatan = Kecamatan::where('user_id', $userId)->first();
        $kecamatanAuth = $kecamatan;
        if (!$kecamatan) {
            return redirect()->back()->with('error', 'Kecamatan tidak ditemukan.');
        }

        $desa = Desa::where('status', 'active')
            ->where('kecamatan_id', $kecamatan->id) // asumsi ada kolom ini
            ->get();

        return view('kecamatan.waktu-monev', compact('kategori', 'waktu_monev', 'desa', 'kecamatanAuth'));
    }

    public function monitoringDetail($waktu_monev_id, $kecamatan_id)
    {
        $waktu_monev = WaktuMonev::find($waktu_monev_id);
        $kecamatanAuth = Kecamatan::find($kecamatan_id);
        $strukturDesa = StrukturDesa::where('status', 'active')->get();
        $desa = Desa::where('status', 'active')->where('kecamatan_id', $kecamatanAuth->id)->get();

        $jadwalMonev = JadwalMonev::where('id_waktu', $waktu_monev_id)->where('id_kecamatan', $kecamatan_id)->get();
        return view('kecamatan.monitoring-detail', compact('waktu_monev', 'kecamatanAuth', 'strukturDesa', 'desa', 'jadwalMonev'));
    }

    public function monitoringDesa()
    {
        $Auth = Auth::user();
        $kecamatanAuth = Kecamatan::where('user_id', $Auth->id)->first();
        $desa = Desa::where('status', 'active')->where('kecamatan_id', $kecamatanAuth->id)->get();
        $kecamatan = Kecamatan::where('status', 'active')->get();
        $kategori = KategoriLaporan::where('status', 'active')->get();
        $jenis = JenisLaporan::where('status', 'active')->get();
        return view('kecamatan.monitoring-desa', compact('desa', 'kecamatan', 'kecamatanAuth', 'kategori', 'jenis'));
    }
}
