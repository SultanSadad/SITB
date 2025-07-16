<?php

// Nama File   = PastikanPeranRekamMedis.php
// Deskripsi   = Middleware ini bertugas memastikan bahwa hanya pengguna dengan peran 'rekam_medis'
//               yang dapat mengakses rute atau halaman tertentu. Jika pengguna bukan rekam_medis
//               atau belum login sebagai staf, akses akan ditolak.
// Dibuat oleh = Sultan Sadad - 3312301102
// Tanggal     = 16 Juli 2025

namespace App\Http\Middleware; // Menentukan lokasi (namespace) dari middleware ini.
use Closure; // Import Closure untuk tipe data callback.
use Illuminate\Http\Request; // Import kelas Request untuk bekerja dengan permintaan HTTP.
use Illuminate\Support\Facades\Auth; // Import Facade Auth untuk mengecek status login.
use Symfony\Component\HttpFoundation\Response; // Import kelas Response dari Symfony untuk tipe data respons HTTP.

class PastikanPeranRekamMedis
{
    /**
     * handle()
     *
     * **Tujuan:** Memeriksa apakah pengguna yang sedang login adalah seorang 'rekam_medis'.
     * Jika ya, izinkan akses. Jika tidak, tolak akses.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang sedang diproses.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next Closure yang mewakili middleware berikutnya atau handler utama.
     * @return \Symfony\Component\HttpFoundation\Response Respons HTTP (lanjutkan atau tolak).
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek Login Staf & Peran:
        //    - `Auth::guard('staf')->check()`: Memeriksa apakah ada pengguna yang login melalui guard 'staf'.
        //    - `Auth::guard('staf')->user()->peran === 'rekam_medis'`: Jika ada, periksa apakah peran staf tersebut adalah 'rekam_medis'.
        if (Auth::guard('staf')->check() && Auth::guard('staf')->user()->peran === 'rekam_medis') {
            // Jika pengguna adalah staf DAN perannya 'rekam_medis', izinkan permintaan untuk dilanjutkan.
            return $next($request);
        }

        // Jika kondisi di atas tidak terpenuhi (bukan staf, atau staf tapi bukan rekam_medis),
        // hentikan permintaan dan tampilkan error 403 (Forbidden) dengan pesan.
        abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}