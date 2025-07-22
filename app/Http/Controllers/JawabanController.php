<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use Illuminate\Http\Request;

class JawabanController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'pertanyaan_id' => 'required|exists:pertanyaan,id',
            'desa_id' => 'required|exists:desa,id',
            'checked' => 'required|boolean', // true = sudah, false = belum
        ]);

        // Cek apakah sudah ada jawaban
        $jawaban = Jawaban::where('pertanyaan_id', $validated['pertanyaan_id'])
            ->where('desa_id', $validated['desa_id'])
            ->first();

        if ($jawaban) {
            // Update nilai jawaban sesuai status checkbox
            $jawaban->jawaban = $validated['checked'] ? 'sudah' : 'belum';
            $jawaban->save();
        } else {
            // Simpan baru
            $jawaban = Jawaban::create([
                'pertanyaan_id' => $validated['pertanyaan_id'],
                'desa_id' => $validated['desa_id'],
                'jawaban' => $validated['checked'] ? 'sudah' : 'belum',
            ]);
        }

        return response()->json([
            'message' => 'Jawaban berhasil disimpan atau diperbarui',
            'data' => $jawaban
        ], 200);
    }
}
