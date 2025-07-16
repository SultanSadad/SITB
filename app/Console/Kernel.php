<?php

namespace App\Console;

// Buat atur jadwal tugas otomatis.
use Illuminate\Console\Scheduling\Schedule;
// Ini kelas utama buat perintah-perintah di terminal (console).
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
// Ini buat pakai model HasilUjiTB (meskipun di sini belum dipakai).
use App\Models\HasilUjiTB;

class Kernel extends ConsoleKernel
{
    /**
     * **schedule()**
     *
     * Fungsi ini buat atur kapan tugas atau perintah di aplikasi harus jalan otomatis.
     * Kayak ngasih alarm ke aplikasi.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule Objek untuk bikin jadwal.
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Contoh: Mau jalankan sesuatu setiap hari jam 00:01 (tengah malam lewat 1 menit).
        // Sekarang isinya masih kosong, jadi belum ngapa-ngapain.
        $schedule->call(function () {
            // Kode yang mau dijalankan di sini.
            // Contoh: \Log::info('Tugas harian jalan!'); // Buat cek kalau jalan
        })->dailyAt('00:01'); // Jadwalnya: tiap hari jam 00:01.
    }

    /**
     * **commands()**
     *
     * Fungsi ini buat daftar semua perintah khusus yang bisa kamu jalankan
     * lewat terminal (misal: `php artisan nama-perintah`).
     *
     * @return void
     */
    protected function commands()
    {
        // Muat semua perintah yang ada di folder 'App/Console/Commands'.
        $this->load(__DIR__.'/Commands');

        // Muat file 'console.php' di folder 'routes'.
        // Ini biasanya buat perintah sederhana tanpa file terpisah.
        require base_path('routes/console.php');
    }
}