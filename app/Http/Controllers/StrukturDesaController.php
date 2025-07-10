<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\JenisJabatan;
use App\Models\Kecamatan;
use App\Models\StrukturDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturDesaController extends Controller
{
    public function index()
    {
        $data = StrukturDesa::with(['desa', 'kecamatan', 'jabatan'])->get();
        return view('struktur_desa.index', compact('data'));
    }

    public function create()
    {
        $desa = Desa::all();
        $kecamatan = Kecamatan::all();
        $jabatans = JenisJabatan::all();
        return view('struktur_desa.create', compact('desa', 'kecamatan', 'jabatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_desa' => 'required|exists:desa,id',
            'id_kecamatan' => 'required|exists:kecamatan,id',
            'id_jabatan' => 'required|exists:jenis_jabatan,id',
            'nip' => 'nullable|string|max:50',
            'nama_pegawai' => 'required|string|max:255',
            'tahun_awal' => 'nullable|date',
            'tahun_akhir' => 'nullable|date',
            'telephone' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:10048',
            'status' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto_desa', 'public');
        }

        StrukturDesa::create($validated);
        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        $item = StrukturDesa::findOrFail($id);
        $desa = Desa::all();
        $kecamatan = Kecamatan::all();
        $jabatans = JenisJabatan::all();
        return view('struktur_desa.edit', compact('item', 'desa', 'kecamatan', 'jabatans'));
    }

    public function update(Request $request, $id)
    {
        $data = StrukturDesa::findOrFail($id);

        $validated = $request->validate([
            'id_desa' => 'required|exists:desa,id',
            'id_kecamatan' => 'required|exists:kecamatan,id',
            'id_jabatan' => 'required|exists:jenis_jabatan,id',
            'nip' => 'nullable|string|max:50',
            'nama_pegawai' => 'required|string|max:255',
            'tahun_awal' => 'nullable|date',
            'tahun_akhir' => 'nullable|date',
            'telephone' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            if ($data->foto && Storage::disk('public')->exists($data->foto)) {
                Storage::disk('public')->delete($data->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto_desa', 'public');
        }

        $data->update($validated);
        return redirect()->route('struktur-desa.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = StrukturDesa::findOrFail($id);
        if ($data->foto && Storage::disk('public')->exists($data->foto)) {
            Storage::disk('public')->delete($data->foto);
        }
        $data->status = 'non-active';
        $data->save();
        return redirect()->route('struktur-desa.index')->with('success', 'Data berhasil dihapus.');
    }

    public function getByKecamatan($id)
    {
        $desa = Desa::where('kecamatan_id', $id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $desa
        ]);
    }
}
