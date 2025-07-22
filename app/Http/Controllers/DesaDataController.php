<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DesaDataController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_desa'    => 'required|string|unique:desa,kode_desa',
            'nama_desa'    => 'required|string',
            'kecamatan' => 'required|exists:kecamatan,id',
            'alamat_desa'       => 'nullable|string',
            'telephone'      => 'nullable|string|max:20',
            'email'            => 'required|email',
            'password'         => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['nama_desa'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'desa',
        ]);

        Desa::create([
            'user_id'      => $user->id,
            'kode_desa'    => $validated['kode_desa'],
            'nama_desa'    => $validated['nama_desa'],
            'kecamatan_id' => $validated['kecamatan'],
            'alamat'       => $validated['alamat_desa'],
            'telepon'      => $validated['telephone'],
            'status'       => 'active',
        ]);


        return back()->with('success', 'Data desa berhasil disimpan.');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $desa = Desa::findOrFail($id);
        $kecamatan = Kecamatan::all();
        return view('inspektorat.desa-edit', compact('desa', 'kecamatan'));
    }

    // Simpan perubahan desa
    public function update(Request $request, $id)
    {
        $desa = Desa::findOrFail($id);

        $validated = $request->validate([
            'kode_desa'    => 'required|string|unique:desa,kode_desa,' . $id,
            'nama_desa'    => 'required|string',
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'alamat_desa'       => 'nullable|string',
            'telephone'      => 'nullable|string|max:20',
            'email'            => 'required|email',
            'password'         => 'nullable|string|min:6',
        ]);

        $desa->update([
            'kode_desa'    => $validated['kode_desa'],
            'nama_desa'    => $validated['nama_desa'],
            'kecamatan_id' => $validated['kecamatan_id'],
            'alamat'       => $validated['alamat_desa'],
            'telepon'      => $validated['telephone'],
        ]);

        // Email
        $desa->user->update([
            'name' => $validated['nama_desa'],
            'email' => $validated['email'],
        ]);

        if ($validated['password']) {
            $desa->user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return redirect()->route('inspektorat.setting-wilayah')->with('success', 'Data desa berhasil diperbarui.');
    }

    // Hapus desa
    public function destroy($id)
    {
        $desa = Desa::findOrFail($id);
        $desa->delete();

        return back()->with('success', 'Data desa berhasil dihapus.');
    }
}
