<?php

namespace App\Http\Controllers;

use App\Models\JenisJabatan;
use App\Models\StrukturInspektorat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturInspektoratController extends Controller
{

    public function index()
    {
        $data = StrukturInspektorat::with('jabatan')->latest()->get();
        return view('struktur_inspektorat.index', compact('data'));
    }

    public function create()
    {
        $jenisJabatan = JenisJabatan::all();
        return view('struktur_inspektorat.create', compact('jenisJabatan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_jabatan'    => 'required|exists:jenis_jabatan,id',
            'nip'           => 'nullable|string|max:50',
            'nama_pegawai'  => 'required|string|max:255',
            'tahun_awal'    => 'nullable|date',
            'tahun_akhir'   => 'nullable|date',
            'telephone'     => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'status'        => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $request->validate([
                'foto' => 'image|mimes:jpg,jpeg,png|max:10048',
            ]);
            $validated['foto'] = $request->file('foto')->store('foto_inspektorat', 'public');
        }

        StrukturInspektorat::create($validated);

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $data = StrukturInspektorat::with('jabatan')->findOrFail($id);
        return view('struktur_inspektorat.show', compact('data'));
    }

    public function edit($id)
    {
        $data = StrukturInspektorat::findOrFail($id);
        $jenisJabatan = JenisJabatan::all();
        return view('struktur_inspektorat.edit', compact('data', 'jenisJabatan'));
    }

    public function update(Request $request, $id)
    {
        $data = StrukturInspektorat::findOrFail($id);

        $validated = $request->validate([
            'id_jabatan'    => 'required|exists:jenis_jabatan,id',
            'nip'           => 'nullable|string|max:50',
            'nama_pegawai'  => 'required|string|max:255',
            'tahun_awal'    => 'nullable|date',
            'tahun_akhir'   => 'nullable|date',
            'telephone'     => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'status'        => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $request->validate([
                'foto' => 'image|mimes:jpg,jpeg,png|max:10048',
            ]);

            if ($data->foto && Storage::disk('public')->exists($data->foto)) {
                Storage::disk('public')->delete($data->foto);
            }

            $validated['foto'] = $request->file('foto')->store('foto_inspektorat', 'public');
        }

        $data->update($validated);

        return redirect()->route('struktur-inspektorat.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        $data = StrukturInspektorat::findOrFail($id);
        if ($data->foto && Storage::disk('public')->exists($data->foto)) {
            Storage::disk('public')->delete($data->foto);
        }
        $data->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
