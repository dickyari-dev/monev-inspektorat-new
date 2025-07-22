<?php

namespace App\Http\Controllers;

use App\Models\JadwalMonev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalMonevController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'waktu_id'           => 'required|exists:waktu_monev,id',
            'tahun'              => 'required|digits:4|integer',
            'kecamatan_id'       => 'required|exists:kecamatan,id',
            'desa_id'            => 'required|exists:desa,id',
            'id_kategori_laporan' => 'required|exists:kategori_laporan,id',
            'id_jenis_laporan'   => 'required|exists:jenis_laporan,id',
            'bulan'              => 'required|integer|between:1,12',
            'tanggal_awal'       => 'required|date',
            'tanggal_akhir'      => 'required|date|after_or_equal:tanggal_awal',
        ]);

        // Cek Apakah Data Sudah Ada
        $jadwal = JadwalMonev::where('id_waktu', $validated['waktu_id'])
            ->where('id_kecamatan', $validated['kecamatan_id'])
            ->where('id_desa', $validated['desa_id'])
            ->first();

        if ($jadwal) {
            return redirect()->back()->with('error', 'Jadwal Monev sudah ada. Silahkan hapus dulu dan Buat Lagi');
        }

        // Simpan jadwal monev
        JadwalMonev::create([
            'tanggal_awal'   => $validated['tanggal_awal'],
            'tanggal_akhir'  => $validated['tanggal_akhir'],
            'id_waktu'       => $validated['waktu_id'],
            'id_kecamatan'   => $validated['kecamatan_id'],
            'id_desa'        => $validated['desa_id'],
        ]);

        return redirect()->back()->with('success', 'Jadwal Monev berhasil disimpan.');
    }

    public function destroy($id)
    {
        JadwalMonev::find($id)->delete();
        return redirect()->back()->with('success', 'Jadwal Monev berhasil dihapus.');
    }

    public function getJadwalByDesa($desa_id)
    {
        $jadwal = JadwalMonev::with(['waktu.kategori', 'waktu.jenis']) // <-- penting
            ->where('id_desa', $desa_id)
            ->orderBy('tanggal_awal')
            ->get();

        return response()->json($jadwal);
    }
}
