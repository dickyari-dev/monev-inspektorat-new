<?php

namespace App\Http\Controllers;

use \DB;
use App\Models\DokumenPertanyaan;
use App\Models\Jawaban;
use App\Models\JenisDokumen;
use App\Models\JenisLaporan;
use App\Models\KategoriLaporan;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_laporan,id',
            'jenis_laporan_id' => 'required|exists:jenis_laporan,id',
            'pertanyaan' => 'required|string|max:255',
            'dokumen_terpilih' => 'array',
            'dokumen_terpilih.*' => 'exists:jenis_dokumen,id',
        ]);

        // 1. Cek apakah pertanyaan dengan isi & kombinasi sama sudah ada
        $existing = Pertanyaan::where('kategori_laporan_id', $request->kategori_id)
            ->where('jenis_laporan_id', $request->jenis_laporan_id)
            ->where('pertanyaan', $request->pertanyaan)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Pertanyaan dengan isi dan kategori yang sama sudah ada.');
        }

        // 2. Simpan pertanyaan
        $pertanyaan = Pertanyaan::create([
            'kategori_laporan_id' => $request->kategori_id,
            'jenis_laporan_id' => $request->jenis_laporan_id,
            'pertanyaan' => $request->pertanyaan,
            'status' => 'active',
        ]);

        // 3. Simpan dokumen jika belum pernah dikaitkan
        if ($request->has('dokumen_terpilih')) {
            foreach ($request->dokumen_terpilih as $dokumenId) {
                foreach ($request->dokumen_terpilih as $dokumenId) {
                    $exists = DokumenPertanyaan::where('pertanyaan_id', $pertanyaan->id)
                        ->where('dokumen_id', $dokumenId)
                        ->exists();

                    if (!$exists) {
                        DokumenPertanyaan::create([
                            'pertanyaan_id' => $pertanyaan->id,
                            'dokumen_id' => $dokumenId,
                            'status' => 'active',
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Pertanyaan berhasil disimpan.');
    }


    public function edit($id)
    {
        $pertanyaan = Pertanyaan::with('dokumen')->findOrFail($id);
        $kategori = KategoriLaporan::all();
        $jenis = JenisLaporan::where('kategori_id', $pertanyaan->kategori_laporan_id)->get();
        $dokumen = JenisDokumen::where('status', 'active')->get();

        return view('pertanyaan.edit', compact('pertanyaan', 'kategori', 'jenis', 'dokumen'));
    }

    public function update(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:kategori_laporan,id',
            'jenis_laporan_id' => 'required|exists:jenis_laporan,id',
            'pertanyaan' => 'required|string|max:255',
            'dokumen_terpilih' => 'array',
            'dokumen_terpilih.*' => 'exists:jenis_dokumen,id',
        ]);

        $pertanyaan->update([
            'kategori_laporan_id' => $request->kategori_id,
            'jenis_laporan_id' => $request->jenis_laporan_id,
            'pertanyaan' => $request->pertanyaan,
        ]);

        $pertanyaan->dokumen()->sync($request->dokumen_terpilih ?? []);

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->dokumen()->detach(); // hapus relasi dokumen
        $pertanyaan->delete();

        return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus.');
    }

    public function getByJenis($jenisId, $desaId)
    {
        $pertanyaan = Pertanyaan::where('jenis_laporan_id', $jenisId)->get();

        $data = [];
        foreach ($pertanyaan as $p) {
            $jawabanAda = Jawaban::where('pertanyaan_id', $p->id)
                ->where('desa_id', $desaId)
                ->exists(); // Lebih efisien dari ->first()

            $data[] = [
                'id' => $p->id,
                'pertanyaan' => $p->pertanyaan,
                'dokumen' => $p->dokumen,
                'terjawab' => $jawabanAda,
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }



    public function getDokumenPertanyaan($pertanyaan_id, $desa_id)
    {
        $data = DokumenPertanyaan::where('pertanyaan_id', $pertanyaan_id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'desa_id' => $desa_id
        ]);
    }
}
