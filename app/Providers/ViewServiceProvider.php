<?php

// app/Providers/ViewServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

// <<< PASTIKAN INI DIIMPOR!

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // === MODIFIKASI INI: Coba ambil dari session dulu ===
            $nonce = Session::get('csp_nonce_session'); // Ambil dari session

            // Jika session belum punya (misalnya untuk permintaan pertama sebelum session middleware aktif sepenuhnya),
            // maka coba ambil dari atribut request sebagai fallback.
            if (empty($nonce)) {
                $nonce = request()->attributes->get('csp_nonce');
            }
            // ===================================================

            // Log::info('ViewComposer (Session/Fallback): Nonce diambil: ' . ($nonce ?? 'NULL'));

            $view->with('nonce', $nonce);
        });
    }
}
