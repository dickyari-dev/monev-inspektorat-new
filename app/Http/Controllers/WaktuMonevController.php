<?php

namespace App\Http\Controllers;

use App\Models\JenisLaporan;
use App\Models\KategoriLaporan;
use App\Models\Petugas;
use App\Models\WaktuMonev;
use Illuminate\Http\Request;

class WaktuMonevController extends Controller
{
    public function index()
    {
        $data = WaktuMonev::with(['petugas', 'kategori', 'jenis'])->get();
        return view('waktu_monev.index', compact('data'));
    }

    public function create()
    {
        $petugas = Petugas::all();
        $kategori = KategoriLaporan::all();
        $jenis = JenisLaporan::all();

        return view('waktu_monev.create', compact('petugas', 'kategori', 'jenis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_petugas'           => 'nullable|exists:petugas,id',
            'id_kategori_laporan'  => 'required|exists:kategori_laporan,id',
            'id_jenis_laporan'     => 'required|exists:jenis_laporan,id',
            'tahun'                => 'required|digits:4|integer',
            'bulan'                => 'required|integer|min:1|max:12',
            'tanggal_awal'         => 'required|date',
            'tanggal_akhir'        => 'required|date|after_or_equal:tanggal_awal',
        ]);

        WaktuMonev::create($validated);

        return redirect()->back()->with('success', 'Data waktu monev berhasil disimpan.');
    }

    public function edit($id)
    {
        $data = WaktuMonev::findOrFail($id);
        $petugas = Petugas::all();
        $kategori = KategoriLaporan::all();
        $jenis = JenisLaporan::all();

        return view('inspektorat.waktu-monev-edit', compact('data', 'petugas', 'kategori', 'jenis'));
    }

    public function update(Request $request, $id)
    {
        $data = WaktuMonev::findOrFail($id);

        $validated = $request->validate([
            'id_petugas'           => 'nullable|exists:petugas,id',
            'id_kategori_laporan'  => 'required|exists:kategori_laporan,id',
            'id_jenis_laporan'     => 'required|exists:jenis_laporan,id',
            'tahun'                => 'required|digits:4|integer',
            'bulan'                => 'required|integer|min:1|max:12',
            'tanggal_awal'         => 'required|date',
            'tanggal_akhir'        => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $data->update($validated);

        return redirect()->route('inspektorat.waktu-monev')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = WaktuMonev::findOrFail($id);
        $data->status = 'non-active';
        $data->save();

        return redirect()->route('waktu-monev.index')->with('success', 'Data berhasil dihapus.');
    }
}
