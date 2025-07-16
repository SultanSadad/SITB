<?php

// Nama File   = web.php
// Deskripsi   = File ini mendefinisikan semua rute web (URL) aplikasi Laravel Anda.
//               Setiap rute mengarahkan permintaan HTTP ke controller dan metode tertentu
//               untuk memproses logika aplikasi. Ini adalah "peta" navigasi aplikasi.
// Dibuat oleh = Salma Aulia - 3312301096 (untuk bagian login/autentikasi)
//               Sultan Sadad - 3312301102 (untuk bagian manajemen data dan dashboard lainnya)
// Tanggal     = 1 Maret 2025

use Illuminate\Support\Facades\Route; // Mengimpor Facade Route untuk mendefinisikan rute.
use App\Http\Controllers\LoginController; // Mengimpor LoginController.
use App\Http\Controllers\Pemohon\HasilUjiPasienController; // Mengimpor HasilUjiPasienController.
use App\Http\Controllers\Petugas\Laboran\DashboardLaboranController; // Mengimpor DashboardLaboranController.
use App\Http\Controllers\Petugas\Laboran\DataPasienLaboranController; // Mengimpor DataPasienLaboranController.
use App\Http\Controllers\Petugas\Laboran\HasilUjiLaboranController; // Mengimpor HasilUjiLaboranController.
use App\Http\Controllers\Petugas\RekamMedis\DashboardRekamMedisController; // Mengimpor DashboardRekamMedisController.
use App\Http\Controllers\Petugas\RekamMedis\DataPasienController; // Mengimpor DataPasienController (untuk Rekam Medis).
use App\Http\Controllers\Petugas\RekamMedis\DataStafController; // Mengimpor DataStafController.
use App\Http\Controllers\Petugas\RekamMedis\HasilUjiRekamMedisController; // Mengimpor HasilUjiRekamMedisController.
use Illuminate\Http\Request; // Mengimpor kelas Request.
use App\Models\Pasien; // Mengimpor model Pasien.


// =========================================================================
// RUTE PUBLIK & REDIRECT
// Dibuat oleh: Salma Aulia - 3312301096
// =========================================================================



// ======================= RUTE AUTENTIKASI (UNTUK TAMU / GUEST) =======================
// Middleware 'guest' memastikan rute ini hanya bisa diakses oleh pengguna yang belum login.
Route::middleware('guest')->group(function () {
    // Rute untuk Login Pasien
    Route::get('/pasien/login', [LoginController::class, 'showPasienLoginForm'])->name('pasien.login');
    Route::post('/pasien/login', [LoginController::class, 'loginPasien']); // Memproses submit form login pasien.

    // Rute untuk Login Staf (digunakan oleh Rekam Medis & Laboran)
    Route::get('/staf/login', [LoginController::class, 'showStafLoginForm'])->name('staf.login');
    Route::post('/staf/login', [LoginController::class, 'loginStaf']); // Memproses submit form login staf.
});

// =========================================================================
// RUTE PASIEN (SETELAH LOGIN)
// Dibuat oleh: Salma Aulia - 3312301096
// =========================================================================
// Rute-rute di grup ini hanya bisa diakses oleh pasien yang sudah login.
// - `prefix('pasien')`: Semua rute di sini akan diawali dengan '/pasien'.
// - `name('pasien.')`: Semua nama rute di sini akan diawali dengan 'pasien.'.
// - `middleware(['auth:pasien', 'no.cache'])`:
//   - `auth:pasien`: Memastikan pengguna sudah login menggunakan guard 'pasien'.
//   - `no.cache`: Middleware kustom untuk mencegah caching halaman setelah logout (demi keamanan).
Route::prefix('pasien')->name('pasien.')->middleware(['auth:pasien', 'no.cache'])->group(function () {
    Route::get('/dashboard', [HasilUjiPasienController::class, 'dashboard'])->name('dashboard'); // Menampilkan dashboard pasien.
    Route::get('/hasil-uji', [HasilUjiPasienController::class, 'index'])->name('hasil-uji.index'); // Menampilkan daftar hasil uji pasien.
    Route::get('/hasil-uji/{hasilUjiTB}', [HasilUjiPasienController::class, 'show'])->name('hasil-uji.show'); // Menampilkan detail satu hasil uji.
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); // Rute untuk proses logout pasien.
});

// =========================================================================
// RUTE UMUM STAF (SETELAH LOGIN)
// Dibuat oleh: Sultan Sadad - 3312301102
// =========================================================================
// Rute-rute di grup ini hanya bisa diakses oleh staf yang sudah login.
// - `prefix('staf')`: Semua rute di sini akan diawali dengan '/staf'.
// - `name('staf.')`: Semua nama rute di sini akan diawali dengan 'staf.'.
// - `middleware('auth:staf')`: Memastikan pengguna sudah login menggunakan guard 'staf'.
Route::prefix('staf')->name('staf.')->middleware('auth:staf')->group(function () {
    // Dashboard umum untuk staf jika diperlukan (saat ini hanya mengembalikan view).
    Route::get('/dashboard', fn() => view('staf.dashboard'))->name('dashboard');
    // Rute untuk proses logout staf.
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// =========================================================================
// RUTE REKAM MEDIS
// Dibuat oleh: Sultan Sadad - 3312301102
// =========================================================================
// Rute-rute di grup ini hanya bisa diakses oleh staf dengan peran 'rekam_medis'.
// - `prefix('rekam-medis')`: Semua rute di sini akan diawali dengan '/rekam-medis'.
// - `name('rekam-medis.')`: Semua nama rute di sini akan diawali dengan 'rekam-medis.'.
// - `middleware(['auth:staf', 'role.rekam_medis'])`:
//   - `auth:staf`: Memastikan pengguna sudah login sebagai staf.
//   - `role.rekam_medis`: Middleware kustom yang memastikan peran staf adalah 'rekam_medis'.
Route::prefix('rekam-medis')->name('rekam-medis.')->middleware(['auth:staf', 'role.rekam_medis'])->group(function () {
    Route::get('/dashboard', [DashboardRekamMedisController::class, 'index'])->name('dashboard'); // Menampilkan dashboard rekam medis.

    // Manajemen Data Staf (oleh Rekam Medis)
    Route::get('/data-staf', [DataStafController::class, 'index'])->name('staf.index'); // Menampilkan daftar staf.
    Route::post('/data-staf', [DataStafController::class, 'store'])->name('staf.store'); // Menyimpan staf baru.
    Route::put('/data-staf/{staf}', [DataStafController::class, 'update'])->name('staf.update'); // Memperbarui data staf.
    Route::delete('/data-staf/{staf}', [DataStafController::class, 'destroy'])->name('staf.destroy'); // Menghapus staf.
    Route::get('/data-staf/{staf}/edit-data', [DataStafController::class, 'editData'])->name('staf.edit-data'); // Mengambil data staf untuk form edit (biasanya AJAX).
    Route::get('/search/staf', [DataStafController::class, 'searchStaf'])->name('staf.search'); // Mencari staf (biasanya via AJAX).

    // Manajemen Data Pasien (oleh Rekam Medis)
    Route::get('/data-pasien', [DataPasienController::class, 'index'])->name('pasien.index'); // Menampilkan daftar pasien.
    Route::post('/data-pasien', [DataPasienController::class, 'store'])->name('pasien.store'); // Menyimpan pasien baru.
    Route::put('/data-pasien/{pasien}', [DataPasienController::class, 'update'])->name('pasien.update'); // Memperbarui data pasien.
    Route::delete('/data-pasien/{pasien}', [DataPasienController::class, 'destroy'])->name('pasien.destroy'); // Menghapus pasien.
    Route::get('/search/pasien', [DataPasienController::class, 'searchPasien'])->name('pasien.search'); // Mencari pasien (biasanya via AJAX).

    // Melihat & Mengelola Hasil Uji (oleh Rekam Medis)
    Route::get('/hasil-uji', [HasilUjiRekamMedisController::class, 'index'])->name('hasil-uji.index'); // Menampilkan hasil uji terbaru per pasien.
    Route::get('/datahasiluji', [HasilUjiRekamMedisController::class, 'indexDataHasilUji'])->name('hasil-uji.data'); // Menampilkan semua riwayat hasil uji.
    Route::get('/detail/{pasienId}', [HasilUjiRekamMedisController::class, 'show'])->name('hasil-uji.show'); // Menampilkan detail hasil uji satu pasien.

    // Verifikasi Pasien (Endpoint AJAX)
    // Rute ini langsung menangani update verifikasi pasien.
    Route::post('/pasien/{id}/verifikasi', function ($id, Request $request) {
        Pasien::findOrFail($id)->update(['verifikasi' => $request->verifikasi ? 1 : 0]);
        return response()->json(['success' => true]);
    })->name('pasien.verifikasi');
});

// =========================================================================
// RUTE LABORAN
// Dibuat oleh: Sultan Sadad - 3312301102
// =========================================================================
// Rute-rute di grup ini hanya bisa diakses oleh staf dengan peran 'laboran'.
// - `prefix('laboran')`: Semua rute di sini akan diawali dengan '/laboran'.
// - `name('laboran.')`: Semua nama rute di sini akan diawali dengan 'laboran.'.
// - `middleware(['auth:staf', 'role.laboran'])`:
//   - `auth:staf`: Memastikan pengguna sudah login sebagai staf.
//   - `role.laboran`: Middleware kustom yang memastikan peran staf adalah 'laboran'.
Route::prefix('laboran')->name('laboran.')->middleware(['auth:staf', 'role.laboran'])->group(function () {
    Route::get('/dashboard', [DashboardLaboranController::class, 'index'])->name('dashboard'); // Menampilkan dashboard laboran.

    // Manajemen Data Pasien (oleh Laboran)
    Route::get('/data-pasien', [DataPasienLaboranController::class, 'index'])->name('pasien.index'); // Menampilkan daftar pasien.
    Route::post('/data-pasien', [DataPasienLaboranController::class, 'store'])->name('pasien.store'); // Menyimpan pasien baru.
    Route::put('/data-pasien/{pasien}', [DataPasienLaboranController::class, 'update'])->name('pasien.update'); // Memperbarui data pasien.
    Route::delete('/data-pasien/{pasien}', [DataPasienLaboranController::class, 'destroy'])->name('pasien.destroy'); // Menghapus pasien.

    // Manajemen Hasil Uji (oleh Laboran)
    Route::get('/hasil-uji', [HasilUjiLaboranController::class, 'index'])->name('hasil-uji.index'); // Menampilkan daftar hasil uji.
    Route::post('/hasil-uji/{pasienId}', [HasilUjiLaboranController::class, 'store'])->name('hasil-uji.store'); // Menyimpan hasil uji baru untuk pasien tertentu.
    Route::delete('/hasil-uji/{id}', [HasilUjiLaboranController::class, 'destroy'])->name('hasil-uji.destroy'); // Menghapus hasil uji.
    Route::get('/detail/{pasienId}', [HasilUjiLaboranController::class, 'show'])->name('hasil-uji.show'); // Menampilkan detail hasil uji satu pasien.
    Route::get('/riwayat-hasil-uji', [HasilUjiLaboranController::class, 'semuaHasilUji'])->name('hasil-uji.riwayat'); // Menampilkan semua riwayat hasil uji.
});