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
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;



// Rute untuk URL root
Route::get('/', function () {
    // Cek apakah user Pasien sudah login
    if (Auth::guard('pasien')->check()) {
        $redirectUrl = route('pasien.dashboard');
    }
    // Cek apakah user Staf sudah login
    else if (Auth::guard('staf')->check()) { // Gunakan else if agar tidak bentrok
        // Sesuaikan dengan peran staf yang login
        $role = Auth::guard('staf')->user()->role;
        if ($role === 'laboran') {
            $redirectUrl = route('laboran.dashboard');
        } else if ($role === 'rekam-medis') {
            $redirectUrl = route('rekam-medis.dashboard');
        } else {
            // Default jika peran staf tidak dikenali
            $redirectUrl = route('staf.dashboard'); // Asumsi ada dashboard umum staf
        }
    } else {
        // Jika belum login, redirect ke halaman login pasien (default)
        $redirectUrl = route('pasien.login');
    }

    // === INI ADALAH PERUBAHAN YANG HARUS ANDA LAKUKAN ===
    return response()->noContent(303)->header('Location', $redirectUrl);
    // ====================================================

});
// =========================================================================
// RUTE PUBLIK & REDIRECT
// Dibuat oleh: Salma Aulia - 3312301096
// =========================================================================



// ======================= RUTE AUTENTIKASI (UNTUK TAMU / GUEST) =======================
// Middleware 'guest' memastikan rute ini hanya bisa diakses oleh pengguna yang belum login.
Route::middleware('guest')->group(function () {
    // Rute untuk Login Pasien
    Route::get('/pemohon/pasien/login', [LoginController::class, 'showPasienLoginForm'])->name('pasien.login');
    Route::post('/pemohon/pasien/login', [LoginController::class, 'loginPasien']); // Memproses submit form login pasien.

    // Rute untuk Login Staf (digunakan oleh Rekam Medis & Laboran)
    Route::get('/petugas/staf/login', [LoginController::class, 'showStafLoginForm'])->name('staf.login');
    Route::post('/petugas/staf/login', [LoginController::class, 'loginStaf']); // Memproses submit form login staf.
});

// =========================================================================
// RUTE PASIEN (SETELAH LOGIN)
// Dibuat oleh: Salma Aulia - 3312301096
// =========================================================================
// Rute-rute di grup ini hanya bisa diakses oleh pasien yang sudah login.
// - prefix('pemohon/pasien'): Semua rute di sini akan diawali dengan '/pemohon/pasien'.
// - name('pasien.'): Semua nama rute di sini akan diawali dengan 'pasien.'.
// - middleware(['auth:pasien', 'no.cache']):
//   - auth:pasien: Memastikan pengguna sudah login menggunakan guard 'pasien'.
//   - no.cache: Middleware kustom untuk mencegah caching halaman setelah logout (demi keamanan).
Route::prefix('pemohon/pasien')->name('pasien.')->middleware('auth:pasien')->group(function () {
    Route::get('/dashboard', [HasilUjiPasienController::class, 'dashboard'])->name('dashboard');
    Route::get('/hasil-uji', [HasilUjiPasienController::class, 'index'])->name('hasil-uji.index');
    Route::get('/hasil-uji/{hasilUjiTB}', [HasilUjiPasienController::class, 'show'])->name('hasil-uji.show');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


// =========================================================================
// RUTE UMUM STAF (SETELAH LOGIN)
// Dibuat oleh: Sultan Sadad - 3312301102
// =========================================================================
// Rute-rute di grup ini hanya bisa diakses oleh staf yang sudah login.
// - prefix('petugas/staf'): Semua rute di sini akan diawali dengan '/petugas/staf'.
// - name('staf.'): Semua nama rute di sini akan diawali dengan 'staf.'.
// - middleware('auth:staf'): Memastikan pengguna sudah login menggunakan guard 'staf'.
Route::prefix('petugas/staf')->name('staf.')->middleware('auth:staf')->group(function () {
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
// - prefix('petugas/rekam-medis'): Semua rute di sini akan diawali dengan '/petugas/rekam-medis'.
// - name('rekam-medis.'): Semua nama rute di sini akan diawali dengan 'rekam-medis.'.
// - middleware(['auth:staf', 'role.rekam_medis']):
//   - auth:staf: Memastikan pengguna sudah login sebagai staf.
//   - role.rekam_medis: Middleware kustom yang memastikan peran staf adalah 'rekam_medis'.
Route::prefix('petugas/rekam-medis')->name('rekam-medis.')->middleware(['auth:staf', 'role.rekam_medis'])->group(function () {
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
    Route::post('/pasien/{pasien}/verifikasi', [DataPasienController::class, 'verifikasi'])
        ->name('pasien.verifikasi');
});

// =========================================================================
// RUTE LABORAN
// Dibuat oleh: Sultan Sadad - 3312301102
// =========================================================================
// Rute-rute di grup ini hanya bisa diakses oleh staf dengan peran 'laboran'.
// - prefix('petugas/laboran'): Semua rute di sini akan diawali dengan '/petugas/laboran'.
// - name('laboran.'): Semua nama rute di sini akan diawali dengan 'laboran.'.
// - middleware(['auth:staf', 'role.laboran']):
//   - auth:staf: Memastikan pengguna sudah login sebagai staf.
//   - role.laboran: Middleware kustom yang memastikan peran staf adalah 'laboran'.
Route::prefix('petugas/laboran')->name('laboran.')->middleware(['auth:staf', 'role.laboran'])->group(function () {
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
    Route::get('/riwayat-hasil-uji', [HasilUjiLaboranController::class, 'riwayat'])
        ->name('hasil-uji.riwayat');
});

Route::get('/sitemap.xml', function () {
    // Path ke file sitemap.xml yang baru Anda buat di resources/sitemap.xml
    $sitemapPath = resource_path('sitemap.xml');

    if (!file_exists($sitemapPath)) {
        // Seharusnya tidak terjadi jika Anda sudah membuat filenya
        return Response::make('Sitemap not found', 404, ['Content-Type' => 'text/plain']);
    }

    $content = file_get_contents($sitemapPath);

    return Response::make($content, 200, [
        'Content-Type' => 'application/xml'
    ]);
});


Route::get('/robots.txt', function () {
    // Path ke file robots.txt Anda yang sekarang di resources/
    $robotsPath = resource_path('robots.txt');

    if (!file_exists($robotsPath)) {
        return Response::make('Robots.txt not found', 404, ['Content-Type' => 'text/plain']);
    }

    $content = file_get_contents($robotsPath);
    return Response::make($content, 200, [
        'Content-Type' => 'text/plain',
    ]);
});