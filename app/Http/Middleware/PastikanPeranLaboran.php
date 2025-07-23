<?php

// Nama File   = PastikanPeranLaboran.php
// Deskripsi   = Middleware ini bertugas memastikan bahwa hanya pengguna dengan peran 'laboran'
//               yang dapat mengakses rute atau halaman tertentu. Jika pengguna bukan laboran
//               atau belum login sebagai staf, akses akan ditolak.
// Dibuat oleh = Salma
// Tanggal     = 16 Juli 2025

namespace App\Http\Middleware;

// Menentukan lokasi (namespace) dari middleware ini.
use Closure; // Import Closure untuk tipe data callback.
use Illuminate\Http\Request; // Import kelas Request untuk bekerja dengan permintaan HTTP.
use Illuminate\Support\Facades\Auth;

// Import Facade Auth untuk mengecek status login.



class PastikanPeranLaboran
{
    /**
     * handle()
     *
     * **Tujuan:** Memeriksa apakah pengguna yang sedang login adalah seorang 'laboran'.
     * Jika ya, izinkan akses. Jika tidak, tolak akses.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang sedang diproses.
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next Closure yang mewakili middleware berikutnya atau handler utama.
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse Respons HTTP atau pengalihan.
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Cek Login Staf & Peran:
        //    - `Auth::guard('staf')->check()`: Memeriksa apakah ada pengguna yang login melalui guard 'staf'.
        //    - `Auth::guard('staf')->user()->peran === 'laboran'`: Jika ada, periksa apakah peran staf tersebut adalah 'laboran'.
        if (Auth::guard('staf')->check() && Auth::guard('staf')->user()->peran === 'laboran') {
            // Jika pengguna adalah staf dan perannya 'laboran', izinkan permintaan untuk dilanjutkan.
            return $next($request);
        }

        // Jika kondisi di atas tidak terpenuhi (bukan staf, atau staf tapi bukan laboran),
        // hentikan permintaan dan tampilkan error 403 (Forbidden).
        abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
