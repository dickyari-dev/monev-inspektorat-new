<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'inspektorat') {
                return redirect()->route('inspektorat.dashboard')->with('success', 'Selamat datang! Inspektorat');
            } elseif ($user->role === 'kecamatan') {
                return redirect()->route('kecamatan.dashboard')->with('success', 'Selamat datang! Admin Kecamatan');
            } elseif ($user->role === 'desa') {
                return redirect()->route('desa.dashboard')->with('success', 'Selamat datang! Admin Desa');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak dikenali.');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }


    public function logout()
    {
        Auth::logout();
      
        return redirect()->route('login');
    }
}
