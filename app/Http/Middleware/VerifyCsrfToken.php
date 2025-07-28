<?php

// Nama File   = VerifyCsrfToken.php
// Deskripsi   = Middleware ini bertanggung jawab untuk memverifikasi token CSRF (Cross-Site Request Forgery)
//               pada setiap permintaan POST, PUT, PATCH, atau DELETE yang masuk.
//               Token CSRF adalah mekanisme keamanan untuk melindungi aplikasi web dari serangan CSRF.
//               File ini juga mendefinisikan rute-rute (URI) yang dikecualikan dari verifikasi CSRF.
// Dibuat oleh = Sultan Sadad - 3312301102
// Tanggal     = 16 Juli 2025

namespace App\Http\Middleware;

// Menentukan lokasi (namespace) dari middleware ini.

// Import kelas dasar VerifyCsrfToken dari Laravel.
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * $except
     *
     * *Tujuan:* Daftar URI (Uniform Resource Identifiers) yang harus *dikecualikan* dari verifikasi CSRF.
     * Artinya, untuk rute-rute yang ada di dalam array ini, Laravel tidak akan memeriksa token CSRF.
     * Ini biasanya digunakan untuk:
     * 1. *Endpoint API publik* yang mungkin diakses oleh aplikasi eksternal
     *    (meskipun lebih baik menggunakan API token).
     * 2. *Rute-rute login* di mana token CSRF mungkin belum tersedia atau penanganannya berbeda.
     * 3. *Webhook* dari layanan eksternal.
     *
     * *Peringatan:* Mengecualikan rute dari verifikasi CSRF bisa menjadi risiko keamanan
     * jika tidak dilakukan dengan hati-hati.
     * Pastikan Anda memahami implikasinya dan memiliki perlindungan alternatif jika diperlukan.
     *
     * @var array<int, string> Daftar URI yang dikecualikan.
     */
    protected $except = [
        // Rute login untuk staf dikecualikan. (Umumnya form login tidak memerlukan CSRF token)
        'petugas/staf/login',
        // Rute login untuk pasien dikecualikan.
        'pemohon/pasien/login',
        // Rute '/pasiens' dikecualikan. Pastikan ini adalah API endpoint atau rute yang memang tidak memerlukan CSRF.
        '/pasiens',
        // Rute '/rekam-medis/data-staf' dikecualikan. Periksa apakah ini route untuk form yang di-submit via AJAX
        // tanpa token CSRF atau endpoint API.
        '/rekam-medis/data-staf',
        // Rute 'laboran/data-pasien' dikecualikan. Sama seperti di atas, pastikan alasannya jelas.
        'laboran/data-pasien',
        'rekam-medis/pasien/*/verifikasi',
        'rekam-medis/data-pasien/*',
        // Contoh lain: Jika Anda ingin mengecualikan semua rute di bawah prefix 'rekam-medis',
        // Anda bisa menggunakan wildcard:
        // '/rekam-medis/*',// Ini akan mengecualikan semua rute
        // /rekam-medis/dashboard, /rekam-medis/pasien, dll.
                           // Gunakan dengan sangat hati-hati karena ini bisa menurunkan keamanan.
    ];
}
