<?php

// Nama File   = VerifyCsrfToken.php
// Deskripsi   = Middleware ini bertanggung jawab untuk memverifikasi token CSRF (Cross-Site Request Forgery)
//               pada setiap permintaan POST, PUT, PATCH, atau DELETE yang masuk.
//               Token CSRF adalah mekanisme keamanan untuk melindungi aplikasi web dari serangan CSRF.
//               File ini juga mendefinisikan rute-rute (URI) yang dikecualikan dari verifikasi CSRF.
// Dibuat oleh = Sultan Sadad - 3312301102
// Tanggal     = 16 Juli 2025

// app/Http/Middleware/VerifyCsrfToken.php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Symfony\Component\HttpFoundation\Cookie;

// use Illuminate\Cookie\Middleware\EncryptCookies; // Pastikan ini tidak diimpor jika tidak terpakai

class VerifyCsrfToken extends Middleware
{
    // ... (property $except) ...

    /**
     * Tambahkan cookie XSRF-TOKEN ke respons.
     * Kita akan override metode ini untuk membuat cookie HttpOnly.
     */
    protected function addCookieToResponse($request, $response)
    {
        $config = config('session'); // Ambil konfigurasi sesi

        // === PERHITUNGAN KEDALUWARSA COOKIE YANG BENAR ===
        $expiration = time() + config('session.lifetime') * 60;
        // ===============================================

        $response->headers->setCookie(
            new Cookie(
                'XSRF-TOKEN',
                $request->session()->token(),
                $expiration, // <--- GUNAKAN $expiration DI SINI
                $config['path'],
                $config['domain'],
                $config['secure'],
                true, // <-- Ini yang membuat HttpOnly menjadi TRUE
                false, // <-- isRaw (false karena ini token yang dienkripsi)
                $config['same_site'] ?? null
            )
        );

        return $response;
    }
}
