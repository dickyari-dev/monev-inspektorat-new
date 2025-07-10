<?php

namespace App\Http\Controllers;

use App\Models\JenisJabatan;
use Illuminate\Http\Request;

class JenisJabatanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'kategori' => 'nullable|in:i,k,d',
            'status' => 'nullable|string',
        ]);

        $jabatan = JenisJabatan::create($validated);

        return response()->json([
            'message' => 'Data berhasil disimpan.',
            'data' => $jabatan,
        ], 201);
    }

    public function show($id)
    {
        $jabatan = JenisJabatan::findOrFail($id);
        return response()->json($jabatan);
    }

    public function update(Request $request, $id)
    {
        $jabatan = JenisJabatan::findOrFail($id);

        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'kategori' => 'nullable|in:i,k,d',
            'status' => 'nullable|string',
        ]);

        $jabatan->update($validated);

        return response()->json([
            'message' => 'Data berhasil diperbarui.',
            'data' => $jabatan,
        ]);
    }

    public function destroy($id)
    {
        $jabatan = JenisJabatan::findOrFail($id);
        $jabatan->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}
