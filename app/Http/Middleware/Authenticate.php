<?php

// Nama File   = Authenticate.php
// Deskripsi   = Middleware ini memeriksa apakah pengguna sudah login sebelum akses halaman tertentu.
// Dibuat oleh = Salma - Aulia
// Tanggal     = 1 Maret 2025

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Mendapatkan URL redirect jika pengguna belum login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo(Request $request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('pasien/*')) {
                return route('pasien.login');
            }

            if (
                $request->is('staf/*') ||
                $request->is('rekam_medis/*') ||
                $request->is('laboran/*')
            ) {
                return route('staf.login');
            }

            return route('staf.login');
        }

        return null;
    }
}
