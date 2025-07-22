<?php

namespace App\Http\Controllers;

use App\Models\DokumenJawaban;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenJawabanController extends Controller
{
    public function ambilSemua($desaId)
    {
        // Ambil semua jenis dokumen aktif
        $semuaDokumen = JenisDokumen::where('status', 'active')->get();

        // Ambil dokumen_jawaban yang sesuai desa_id
        $dokumenTerisi = DokumenJawaban::where('desa_id', $desaId)->get()->keyBy('jenis_dokumen_id');

        // Gabungkan data jenis_dokumen + dokumen path (jika ada)
        $hasil = $semuaDokumen->map(function ($dokumen) use ($dokumenTerisi) {
            $entry = $dokumenTerisi->get($dokumen->id);
            return [
                'id' => $dokumen->id,
                'nama_dokumen' => $dokumen->nama_dokumen,
                'dokumen_rujukan' => $dokumen->dokumen_rujukan,
                'status' => $dokumen->status,
                'terisi' => $entry ? true : false,
                'dokumen' => $entry ? $entry->dokumen : null
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $hasil
        ]);
    }


    public function upload(Request $request)
    {
        $validated = $request->validate([
            'desa_id' => 'required|exists:desa,id',
            'jenis_dokumen_id' => 'required|exists:jenis_dokumen,id',
            'dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,xlsx|max:2048',
        ]);

        // Simpan file ke storage
        $path = $request->file('dokumen')->store('dokumen-jawaban', 'public');

        // Cek apakah sudah ada entri sebelumnya
        $existing = DokumenJawaban::where('desa_id', $validated['desa_id'])
            ->where('jenis_dokumen_id', $validated['jenis_dokumen_id'])
            ->first();

        if ($existing) {
            // Update dokumen yang lama (opsional: bisa hapus file lama juga)
            if ($existing->dokumen && Storage::disk('public')->exists($existing->dokumen)) {
                Storage::disk('public')->delete($existing->dokumen);
            }

            $existing->update([
                'dokumen' => $path,
            ]);
            $data = $existing;
        } else {
            // Insert baru
            $data = DokumenJawaban::create([
                'desa_id' => $validated['desa_id'],
                'jenis_dokumen_id' => $validated['jenis_dokumen_id'],
                'dokumen' => $path,
            ]);
        }

        return response()->json([
            'message' => 'Dokumen berhasil disimpan.',
            'data' => $data
        ]);
    }
}
