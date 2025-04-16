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

Route::get('/DataPasien', function () {
    return view('rekammedis.DataPasien');
});

Route::get('/rekammedis/data-pasien', [PasienController::class, 'index'])->name('pasien.index');
Route::post('/rekammedis/pasien/store', [PasienController::class, 'store'])->name('pasien.store');
Route::delete('/rekammedis/pasien/delete/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');
Route::get('/rekammedis/pasien/{id}/edit', [PasienController::class, 'edit'])->name('pasien.edit');
Route::put('/rekammedis/pasien/{id}', [PasienController::class, 'update'])->name('pasien.update');





