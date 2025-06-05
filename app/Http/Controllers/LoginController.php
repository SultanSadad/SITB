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
    // Menampilkan form login untuk pasien
    public function showPasienLoginForm()
    {
        return view('auth.login_pemohon');
    }

    // Proses login untuk pasien
    public function loginPasien(Request $request)
    {
        // Validasi input
        $request->validate([
            'nik' => 'required|string',
            'no_erm' => 'required|string',
        ]);

        // Cari pasien berdasarkan NIK dan No. ERM
        $pasien = Pasien::where('nik', $request->nik)
            ->where('no_erm', $request->no_erm)
            ->first();

        // Jika tidak ditemukan, kembali ke form dengan error
        if (!$pasien) {
            return back()->withErrors([
                'nik' => 'NIK atau Nomor Rekam Medis tidak valid.',
            ])->withInput();
        }

        // Cari akun user terkait pasien tersebut
        $user = User::where('pasien_id', $pasien->id)
            ->where('role', 'pasien')
            ->first();

        // Jika belum ada akun, buatkan user baru untuk pasien
        if (!$user) {
            $user = User::create([
                'name' => $pasien->nama,
                'email' => null,
                'password' => null,
                'role' => 'pasien',
                'pasien_id' => $pasien->id,
            ]);
        }

        // Login user pasien
        Auth::login($user);

        // Redirect ke dashboard pasien
        return redirect()->route('pasien.dashboard');
    }

    // Menampilkan form login untuk staf
    public function showStafLoginForm()
    {
        return view('auth.login_petugas');
    }

    // Proses login untuk staf menggunakan email atau nama & password
    public function loginStaf(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        // Cari user dengan role staf berdasarkan email atau nama
        $user = User::where('role', 'staf')
            ->where(function ($query) use ($request) {
                $query->where('email', $request->email)
                    ->orWhere('name', $request->email);
            })
            ->first();

        // Cek kecocokan password
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            // Ambil data staf terkait
            $staf = Staf::find($user->staf_id);

            // Redirect sesuai peran staf
            if ($staf?->peran === 'laboran') {
                return redirect()->route('laboran.dashboard');
            } elseif ($staf?->peran === 'rekam_medis') {
                return redirect()->route('rekam-medis.dashboard');
            }

            // Jika peran tidak valid, logout kembali
            Auth::logout();
            return back()->withErrors(['login_failed' => 'Peran staf tidak valid.']);
        }

        // Jika user tidak ditemukan atau password salah
        return back()->withErrors(['login_failed' => 'Username atau password salah']);
    }

    // Proses logout untuk semua user
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Logout dan hapus session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login sesuai peran
        if ($user->role === 'staf') {
            return redirect()->route('staf.login');
        }

        return redirect()->route('pasien.login');
    }
}

