<?php

// Nama File   = PastikanPeranRekamMedis.php
// Deskripsi   = Middleware ini bertugas memastikan bahwa hanya pengguna dengan peran 'rekam_medis'
//               yang dapat mengakses rute atau halaman tertentu. Jika pengguna bukan rekam_medis
//               atau belum login sebagai staf, akses akan ditolak.
// Dibuat oleh = Sultan Sadad - 3312301102
// Tanggal     = 16 Juli 2025

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PastikanPeranRekamMedis
{
    /**
     * Memeriksa apakah pengguna yang sedang login adalah seorang 'rekam_medis'.
     * Jika ya, izinkan akses. Jika tidak, tolak akses.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna login melalui guard 'staf' dan memiliki peran 'rekam_medis'.
        $isRekamMedis = Auth::guard('staf')->check() &&
                        Auth::guard('staf')->user()->peran === 'rekam_medis';

        if ($isRekamMedis) {
            return $next($request);
        }

        // Jika bukan, tolak dengan error 403.
        abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
