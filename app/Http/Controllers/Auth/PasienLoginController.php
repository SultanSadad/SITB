<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\Models\Pasien;

class PasienLoginController extends Controller
{
    // Menampilkan halaman login pasien
    public function index()
    {
        // Jika pasien sudah login, arahkan ke dashboard
        if (Auth::check()) {
            return redirect()->route('pasien.dashboard_pasien');
        }
        
        return view('auth.pasien_login'); 
    }

    // Proses login pasien
    public function login(Request $request)
    {
        // Validasi input nama dan tanggal lahir
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
        ]);

        // Cek pasien berdasarkan nama dan tanggal lahir
        $pasien = Pasien::where('nama', $request->nama)
                        ->where('tanggal_lahir', $request->tanggal_lahir)
                        ->first();

        // Jika pasien tidak ditemukan
        if (!$pasien) {
            return redirect()->back()->withErrors('Nama atau Tanggal Lahir tidak sesuai')->withInput();
        }

        // Login pasien
        Auth::login($pasien);

        // Log jika pasien berhasil login
        Log::info('Pasien login: ' . $pasien->nama);

        // Redirect ke dashboard pasien
        return redirect()->intended('pasien/dashboard_pasien');
    }

    // Proses logout pasien
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session dan regenerate token untuk mencegah CSRF token reuse
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login setelah logout
        return redirect()->route('pasien.login');
    }
}
