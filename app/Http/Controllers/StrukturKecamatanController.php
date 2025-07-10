<?php

namespace App\Http\Controllers;

use App\Models\JenisJabatan;
use App\Models\Kecamatan;
use App\Models\StrukturKecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturKecamatanController extends Controller
{
    public function index()
    {
        $data = StrukturKecamatan::with('jabatan')->get();
        return view('struktur_kecamatan.index', compact('data'));
    }

    public function create()
    {
        $jabatans = JenisJabatan::all();
        return view('struktur_kecamatan.create', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kecamatan' => 'required|integer',
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
            $validated['foto'] = $request->file('foto')->store('foto_struktur', 'public');
        }

        StrukturKecamatan::create($validated);

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = StrukturKecamatan::with('jabatan')->findOrFail($id);
        return view('struktur_kecamatan.show', compact('item'));
    }

    public function edit($id)
    {
        $item = StrukturKecamatan::findOrFail($id);
        $kecamatan = Kecamatan::where('status', 'active')->get();
        $jenisJabatan = JenisJabatan::where('status', 'active')->get();
        return view('inspektorat.struktur-kecamatan-edit', compact('item','kecamatan', 'jenisJabatan'));
    }

    public function update(Request $request, $id)
    {
        $data = StrukturKecamatan::findOrFail($id);

        $validated = $request->validate([
            'id_kecamatan' => 'required|integer',
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
            if ($data->foto && Storage::disk('public')->exists($data->foto)) {
                Storage::disk('public')->delete($data->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto_struktur', 'public');
        }

        $data->update($validated);

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = StrukturKecamatan::findOrFail($id);
        // if ($data->foto && Storage::disk('public')->exists($data->foto)) {
        //     Storage::disk('public')->delete($data->foto);
        // }

        $data->status = 'non-active';
        $data->save();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
