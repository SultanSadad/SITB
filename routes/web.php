<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Pemohon\HasilUjiPasienController;
use App\Http\Controllers\Petugas\Laboran\DashboardLaboranController;
use App\Http\Controllers\Petugas\Laboran\DataPasienLaboranController;
use App\Http\Controllers\Petugas\Laboran\HasilUjiLaboranController;
use App\Http\Controllers\Petugas\RekamMedis\DashboardRekamMedisController;
use App\Http\Controllers\Petugas\RekamMedis\DataPasienController;
use App\Http\Controllers\Petugas\RekamMedis\DataStafController;
use App\Http\Controllers\Petugas\RekamMedis\HasilUjiRekamMedisController;

// Halaman Home Default
Route::get('/debug-php', function () {
    return phpinfo();
});
Route::get('/', function () {
    return redirect()->route('pasien.login');
});

Route::get('/home', function () {
    return view('welcome');
})->name('home');

// ======================= PASIEN ROUTES =======================
// Grup route untuk pasien, menggunakan prefix '/pasien' dan name route 'pasien.'
Route::prefix('pasien')->name('pasien.')->group(function () {

    // Route untuk user yang belum login
    Route::middleware('guest')->group(function () {
        // Tampilkan form login pasien
        Route::get('/login', [LoginController::class, 'showPasienLoginForm'])->name('login');
        // Proses login pasien
        Route::post('/login', [LoginController::class, 'loginPasien']);
    });

    // Route untuk pasien yang sudah login
    Route::middleware('auth')->group(function () {
        // Dashboard pasien setelah login
        Route::get('/dashboard', [HasilUjiPasienController::class, 'dashboard'])->name('dashboard');
        // Tampilkan daftar hasil uji pasien
        Route::get('/hasil-uji', [HasilUjiPasienController::class, 'index'])->name('hasil_uji');
        // Logout pasien
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});


// ======================= STAF ROUTES =======================
Route::prefix('staf')->name('staf.')->group(function () {
    // Guest route (belum login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showStafLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'loginStaf']);
    });

    // Route setelah staf login
    Route::middleware('auth')->group(function () {
        // Dashboard staf default (halaman view statis)
        Route::get('/dashboard', function () {
            return view('staf.dashboard');
        })->name('dashboard');
        // Logout staf
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});


// ======================= REKAM MEDIS ROUTES =======================
Route::prefix('rekam-medis')->name('rekam-medis.')
    ->middleware(['auth', 'role.rekam_medis']) // Hanya untuk user role 'rekam_medis'
    ->group(function () {

        // Dashboard Rekam Medis
        Route::get('/dashboard', [DashboardRekamMedisController::class, 'index'])->name('dashboard');

        // Tampilkan hasil uji terbaru per pasien (hasil_uji.blade.php)
        Route::get('/hasil-uji', [HasilUjiRekamMedisController::class, 'index'])->name('hasil-uji');

        // Tampilkan riwayat hasil uji seluruh pasien (riwayat_hasil_uji.blade.php)
        Route::get('/datahasiluji', [HasilUjiRekamMedisController::class, 'indexDataHasilUji'])->name('datahasiluji');

        // Hapus hasil uji
        Route::delete('/hasil-uji/{id}', [HasilUjiRekamMedisController::class, 'destroy'])->name('hasil-uji.destroy');

        // Lihat detail hasil uji milik 1 pasien
        Route::get('/detail/{pasienId}', [HasilUjiRekamMedisController::class, 'show'])->name('detail');

        // Halaman data pasien
        Route::get('/data-pasien', [DataPasienController::class, 'index'])->name('data-pasien');

        // Halaman data staf
        Route::get('/data-staf', [DataStafController::class, 'index'])->name('data-staf');

        // Logout user rekam medis
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });



// ======================= LABORAN ROUTES =======================
Route::prefix('laboran')->name('laboran.')
    ->middleware(['auth', 'role.laboran']) // Khusus user dengan role 'laboran'
    ->group(function () {

        // Dashboard Laboran
        Route::get('/dashboard', [DashboardLaboranController::class, 'index'])->name('dashboard');

        // CRUD Data Pasien
        Route::get('/data-pasien', [DataPasienLaboranController::class, 'index'])->name('data-pasien');
        Route::post('/data-pasien', [DataPasienLaboranController::class, 'store'])->name('data-pasien.store');
        Route::put('/data-pasien/{pasien}', [DataPasienLaboranController::class, 'update'])->name('data-pasien.update');
        Route::delete('/data-pasien/{pasien}', [DataPasienLaboranController::class, 'destroy'])->name('data-pasien.destroy');

        // CRUD Hasil Uji
        Route::get('/hasil-uji', [HasilUjiLaboranController::class, 'index'])->name('hasil-uji');
        Route::post('/hasil-uji/{pasienId}', [HasilUjiLaboranController::class, 'store'])->name('hasil-uji.store');
        Route::delete('/hasil-uji/{id}', [HasilUjiLaboranController::class, 'destroy'])->name('hasil-uji.destroy');
        Route::get('/detail/{pasienId}', [HasilUjiLaboranController::class, 'show'])->name('detail');
        Route::get('/riwayat-hasil-uji', [HasilUjiLaboranController::class, 'semuaHasilUji'])->name('riwayat-hasil-uji');

        // Logout laboran
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });


// ======================= DATA & SEARCH =======================
Route::resource('pasiens', DataPasienController::class);

// CRUD data staf (khusus user auth, biasanya rekam medis)
Route::prefix('rekam-medis')->name('rekam-medis.stafs.')->middleware('auth')->group(function () {
    Route::get('/data-staf', [DataStafController::class, 'index'])->name('index');
    Route::post('/data-staf', [DataStafController::class, 'store'])->name('store');
    Route::put('/data-staf/{staf}', [DataStafController::class, 'update'])->name('update');
    Route::delete('/data-staf/{staf}', [DataStafController::class, 'destroy'])->name('destroy');
});

// Route tambahan (sebaiknya hapus jika redundan)
Route::get('/rekam_medis/data-pasien', [DataPasienController::class, 'index'])->name('data-pasien');

// AJAX: pencarian pasien (live search/autocomplete)
Route::get('/search/pasien', [DataPasienController::class, 'searchPasien'])->name('search.pasien');

// AJAX: pencarian staf
Route::get('/search/staf', [DataStafController::class, 'searchStaf'])->name('search.staf');

// AJAX: ambil data staf untuk modal edit
Route::get('/rekam-medis/data-staf/{staf}/edit-data', [DataStafController::class, 'editData'])
    ->name('rekam-medis.stafs.edit-data');


use Illuminate\Http\Request;
use App\Models\Pasien;

// Route untuk mengubah status verifikasi pasien (dipakai oleh checkbox)
Route::post('/pasien/{id}/verifikasi', function ($id, Request $request) {
    $pasien = Pasien::findOrFail($id);
    $pasien->verifikasi = $request->verifikasi ? 1 : 0;
    $pasien->save();

    return response()->json(['success' => true]);
})->name('pasien.verifikasi');