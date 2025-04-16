<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
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

Route::get('/rekam_medis/data_staff', function () {
    return view('rekam_medis.data_staff');
});


Route::get('/rekam_medis/hasil_uji', function () {
    return view('rekam_medis.hasil_uji');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/laboran/dashboard_laboran', function () {
    return view('laboran.dashboard_laboran');
});

Route::get('/laboran/hasil_uji', function () {
    return view('laboran.hasil_uji');
});

Route::get('/pasien/dashboard_pasien', function () {
    return view('pasien.dashboard_pasien');
});

Route::get('/pasien/hasil_uji', function () {
    return view('pasien.hasil_uji');
});