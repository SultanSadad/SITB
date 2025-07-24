<?php

// Nama File   = NoCacheAfterLogout.php
// Deskripsi   = Middleware ini mencegah browser menyimpan cache halaman setelah logout,
//               agar tidak bisa diakses kembali oleh pengguna lain di perangkat yang sama.
// Dibuat oleh = Salma
// Tanggal     = 16 Juli 2025

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCacheAfterLogout
{
    /**
     * Middleware untuk mencegah caching setelah logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set(
            'Cache-Control',
            'no-store, no-cache, must-revalidate, max-age=0'
        );

        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');

        return $response;
    }
}
