<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\DokumenJawaban;
use App\Models\JadwalMonev;
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
use Illuminate\Support\Facades\DB;

class InspektoratController extends Controller
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

        return view('inspektorat.dashboard', compact(
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
        $kecamatanFilter = Kecamatan::where('status', 'active')->get();
        $jenisJabatan = JenisJabatan::where('status', 'active')->get();
        return view('inspektorat.struktur-kecamatan', compact('struktur', 'kecamatan', 'jenisJabatan', 'kecamatanFilter'));
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

    public function monitoringDetail($waktu_monev_id, $kecamatan_id)
    {
        $waktu_monev = WaktuMonev::find($waktu_monev_id);
        $kecamatanAuth = Kecamatan::find($kecamatan_id);
        $strukturDesa = StrukturDesa::where('status', 'active')->get();
        $desa = Desa::where('status', 'active')->where('kecamatan_id', $kecamatanAuth->id)->get();

        $jadwalMonev = JadwalMonev::where('id_waktu', $waktu_monev_id)->where('id_kecamatan', $kecamatan_id)->get();
        return view('inspektorat.monitoring-detail', compact('waktu_monev', 'kecamatanAuth', 'strukturDesa', 'desa', 'jadwalMonev'));
    }
}
