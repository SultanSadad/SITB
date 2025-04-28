<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasienLoginController;
use App\Http\Controllers\Pasien\PasienController;
use App\Http\Controllers\Staf\StafController;
use App\Http\Controllers\HasilUji\HasilUjiTBController;


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

//ROUTE LABORAN
Route::get('/laboran/dashboard_laboran', function () {
    return view('laboran.dashboard_laboran');   
});



Route::get('/laboran/detail_laboran', function () {
    return view('laboran.detail_laboran');
});

// Route Laboran untuk menampilkan hasil uji berdasarkan pasien
Route::get('/laboran/detail_laboran/{pasienId}', [App\Http\Controllers\HasilUji\HasilUjiTBController::class, 'showByPasien'])->name('laboran.detail');
Route::get('/laboran/detail/{pasienId}', [App\Http\Controllers\Laboran\LaboranController::class, 'showDetail'])->name('laboran.detail');

////ROUTE PASIEN
Route::get('/pasien/dashboard_pasien', function () {
    return view('pasien.dashboard_pasien');
});

Route::get('/hasil_uji', [App\Http\Controllers\HasilUji\HasilUjiTBController::class, 'index']);


Route::post('/pasien/{pasien}/hasil-uji', [HasilUjiTBController::class, 'store'])->name('hasilUjiTB.store');

Route::get('/rekam_medis/hasil_uji', [HasilUjiTBController::class, 'index'])->name('rekam-medis.hasil-uji');

//pagin di halaman laboran/hasil_uji
// Tambahkan rute ini di routes/web.php
Route::get('/laboran/hasil_uji', [App\Http\Controllers\Pasien\PasienController::class, 'laboranIndex'])->name('laboran.hasil_uji');
Route::get('/laboran/hasil_uji', [App\Http\Controllers\HasilUji\HasilUjiTBController::class, 'hasilUji'])->name('laboran.hasil_uji');