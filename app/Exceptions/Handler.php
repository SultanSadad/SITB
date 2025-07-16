<?php
// Nama File   = handler.php 
// Deskripsi   = File ini bertanggung jawab untuk menangani semua error (exception) yang terjadi di aplikasi Laravel.
//               Secara khusus, file ini mengelola bagaimana aplikasi merespons ketika pengguna tidak terautentikasi (belum login)
//               dengan mengarahkan mereka ke halaman login yang sesuai (pasien, staf, atau umum).
// Dibuat oleh = Salma Aulia - 3312301096
// Tanggal     = 1 April 2025
namespace App\Exceptions;

// Ini adalah kelas dasar untuk menangani error (exception) di Laravel.
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
// Ini khusus untuk menangani error saat pengguna tidak terautentikasi (belum login).
use Illuminate\Auth\AuthenticationException;
// Ini adalah tipe dasar untuk semua error atau masalah yang bisa terjadi.
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * **register()**
     *
     * Fungsi ini untuk mendaftarkan bagaimana kita ingin melaporkan error yang terjadi.
     * Saat ini, isinya masih kosong, jadi error akan dilaporkan secara standar oleh Laravel.
     * Kita bisa tambahkan logika di sini, misalnya kirim notifikasi error ke email.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Kita bisa tambahkan kode di sini untuk melaporkan error.
            // Contoh: Log::error('Ada error: ' . $e->getMessage());
        });
    }

    /**
     * **unauthenticated()**
     *
     * Fungsi ini akan otomatis dijalankan ketika ada pengguna yang mencoba mengakses
     * halaman yang butuh login, tapi dia belum login atau sesi loginnya sudah habis.
     * Fungsinya untuk mengarahkan pengguna ke halaman login yang sesuai.
     *
     * @param  \Illuminate\Http\Request  $request Objek request yang sedang berjalan.
     * @param  \Illuminate\Auth\AuthenticationException  $exception Objek error autentikasi.
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Cek apakah yang belum login itu pengguna dengan 'guard' (sistem login) 'staf'.
        // Jika iya, arahkan ke halaman login staf.
        if (in_array('staf', $exception->guards())) {
            return redirect()->guest(route('staf.login'));
        }

        // Cek apakah yang belum login itu pengguna dengan 'guard' 'pasien'.
        // Jika iya, arahkan ke halaman login pasien.
        if (in_array('pasien', $exception->guards())) {
            return redirect()->guest(route('pasien.login'));
        }

        // Kalau bukan staf atau pasien, arahkan ke halaman login standar aplikasi.
        return redirect()->guest(route('login'));
    }
}