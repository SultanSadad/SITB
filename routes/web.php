<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasienLoginController;
use App\Http\Controllers\Pasien\PasienController;
use App\Http\Controllers\Staf\StafController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/home', function () {
    return view('welcome');
});

// ---------------------------
// Rekam Medis Pages
// ---------------------------

Route::prefix('rekam_medis')->group(function () {
    Route::get('/dashboard', function () {
        return view('rekam_medis.dashboard');
    });

    Route::get('/data_pasien', [PasienController::class, 'index']);
  
    Route::get('/hasil_uji', function () {
        return view('rekam_medis.hasil_uji');
    });
});

// ---------------------------
// Laboran Pages
// ---------------------------

Route::prefix('laboran')->group(function () {
    Route::get('/dashboard', function () {
        return view('laboran.dashboard_laboran');
    });

    Route::get('/hasil_uji', function () {
        return view('laboran.hasil_uji');
    });
});

// ---------------------------
// Pasien Pages
// ---------------------------

Route::prefix('pasien')->name('pasien.')->group(function () {
    // Login routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [PasienLoginController::class, 'index'])->name('login');
        Route::post('/login', [PasienLoginController::class, 'login']);
    });

    // Authenticated routes
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard_pasien', function () {
            return view('pasien.dashboard_pasien');
        });
        Route::get('/hasil_uji', function () {
            return view('pasien.hasil_uji');
        });
    });

    // Logout
    Route::post('/logout', [PasienLoginController::class, 'logout'])->name('logout');
});

// ---------------------------
// CRUD Routes
// ---------------------------

// Pasien
Route::resource('pasiens', PasienController::class);

// Staf (Laboran & Rekam Medis)
Route::resource('stafs', StafController::class);
Route::get('/rekam_medis/data_staf', [StafController::class, 'index'])->name('data_staf');

// SEARCH PASIEN   
Route::get('/search/pasien', [PasienController::class, 'searchPasien'])->name('search.pasien');


// Rute data staf dengan parameter pencarian
Route::get('/rekam_medis/data_staf', [App\Http\Controllers\Staf\StafController::class, 'index'])->name('data_staf');

// Jika perlu AJAX search
Route::get('/search/staf', [App\Http\Controllers\Staf\StafController::class, 'searchStaf'])->name('search.staf');