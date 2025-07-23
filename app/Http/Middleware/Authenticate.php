<?php

// Nama File   = Authenticate.php
// Deskripsi   = Middleware ini bertanggung jawab untuk memeriksa apakah pengguna sudah terautentikasi (sudah login)
//               sebelum mereka dapat mengakses rute atau halaman tertentu. Jika pengguna belum login,
//               middleware ini akan mengarahkan mereka ke halaman login yang sesuai, tergantung pada URL yang mereka coba akses.
// Dibuat oleh = Salma - Aulia
// Tanggal     = 1 Maret 2025 (Asumsi tanggal pembuatan middleware ini, bisa disesuaikan)

namespace App\Http\Middleware;

// Menentukan lokasi (namespace) dari middleware ini.

// Import kelas dasar Authenticate dari Laravel.
use Illuminate\Auth\Middleware\Authenticate as Middleware;
// Import kelas Request untuk bekerja dengan permintaan HTTP.
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * redirectTo()
     *
     * **Tujuan:** Mendapatkan URL atau rute ke mana pengguna harus diarahkan jika mereka tidak terautentikasi (belum login).
     * Middleware ini adalah inti dari sistem "gerbang" login. Jika pengguna mencoba mengakses halaman yang dilindungi
     * tanpa login, fungsi ini akan menentukan ke mana mereka harus "dibuang" atau dialihkan.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang sedang berjalan.
     * @return string|null Rute (URL) tempat pengguna harus diarahkan, atau `null` jika request adalah AJAX/JSON.
     */
    protected function redirectTo(Request $request)
    {
        // 1. Cek Tipe Permintaan:
        //    - Jika permintaan adalah AJAX (misal: dari JavaScript) atau mengharapkan respons JSON,
        //      maka jangan lakukan redirect. Biarkan Laravel mengembalikan respons HTTP 401 (Unauthorized)
        //      yang bisa ditangani oleh sisi klien (JavaScript).
        if (!$request->expectsJson()) {
            // 2. Cek Prefix URL untuk Menentukan Halaman Login yang Sesuai:
            //    - `if ($request->is('pasien/*'))`: Memeriksa apakah URL yang diakses dimulai dengan 'pasien/'.
            //      Contoh: `https://aplikasi.com/pasien/dashboard`
            if ($request->is('pasien/*')) {
                // Jika iya, arahkan pengguna ke rute login khusus pasien.
                return route('pasien.login');
            }
            //    - `elseif ($request->is('staf/*') || $request->is('rekam_medis/*') || $request->is('laboran/*'))`:
            //      Memeriksa apakah URL yang diakses dimulai dengan 'staf/', 'rekam_medis/', atau 'laboran/'.
            //      Contoh: `https://aplikasi.com/staf/dashboard`, `https://aplikasi.com/rekam_medis/pasien`, dll.
            elseif ($request->is('staf/*') || $request->is('rekam_medis/*') || $request->is('laboran/*')) {
                // Jika iya, arahkan pengguna ke rute login khusus staf.
                return route('staf.login');
            }

            // 3. Fallback (Pilihan Terakhir):
            //    - Jika URL yang diakses tidak cocok dengan pola 'pasien/*' atau pola staf,
            //      misalnya jika ada rute lain yang dilindungi, secara default akan diarahkan ke login staf.
            //      Anda bisa menggantinya ke `route('login')` jika ada halaman login umum.
            return route('staf.login');
        }

        // Jika permintaan adalah AJAX/JSON, kembalikan null agar Laravel bisa memberikan respons JSON 401.
        return null; // Penting: Middleware Authenticate Laravel akan mengembalikan JSON 401 jika null dan expectsJson().
    }
}
