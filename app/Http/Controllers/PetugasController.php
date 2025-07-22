<?php

namespace App\Http\Controllers;

use \Storage;
use App\Models\Petugas;
use App\Models\StrukturInspektorat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|exists:struktur_inspektorat,id',
            'nip' => 'required|string|max:255',
            'status' => 'required|in:kepala,petugas',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cek apakah pegawai sudah ada
        if (Petugas::where('struktur_inspektorat_id', $request->id_pegawai)->exists()) {
            return redirect()->back()->with('error', 'Pegawai sudah ada.');
        }

        // Upload photo
        $path = $request->file('photo')->store('petugas_photos', 'public');

        // Simpan ke tabel users
        $user = User::create([
            'name' => $request->nama_pegawai ?? 'Petugas', // optional jika mau isi nama pegawai
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $path,
            'status_jab' => $request->status,
            'role' => 'inspektorat',
        ]);

        // Simpan ke tabel petugas
        Petugas::create([
            'user_id' => $user->id,
            'struktur_inspektorat_id' => $request->id_pegawai,
            'status_jab' => $request->status,
            'nip' => $request->nip,
            'photo' => $path,
            'status' => 'active'
        ]);

        return redirect()->back()->with('success', 'Data petugas berhasil disimpan.');
    }

    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);
        $inspektorat = StrukturInspektorat::where('status', 'active')->get();
        if (Auth::user()->role == 'inspektorat') {
            return view('inspektorat.petugas-edit', compact('petugas', 'inspektorat'));
        } elseif (Auth::user()->role == 'kecamatan') {
            return view('kecamatan.petugas-edit', compact('petugas', 'inspektorat'));
        } elseif (Auth::user()->role == 'desa') {
            return view('desa.petugas-edit', compact('petugas', 'inspektorat'));
        }
    }
    public function update(Request $request, $id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);

        $request->validate([
            'id_pegawai' => 'required|exists:struktur_inspektorat,id',
            'nip' => 'required|string|max:255',
            'status' => 'required|in:kepala,petugas',
            'email' => 'required|email|unique:users,email,' . $petugas->user_id,
            'password' => 'nullable|string|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cek apakah pegawai sudah digunakan oleh petugas lain
        $exists = Petugas::where('struktur_inspektorat_id', $request->id_pegawai)
            ->where('id', '!=', $petugas->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Pegawai sudah digunakan oleh petugas lain.');
        }

        // Update foto jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama (optional)
            if ($petugas->photo) {
                $validated['foto'] = $request->file('foto')->store('foto_struktur', 'public');
            }

            $path = $request->file('photo')->store('petugas_photos', 'public');
            $petugas->photo = $path;
        }

        // Update user
        $user = $petugas->user;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update petugas
        $petugas->struktur_inspektorat_id = $request->id_pegawai;
        $petugas->nip = $request->nip;
        $petugas->status_jab = $request->status;
        $petugas->save();

        return redirect()->route('data-petugas.index')->with('success', 'Data petugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);

        // Ubah status jadi non-active
        $petugas->status = 'non-active';
        $petugas->save();

        return redirect()->route('data-petugas.index')->with('success', 'Status petugas berhasil dinonaktifkan.');
    }
}
