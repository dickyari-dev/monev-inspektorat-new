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
                'status' => $entry ? $entry->status : null,
                'terisi' => $entry ? true : false,
                'dokumen' => $entry ? $entry->dokumen : null,
                'keterangan_pengirim' => $entry ? $entry->keterangan_pengirim : null
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

        // Cek apakah sudah ada entri sebelumnya
        $existing = DokumenJawaban::where('desa_id', $validated['desa_id'])
            ->where('jenis_dokumen_id', $validated['jenis_dokumen_id'])
            ->first();

        if ($existing) {
            // Hapus file lama jika ada
            if ($existing->dokumen && Storage::disk('public')->exists($existing->dokumen)) {
                Storage::disk('public')->delete($existing->dokumen);
            }

            // Hapus record lama dari database
            $existing->delete();
        }

        // Upload dokumen baru
        $path = $request->file('dokumen')->store('dokumen-jawaban', 'public');

        // Simpan record baru
        $data = DokumenJawaban::create([
            'desa_id' => $validated['desa_id'],
            'jenis_dokumen_id' => $validated['jenis_dokumen_id'],
            'dokumen' => $path,
        ]);

        return response()->json([
            'message' => 'Dokumen berhasil diunggah dan diperbarui.',
            'data' => $data
        ]);
    }

    public function uploadInspektorat(Request $request)
    {
        $validated = $request->validate([
            'desa_id' => 'required|exists:desa,id',
            'jenis_dokumen_id' => 'required|exists:jenis_dokumen,id',
            'status' => 'required|in:pending,revisi,terima',
            'keterangan' => 'nullable|string',
        ]);

        // Cari entri yang sudah ada
        $existing = DokumenJawaban::where('desa_id', $validated['desa_id'])
            ->where('jenis_dokumen_id', $validated['jenis_dokumen_id'])
            ->first();

        if (!$existing) {
            return response()->json([
                'message' => 'Dokumen belum diunggah. Tidak dapat memperbarui status.',
            ], 404);
        }

        // Lanjut update jika ditemukan
        $existing->update([
            'status' => $validated['status'],
            'keterangan_pengirim' => $validated['keterangan'] ?? null,
        ]);

        return response()->json([
            'message' => 'Status dokumen berhasil diperbarui.',
            'data' => $existing
        ]);
    }
}
