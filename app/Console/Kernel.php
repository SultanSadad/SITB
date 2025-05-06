<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\HasilUjiTB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Ini opsional: Jika Anda ingin otomatis menandai hasil uji yang sudah lewat dari hari ini
        $schedule->call(function () {
            // Kode ini akan dijalankan setiap hari tengah malam
            // Misalnya, Anda bisa menambahkan flag atau menandai bahwa data ini sudah tidak baru
            // HasilUjiTB::whereDate('created_at', now()->subDay())->update(['is_new' => false]);
            
            // Atau cukup mengandalkan filter tanggal di controller tanpa perlu update data
        })->dailyAt('00:01');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
