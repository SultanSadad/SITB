<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Pasien\PasienController;
use App\Http\Controllers\Staf\StafController;
use App\Http\Controllers\HasilUji\HasilUjiTBController;
use App\Http\Controllers\RekamMedis\HasilUjiRekamController;
use App\Http\Controllers\RekamMedis\DashboardController as RekamDashboardController;
use App\Http\Controllers\Laboran\LaboranDashboardController;
use App\Http\Controllers\Laboran\LaboranController;

// Halaman Home Default
Route::get('/home', function () {
    return view('welcome');
})->name('home');

// ======================= PASIEN ROUTES =======================
Route::prefix('pasien')->name('pasien.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showPasienLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'loginPasien']);
    });

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('pasien.dashboard_pasien');
        })->name('dashboard');

        Route::get('/hasil-uji', function () {
            return view('pasien.hasil_uji');
        })->name('hasil_uji');

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});

// ======================= STAF ROUTES =======================
Route::prefix('staf')->name('staf.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showStafLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'loginStaf']);
    });

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('staf.dashboard');
        })->name('dashboard');

        Route::get('/hasil-uji', [LaboranController::class, 'index'])->name('hasil-uji');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});

// ======================= REKAM MEDIS ROUTES =======================
Route::prefix('rekam-medis')->name('rekam-medis.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [RekamDashboardController::class, 'index'])->name('dashboard');
    Route::get('/hasil-uji', [HasilUjiRekamController::class, 'index'])->name('hasil-uji.index');
    Route::get('/detail/{pasienId}', [HasilUjiTBController::class, 'showByPasienRekamMedis'])->name('detail');

    // Menambahkan route untuk data pasien dan staf sesuai dengan yang ada di sidebar
    Route::get('/data-pasien', [PasienController::class, 'index'])->name('data-pasien');
    Route::get('/data-staf', [StafController::class, 'index'])->name('data-staf');
    Route::get('/datahasiluji', [HasilUjiRekamController::class, 'index'])->name('datahasiluji');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// ======================= LABORAN ROUTES =======================
Route::prefix('laboran')->name('laboran.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [LaboranDashboardController::class, 'index'])->name('dashboard');
    Route::get('/data-pasien', function () {
        return view('laboran.data_pasien');
    })->name('data-pasien');
    Route::get('/hasil-uji', [HasilUjiTBController::class, 'indexLaboran'])->name('hasil-uji');
    Route::get('/detail/{pasienId}', [HasilUjiTBController::class, 'showByPasien'])->name('detail');
    Route::get('/DataHasilUji', [HasilUjiTBController::class, 'semuaHasilUji'])->name('data-hasil-uji');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// ======================= HASIL UJI ROUTES (Umum) =======================
Route::get('/hasil-uji', [HasilUjiTBController::class, 'index']);
Route::delete('/hasil-uji/{id}', [HasilUjiTBController::class, 'destroy'])->name('hasil-uji.destroy');
Route::post('/pasien/{pasien}/hasil-uji', [HasilUjiTBController::class, 'store'])->name('hasil-uji.store');

// ======================= DATA & SEARCH =======================
Route::resource('pasiens', PasienController::class);
Route::resource('stafs', StafController::class);

Route::get('/rekam_medis/data-staf', [StafController::class, 'index'])->name('data-staf');
Route::get('/rekam_medis/data-pasien', [PasienController::class, 'index'])->name('data-pasien');

Route::get('/search/pasien', [PasienController::class, 'searchPasien'])->name('search.pasien');
Route::get('/search/staf', [StafController::class, 'searchStaf'])->name('search.staf');

// ======================= GLOBAL LOGOUT (Fallback) =======================
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/stafs/{staf}/edit-data', [App\Http\Controllers\Staf\StafController::class, 'getEditData'])
    ->name('stafs.edit-data');
    Route::post('/stafs', [StafController::class, 'store'])->name('stafs.store');
