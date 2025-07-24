<?php

// Nama File   = LoginController.php
// Deskripsi   = Mengatur semua logika yang berkaitan dengan proses login (masuk)
//               dan logout (keluar) untuk dua jenis pengguna: Pasien dan Staf.
//               Controller ini menentukan halaman login mana yang akan ditampilkan,
//               bagaimana data login divalidasi, dan ke mana pengguna akan diarahkan
//               setelah berhasil atau gagal login/logout.
// Dibuat oleh = Salma  Aulia - 3312301096
// Tanggal     = 1 April 2025

namespace App\Http\Controllers;

// Menentukan lokasi (namespace) dari controller ini.

// =========================================================================
// Import Kelas yang Dibutuhkan
// =========================================================================

// Import Request untuk mengambil data dari form (input pengguna).
use Illuminate\Http\Request;
// Import model Pasien untuk berinteraksi dengan data pasien di database.
use App\Models\Pasien;
// Import model Staf untuk berinteraksi dengan data staf di database.
use App\Models\Staf;
// Import model User. Perhatikan bahwa model User mungkin digunakan untuk guard 'web' default Laravel
// atau untuk relasi umum. Pastikan penggunaannya sesuai dengan konfigurasi autentikasi Anda.
use App\Models\User;
// Import Facade Auth untuk melakukan operasi autentikasi (login/logout).
use Illuminate\Support\Facades\Auth;
// Import Facade Hash untuk mengenkripsi password.
use Illuminate\Support\Facades\Hash;

// =========================================================================
// Definisi Kelas Controller
// =========================================================================

class LoginController extends Controller
{
    public function showPasienLoginForm()
    {
        return view('auth.login_pemohon');
    }

    public function loginPasien(Request $request)
    {
        $request->validate([
            'nik' => 'required|string',
            'no_erm' => 'required|string',
        ]);

        $pasien = Pasien::where('nik', $request->nik)
            ->where('no_erm', $request->no_erm)
            ->first();

        if (!$pasien) {
            return back()->withErrors([
                'nik' => 'NIK atau Nomor Rekam Medis tidak valid.',
            ])->withInput();
        }

        Auth::guard('pasien')->login($pasien);

        $request->session()->regenerate();

        return redirect()->route('pasien.dashboard');
    }

    public function showStafLoginForm()
    {
        return view('auth.login_petugas');
    }

    public function loginStaf(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('staf')->attempt($credentials)) {
            $request->session()->regenerate();
            $staf = Auth::guard('staf')->user();

            if ($staf->peran === 'rekam_medis') {
                return redirect()->intended(route('rekam-medis.dashboard'));
            } elseif ($staf->peran === 'laboran') {
                return redirect()->intended(route('laboran.dashboard'));
            } else {
                return redirect()->intended(route('staf.dashboard'));
            }
        }

        return back()->withErrors([
            'email' => 'Username atau password yang Anda masukkan salah.',
        ])->withInput(
            $request->only('email')
        );
    }

    public function logout(Request $request)
    {
        $redirectRoute = 'pasien.login';

        if (Auth::guard('staf')->check()) {
            Auth::guard('staf')->logout();
            $redirectRoute = 'staf.login';
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            $redirectRoute = 'pasien.login';
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($redirectRoute);
    }
}
