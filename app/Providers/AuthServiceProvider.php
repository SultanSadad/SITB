<?php

namespace App\Providers;

use App\Models\HasilUjiTB;
use App\Models\Pasien;
use Illuminate\Support\Facades\Gate; // <-- Pastikan ini tidak dikomentari
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // =======================================================
        // TAMBAHKAN ATURAN OTORISASI DI SINI
        // =======================================================
        Gate::define('view-hasil-uji', function (Pasien $pasien, HasilUjiTB $hasilUji) {
            // Aturan: Izinkan jika ID pasien yang login SAMA DENGAN ID pasien pemilik hasil uji.
            return $pasien->id === $hasilUji->pasien_id;
        });
    }
}