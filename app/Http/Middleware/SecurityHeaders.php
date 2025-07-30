<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Vite; // Diperlukan untuk config('vite.dev_server_url')
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isDevelopment = app()->environment('local') || app()->environment('development');

        // Pastikan nonce hanya digenerasi satu kali per permintaan.
        // Coba ambil dari atribut request; jika belum ada, generate yang baru.
        $nonce = $request->attributes->get('csp_nonce');
        if (empty($nonce)) {
            $nonce = Str::random(32);
            $request->attributes->set('csp_nonce', $nonce); // Set di atribut request
            Session::put('csp_nonce_session', $nonce); // Simpan di session juga untuk View Composer
            Log::info('SecurityHeaders: Nonce generated & set: ' . $nonce);
        } else {
            // Nonce sudah ada. Konfirmasi saja dan sinkronkan sesi jika perlu.
            if (Session::get('csp_nonce_session') !== $nonce) {
                Session::put('csp_nonce_session', $nonce);
                Log::warning('SecurityHeaders: Nonce di request attributes dan session tidak konsisten, disinkronkan.');
            }
            Log::info('SecurityHeaders: Nonce reused from request attributes: ' . $nonce);
        }

        // Inisialisasi semua array source untuk CSP
        $fontSrc = ["'self'", "data:", "https://fonts.gstatic.com", "https://cdnjs.cloudflare.com"];
        $scriptSrc = ["'self'", "'nonce-{$nonce}'"];
        $styleSrc = ["'self'", "'nonce-{$nonce}'"];
        $connectSrc = ["'self'"];
        $frameSrc = ["'self'"]; // Inisialisasi frame-src, akan diisi lebih lanjut jika diperlukan

        if ($isDevelopment) {
            $viteDevServerUrl = config('vite.dev_server_url', 'http://localhost:5173');
            
            // Tambahkan URL Vite development server
            $scriptSrc[] = $viteDevServerUrl;
            $styleSrc[] = $viteDevServerUrl;
            $connectSrc[] = str_replace('http', 'ws', $viteDevServerUrl); // Untuk WebSocket HMR
            $connectSrc[] = $viteDevServerUrl;
            $fontSrc[] = $viteDevServerUrl; // Tambahkan URL Vite ke font-src

            // Tambahkan CDN yang diperlukan di development
            $scriptSrc[] = 'https://cdn.jsdelivr.net';
            $scriptSrc[] = 'https://code.jquery.com';
            $styleSrc[] = 'https://fonts.googleapis.com';
            $styleSrc[] = 'https://cdnjs.cloudflare.com';
            $styleSrc[] = 'https://cdn.jsdelivr.net'; // Untuk DaisyUI
            $frameSrc[] = 'http://www.youtube.com'; // Untuk YouTube iframe, contoh
            $frameSrc[] = 'https://www.youtube.com'; // Jika ada YouTube
            $frameSrc[] = 'https://player.vimeo.com'; // Jika ada Vimeo
        } else {
            // Aturan ketat untuk production (tanpa Vite dev server)
            $scriptSrc[] = 'https://cdn.jsdelivr.net';
            $scriptSrc[] = 'https://code.jquery.com';
            $styleSrc[] = 'https://fonts.googleapis.com';
            $styleSrc[] = 'https://cdnjs.cloudflare.com';
            $styleSrc[] = 'https://cdn.jsdelivr.net';
            // frame-src mungkin perlu disesuaikan untuk produksi jika pakai YouTube, Vimeo, dll.
            $frameSrc[] = 'http://www.youtube.com'; // Contoh untuk produksi
            $frameSrc[] = 'https://www.youtube.com';
            $frameSrc[] = 'https://player.vimeo.com';
        }

        // Bangun string kebijakan CSP
        $cspPolicy = "default-src 'self'; ";
        $cspPolicy .= "img-src 'self' data: blob:; ";
        $cspPolicy .= "base-uri 'self'; "; // Penting untuk ZAP testing dan keamanan
        $cspPolicy .= "font-src " . implode(' ', array_unique($fontSrc)) . "; ";
        $cspPolicy .= "frame-ancestors 'self'; "; // Melindungi dari clickjacking/framejacking
        $cspPolicy .= "form-action 'self'; "; // Membatasi endpoint form submissions
        $cspPolicy .= "frame-src " . implode(' ', array_unique($frameSrc)) . "; ";

        // Tambahkan 'unsafe-inline' ke script-src dan style-src hanya jika benar-benar tidak bisa dihindari di production.
        // Sebaiknya, semua script dan style inline diberi 'nonce' atau di-refactor menjadi file eksternal.
        // Jika masih ada inline script/style tanpa nonce yang tidak bisa dihindari:
        // $scriptSrc[] = "'unsafe-inline'";
        // $styleSrc[] = "'unsafe-inline'";

        $cspPolicy .= "script-src " . implode(' ', array_unique($scriptSrc)) . "; ";
        $cspPolicy .= "style-src " . implode(' ', array_unique($styleSrc)) . "; ";
        $cspPolicy .= "connect-src " . implode(' ', array_unique($connectSrc)) . "; ";

        // Lanjutkan permintaan ke aplikasi dan dapatkan respons
        $response = $next($request);

        // Set header CSP di respons
        $response->headers->set('Content-Security-Policy', $cspPolicy);
        
        // Header keamanan tambahan
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(self), microphone=(), camera=()');

        // Log final untuk perbandingan (debugging)
        $finalCspHeader = $response->headers->get('Content-Security-Policy');
        Log::info('SecurityHeaders: Nonce yang digunakan untuk membangun kebijakan: ' . $nonce);
        Log::info('SecurityHeaders: Header CSP Akhir (di respons): ' . ($finalCspHeader ?? 'NULL'));

        return $response;
    }
}