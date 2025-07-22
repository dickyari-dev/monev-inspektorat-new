<?php

namespace App\Http\Controllers;

use App\Models\KategoriLaporan;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class KategoriLaporanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori_laporan' => 'required|string|max:255|unique:kategori_laporan,nama_kategori_laporan',
        ]);

        KategoriLaporan::create($validated);

        return back()->with('success', 'Kategori laporan berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $kategori = KategoriLaporan::findOrFail($id);
        return view('kategori_laporan.edit', compact('kategori'));
    }

    // Simpan perubahan
    public function update(Request $request, $id)
    {
        $kategori = KategoriLaporan::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori_laporan' => 'required|string|max:255|unique:kategori_laporan,nama_kategori_laporan,' . $id,
        ]);

        $kategori->update($validated);

        return back()->with('success', 'Kategori laporan berhasil diperbarui.');
    }

    // Hapus kategori laporan
    public function destroy($id)
    {
        $kategori = KategoriLaporan::findOrFail($id);
        $kategori->status = 'non-active';
        $kategori->save();
        return back()->with('success', 'Kategori laporan berhasil dihapus.');
    }
    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'kategori_laporan_id');
    }
}
