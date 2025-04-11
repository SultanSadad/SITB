<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RekamMedis\PasienController;
use App\Models\Pasien;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboardrekammedis', function () {
    return view('rekammedis.dashboard');
});

Route::get('/dashboardrekammedis', [PasienController::class, 'dashboard']);
Route::post('/rekammedis/pasien/store', [PasienController::class, 'store']);;
Route::get('/dashboardrekammedis', [PasienController::class, 'dashboard']);




