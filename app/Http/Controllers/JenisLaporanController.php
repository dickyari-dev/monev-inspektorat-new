<?php

namespace App\Http\Controllers;

use App\Models\JenisLaporan;
use App\Models\KategoriLaporan;
use Illuminate\Http\Request;

class JenisLaporanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id'         => 'required|exists:kategori_laporan,id',
            'nama_jenis_laporan'  => 'required|string|max:255|unique:jenis_laporan,nama_jenis_laporan',
        ]);

        JenisLaporan::create([
            'kategori_id'         => $validated['kategori_id'],
            'nama_jenis_laporan'  => $validated['nama_jenis_laporan'],
            'status'              => 'active',
        ]);

        return back()->with('success', 'Jenis laporan berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $jenis = JenisLaporan::findOrFail($id);
        $kategori = KategoriLaporan::where('status', 'active')->get();
        return view('jenis_laporan.edit', compact('jenis', 'kategori'));
    }

    // Simpan perubahan jenis laporan
    public function update(Request $request, $id)
    {
        $jenis = JenisLaporan::findOrFail($id);

        $validated = $request->validate([
            'kategori_id'         => 'required|exists:kategori_laporan,id',
            'nama_jenis_laporan'  => 'required|string|max:255|unique:jenis_laporan,nama_jenis_laporan,' . $id,
        ]);

        $jenis->update([
            'kategori_id'         => $validated['kategori_id'],
            'nama_jenis_laporan'  => $validated['nama_jenis_laporan'],
        ]);

        return back()->with('success', 'Jenis laporan berhasil diperbarui.');
    }

    // Hapus jenis laporan
    public function destroy($id)
    {
        $jenis = JenisLaporan::findOrFail($id);
        $jenis->status = 'non-active';
        $jenis->save();

        return back()->with('success', 'Jenis laporan berhasil dihapus.');
    }

    public function getByKategori($kategoriId)
    {
        $jenis = JenisLaporan::where('kategori_id', $kategoriId)
            ->where('status', 'active')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $jenis
        ]);
    }
}
