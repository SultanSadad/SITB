<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Staf;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Form login untuk pasien
    public function showPasienLoginForm()
    {
        return view('auth.pasien_login');
    }

    // Proses login pasien menggunakan NIK & No.ERM
    public function loginPasien(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'no_erm' => 'required',
        ]);

        $pasien = Pasien::where('nik', $request->nik)
            ->where('no_erm', $request->no_erm)
            ->first();

        if ($pasien) {
            $user = User::where('profile_id', $pasien->id)
                ->where('role', 'pasien')
                ->first();

            if ($user) {
                Auth::login($user);
                return redirect()->route('pasien.dashboard');
            }
        }

        return back()->withErrors(['login_failed' => 'NIK atau No.ERM tidak ditemukan']);
    }

    // Form login untuk staf
    public function showStafLoginForm()
    {
        return view('auth.staf_login');
    }

    // Proses login staf menggunakan email & password
    public function loginStaf(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
            ->where('role', 'staf') // ← role staf dari tabel users
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            // Ambil data staf dari profile_id
            $staf = Staf::find($user->profile_id);

            // Redirect berdasarkan peran staf
            if ($staf?->peran === 'laboran') {
                return redirect()->route('laboran.dashboard');
            } elseif ($staf?->peran === 'rekam_medis') {
                return redirect()->route('rekam-medis.dashboard');
            }

            Auth::logout();
            return back()->withErrors(['login_failed' => 'Peran staf tidak valid.']);
        }

        return back()->withErrors(['login_failed' => 'Email atau password salah']);
    }

    // Logout umum untuk semua peran
    public function logout(Request $request)
    {
        $user = Auth::user();  // Mendapatkan user yang sedang login

        Auth::logout();  // Logout user
        $request->session()->invalidate();  // Invalidasi session
        $request->session()->regenerateToken();  // Regenerasi token CSRF

        // Redirect berdasarkan role pengguna
        if ($user->role === 'staf') {
            return redirect()->route('staf.login');  // Jika staf, redirect ke login staf
        }

        return redirect()->route('pasien.login');  // Jika pasien, redirect ke login pasien
    }
}
