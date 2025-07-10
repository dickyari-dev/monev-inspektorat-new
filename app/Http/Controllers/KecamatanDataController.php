<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanDataController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_kecamatan'   => 'required|string|unique:kecamatan,kode_kecamatan',
            'nama_kecamatan'   => 'required|string',
            'alamat_kecamatan' => 'nullable|string',
            'kode_pos'         => 'nullable|string|max:20',
            'telephone'        => 'nullable|string|max:20',
        ]);

        // Simpan ke database
        Kecamatan::create([
            'kode_kecamatan'   => $validated['kode_kecamatan'],
            'nama_kecamatan'   => $validated['nama_kecamatan'],
            'nama_kabupaten'   => 'Probolinggo',
            'alamat'           => $validated['alamat_kecamatan'],
            'kode_pos'         => $validated['kode_pos'],
            'telepon'          => $validated['telephone'],
            'status'           => 'active', // default value, bisa diubah jika perlu
        ]);

        return redirect()->back()->with('success', 'Data kecamatan berhasil disimpan.');
    }

    public function edit($id)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        return view('inspektorat.kecamatan-edit', compact('kecamatan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_kecamatan'   => 'required|string|unique:kecamatan,kode_kecamatan,' . $id,
            'nama_kecamatan'   => 'required|string',
            'alamat_kecamatan' => 'nullable|string',
            'kode_pos'         => 'nullable|string|max:20',
            'telephone'        => 'nullable|string|max:20',
        ]);

        // Ambil data berdasarkan ID
        $kecamatan = Kecamatan::findOrFail($id);

        // Update data
        $kecamatan->update([
            'kode_kecamatan' => $validated['kode_kecamatan'],
            'nama_kecamatan' => $validated['nama_kecamatan'],
            'alamat'         => $validated['alamat_kecamatan'],
            'kode_pos'       => $validated['kode_pos'],
            'telepon'        => $validated['telephone'],
        ]);

        return redirect()->route('inspektorat.setting-wilayah')->with('success', 'Data kecamatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        $kecamatan->status = 'non-active';
        $kecamatan->save();

        return back()->with('success', 'Data kecamatan berhasil dihapus.');
    }
}
