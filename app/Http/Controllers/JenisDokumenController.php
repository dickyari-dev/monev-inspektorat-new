<?php

namespace App\Http\Controllers;

use App\Models\JenisDokumen;
use Illuminate\Http\Request;

class JenisDokumenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_dokumen'     => 'required|string|max:255|unique:jenis_dokumen,nama_dokumen',
            'dokumen_rujukan'  => 'nullable|string|max:255',
            'status'           => 'nullable|in:active,inactive',
        ]);

        JenisDokumen::create([
            'nama_dokumen'     => $validated['nama_dokumen'],
            'dokumen_rujukan'  => $validated['dokumen_rujukan'] ?? null,
            'status'           => $validated['status'] ?? 'active',
        ]);

        return back()->with('success', 'Jenis dokumen berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $dokumen = JenisDokumen::findOrFail($id);
        return view('jenis_dokumen.edit', compact('dokumen'));
    }

    // Simpan perubahan data
    public function update(Request $request, $id)
    {
        $dokumen = JenisDokumen::findOrFail($id);

        $validated = $request->validate([
            'nama_dokumen'     => 'required|string|max:255|unique:jenis_dokumen,nama_dokumen,' . $id,
            'dokumen_rujukan'  => 'nullable|string|max:255',
            'status'           => 'nullable|in:active,inactive',
        ]);

        $dokumen->update([
            'nama_dokumen'     => $validated['nama_dokumen'],
            'dokumen_rujukan'  => $validated['dokumen_rujukan'] ?? null,
            'status'           => $validated['status'] ?? 'active',
        ]);

        return back()->with('success', 'Jenis dokumen berhasil diperbarui.');
    }

    // Hapus data
    public function destroy($id)
    {
        $dokumen = JenisDokumen::findOrFail($id);
        $dokumen->status = 'non-active';
        $dokumen->save();

        return back()->with('success', 'Jenis dokumen berhasil dihapus.');
    }
}
