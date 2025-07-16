<?php

// Nama File   = auth.php
// Deskripsi   = File konfigurasi ini mengatur cara aplikasi Laravel Anda melakukan autentikasi (login)
//               pengguna. Ini mendefinisikan "guards" (cara otentikasi), "providers" (sumber data pengguna),
//               dan pengaturan reset password.
// Dibuat oleh = Salma Aulia - 3312301096
// Tanggal     = 1 Maret 2025

return [

    /**
     * 'defaults'
     *
     * **Tujuan:** Mendefinisikan guard dan provider default yang akan digunakan oleh Laravel
     * jika tidak ada guard atau provider spesifik yang disebutkan.
     */
    'defaults' => [
        'guard' => 'web',     // Guard default yang digunakan.
        'passwords' => 'users', // Provider default untuk reset password.
    ],

    /**
     * 'guards'
     *
     * **Tujuan:** Mendefinisikan "guard" otentikasi. Guard menentukan bagaimana pengguna diautentikasi
     * untuk setiap permintaan. Laravel mengirimkan permintaan melalui guard ini.
     *
     * Setiap guard memiliki:
     * - 'driver': Metode otentikasi (misal: 'session' untuk login berbasis sesi web, 'token' untuk API).
     * - 'provider': Sumber data pengguna yang akan diautentikasi oleh guard ini.
     */
    'guards' => [
        'web' => [ // Guard 'web' adalah guard default untuk aplikasi berbasis sesi web.
            'driver' => 'session',
            'provider' => 'users', // Menggunakan provider 'users' (model App\Models\User).
        ],

        'staf' => [ // Guard 'staf' khusus untuk otentikasi pengguna staf.
            'driver' => 'session',
            'provider' => 'staf', // Menggunakan provider 'staf' (model App\Models\Staf).
        ],

        // =======================================================
        // Guard 'pasien' yang hilang telah ditambahkan di sini.
        // =======================================================
        'pasien' => [ // Guard 'pasien' khusus untuk otentikasi pengguna pasien.
            'driver' => 'session',
            'provider' => 'pasiens', // Menggunakan provider 'pasiens' (model App\Models\Pasien).
        ],

    ],

    /**
     * 'providers'
     *
     * **Tujuan:** Mendefinisikan "provider" otentikasi. Provider menentukan bagaimana pengguna dimuat
     * dari penyimpanan persisten (biasanya database). Ini menghubungkan guard dengan model Eloquent Anda.
     *
     * Setiap provider memiliki:
     * - 'driver': Tipe provider (misal: 'eloquent' untuk database dengan model Eloquent).
     * - 'model': Kelas model Eloquent yang mewakili pengguna.
     */
    'providers' => [
        'users' => [ // Provider 'users' untuk model App\Models\User.
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'pasiens' => [ // Provider 'pasiens' untuk model App\Models\Pasien.
            'driver' => 'eloquent',
            'model' => App\Models\Pasien::class,
        ],
        'staf' => [ // Provider 'staf' untuk model App\Models\Staf.
            'driver' => 'eloquent',
            'model' => App\Models\Staf::class,
        ],
    ],

    /**
     * 'passwords'
     *
     * **Tujuan:** Mendefinisikan konfigurasi untuk fitur reset password.
     *
     * Setiap konfigurasi password memiliki:
     * - 'provider': Provider pengguna yang akan mereset password.
     * - 'table': Tabel di database yang menyimpan token reset password.
     * - 'expire': Waktu (dalam menit) token reset password berlaku.
     * - 'throttle': Batasan berapa kali pengguna bisa mencoba mereset password dalam satu menit.
     */
    'passwords' => [
        'users' => [ // Konfigurasi reset password untuk provider 'users'.
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        // Anda bisa menambahkan konfigurasi 'passwords' untuk staf jika Anda ingin
        // mengimplementasikan fitur reset password untuk pengguna staf.
        'staf' => [ // Konfigurasi reset password untuk provider 'staf'.
            'provider' => 'staf',
            'table' => 'password_reset_tokens', // Tabel yang sama atau tabel terpisah bisa digunakan.
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /**
     * 'password_timeout'
     *
     * **Tujuan:** Waktu timeout (dalam detik) setelah pengguna harus memasukkan kembali password mereka
     * saat mengakses rute yang dilindungi oleh middleware `password.confirm`.
     */
    'password_timeout' => 10800, // 3 jam (10800 detik).

];