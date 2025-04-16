<?php

use App\Http\Controllers\PasienController;
use App\Http\Controllers\Auth\PasienLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| 
|
*/

Route::get('/Home', function () {
    return view('welcome');
});

Route::get('/dashboard_rekam_medis', function () {
    return view('rekam_medis.dashboard');
});

Route::get('/rekam_medis/data_pasien', function () {
    return view('rekam_medis.data_pasien');
});

Route::get('/rekam_medis/data_laboran', function () {
    return view('rekam_medis.data_laboran');
});

Route::get('/rekam_medis/hasil_uji', function () {
    return view('rekam_medis.hasil_uji');
});

Route::get('/laboran/dashboard_laboran', function () {
    return view('laboran.dashboard_laboran');
});

Route::get('/laboran/hasil_uji', function () {
    return view('laboran.hasil_uji');
});

Route::get('/pasien/hasil_uji', function () {
    return view('pasien.hasil_uji');
});

//-------------------//
// Auth Login Pasien //

Route::prefix('pasien')->name('pasien.')->group(function () {
    // Route login untuk pasien
    Route::middleware('guest')->group(function () {
        Route::get('/login', [PasienLoginController::class, 'index'])->name('login');
        Route::post('/login', [PasienLoginController::class, 'login']);
    });

    // Halaman dashboard pasien setelah login
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard_pasien', function () {
            return view('pasien.dashboard_pasien');
        });
    });

    // Logout pasien
    Route::post('/logout', [PasienLoginController::class, 'logout'])->name('logout');
});
