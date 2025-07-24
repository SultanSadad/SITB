<?php

// Nama File   = Kernel.php
// Deskripsi   = File ini adalah "inti" (kernel) dari aplikasi.
//               Di sini Anda mendaftarkan semua middleware HTTP global, grup middleware,
//               dan alias middleware. Middleware adalah "filter" yang memproses permintaan HTTP
//               yang masuk dan respons HTTP yang keluar, sebelum atau sesudah diproses oleh controller.
// Dibuat oleh = Salma - 3312301096
// Tanggal     = 1 April 2025

namespace App\Http;

// Menentukan lokasi (namespace) dari file Kernel ini.

// Import kelas dasar HttpKernel dari Laravel.
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * $middleware
     *
     * *Tujuan:* Daftar tumpukan middleware HTTP global aplikasi.
     * Middleware yang terdaftar di sini akan dijalankan pada *SETIAP* permintaan HTTP yang masuk ke aplikasi Anda.
     * Ini ideal untuk tugas-tugas umum seperti penanganan CORS, validasi ukuran POST, atau trim string.
     *
     * @var array<int, class-string|string> Daftar kelas middleware global.
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class, // Digunakan untuk mengamankan aplikasi dari serangan Host Header.
        \App\Http\Middleware\TrustProxies::class, // Mengatur server proxy tepercaya untuk penanganan header permintaan.
        \Illuminate\Http\Middleware\HandleCors::class,
        // Menangani Cross-Origin Resource Sharing (CORS) untuk memungkinkan permintaan lintas domain.
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        // Mengalihkan semua permintaan ke halaman mode pemeliharaan jika aplikasi sedang dalam mode tersebut.
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        // Memeriksa ukuran data POST agar tidak melebihi batas yang ditentukan.
        \App\Http\Middleware\TrimStrings::class, // Memotong spasi di awal dan akhir string pada input permintaan.
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        // Mengubah string kosong di input permintaan menjadi nilai null.
    ];

    /**
     * $middlewareGroups
     *
     * *Tujuan:* Grup-grup middleware aplikasi.
     * Middleware di sini dikelompokkan dan bisa diterapkan ke beberapa rute sekaligus.
     * Contohnya, grup 'web' biasanya diterapkan ke semua rute berbasis web, sementara 'api' ke rute API.
     *
     * @var array<string, array<int, class-string|string>> Daftar grup middleware.
     */
    protected $middlewareGroups = [
        'web' => [ // Grup middleware untuk rute berbasis web (seperti halaman web biasa).
            \App\Http\Middleware\EncryptCookies::class, // Mengenkripsi cookie untuk keamanan.
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            // Menambahkan cookie yang antre ke respons HTTP.
            \Illuminate\Session\Middleware\StartSession::class,
            // Memulai atau melanjutkan sesi HTTP untuk setiap permintaan.
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // Membagikan pesan error validasi dari sesi ke semua tampilan.
            \App\Http\Middleware\VerifyCsrfToken::class,
            // Memverifikasi token CSRF untuk melindungi dari serangan Cross-Site Request Forgery.
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // Mengganti wildcard di rute dengan instance model yang sesuai (Route Model Binding).
        ],

        'api' => [ // Grup middleware untuk rute API (biasanya untuk aplikasi mobile atau frontend JavaScript).
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            // Digunakan oleh Laravel Sanctum untuk SPA/Mobile API.
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
            // Membatasi jumlah permintaan API dalam periode waktu tertentu (rate limiting).
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // Mengganti wildcard di rute dengan instance model yang sesuai (Route Model Binding).
        ],
    ];

    /**
     * $middlewareAliases
     *
     * *Tujuan:* Alias untuk middleware.
     * Alias memungkinkan Anda menggunakan nama yang lebih pendek dan mudah diingat (seperti 'auth' atau 'guest')
     * daripada menulis nama kelas middleware lengkap saat menetapkannya ke rute atau grup rute.
     *
     * @var array<string, class-string|string> Daftar alias middleware.
     */
    protected $middlewareAliases = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class, // Memastikan pengguna terautentikasi (sudah login).
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class, // Otentikasi dasar HTTP.
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class, // Memastikan sesi pengguna valid.
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class, // Menetapkan header caching HTTP.
        'can' => \Illuminate\Auth\Middleware\Authorize::class, // Memverifikasi apakah pengguna memiliki izin tertentu.
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        // Mengalihkan pengguna yang sudah login dari halaman tamu (misal: login, register).
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        // Meminta konfirmasi password sebelum mengakses rute sensitif.
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        // Menangani permintaan precognitive (untuk validasi real-time).
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        // Memverifikasi apakah URL yang diakses memiliki tanda tangan (signature) yang valid.
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        // Membatasi jumlah permintaan untuk mencegah brute-force atau spam.
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        // Memastikan email pengguna sudah diverifikasi.
        'userAkses' => \App\Http\Middleware\UserAkses::class,
        // Middleware kustom untuk mengelola akses pengguna (belum dijelaskan detailnya di sini).

        // Alias middleware peran kustom Anda.
        'role.rekam_medis' => \App\Http\Middleware\PastikanPeranRekamMedis::class,
        // Middleware kustom: Memastikan pengguna adalah staf 'rekam_medis'.
        'role.laboran' => \App\Http\Middleware\PastikanPeranLaboran::class,
        // Middleware kustom: Memastikan pengguna adalah staf 'laboran'.
        'no.cache' => \App\Http\Middleware\NoCacheAfterLogout::class,
        // Middleware kustom: Mencegah caching halaman di browser (biasanya setelah logout).
    ];
}
