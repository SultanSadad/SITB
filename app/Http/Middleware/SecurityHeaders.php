<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Vite;
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
        $frameSrc = ["'self'"]; // Inisialisasi frame-src

        if ($isDevelopment) {
            $viteDevServerUrl = config('vite.dev_server_url', 'http://localhost:5173');
            
            // Tambahkan URL Vite development server
            $scriptSrc[] = $viteDevServerUrl;
            $styleSrc[] = $viteDevServerUrl;
            $connectSrc[] = str_replace('http', 'ws', $viteDevServerUrl); // Untuk WebSocket HMR
            $connectSrc[] = $viteDevServerUrl;
            $fontSrc[] = $viteDevServerUrl; // Tambahkan URL Vite ke font-src

            // Tambahkan CDN yang diperlukan di development
            $scriptSrc[] = 'https://cdn.jsdelivr.net'; // <<< PASTIKAN INI ADA
            $scriptSrc[] = 'https://code.jquery.com';   // <<< PASTIKAN INI ADA
            $styleSrc[] = 'https://fonts.googleapis.com';
            $styleSrc[] = 'https://cdnjs.cloudflare.com';
            $styleSrc[] = 'https://cdn.jsdelivr.net'; // <<< PASTIKAN INI ADA (untuk DaisyUI)
            $frameSrc[] = 'https://www.youtube.com'; // Untuk YouTube iframe
        } else {
            // Aturan ketat untuk production (tanpa Vite dev server)
            $scriptSrc[] = 'https://cdn.jsdelivr.net';
            $scriptSrc[] = 'https://code.jquery.com';
            $styleSrc[] = 'https://fonts.googleapis.com';
            $styleSrc[] = 'https://cdnjs.cloudflare.com';
            $styleSrc[] = 'https://cdn.jsdelivr.net';
            // frame-src mungkin perlu disesuaikan untuk produksi jika pakai YouTube
        }

        // Bangun string kebijakan CSP
        $cspPolicy = "default-src 'self'; ";
        $cspPolicy .= "img-src 'self' data: blob:; ";

        // >>> TAMBAHKAN BARIS INI (base-uri) <<<
        $cspPolicy .= "base-uri 'self'; "; 
        // Ini adalah direktif yang paling sering menyebabkan ZAP mengeluh jika tidak ada.

        $cspPolicy .= "font-src " . implode(' ', array_unique($fontSrc)) . "; "; // Bangun font-src
        $cspPolicy .= "frame-ancestors 'self'; ";
        $cspPolicy .= "form-action 'self'; ";
        $cspPolicy .= "frame-src " . implode(' ', array_unique($frameSrc)) . "; "; // Bangun frame-src

        $cspPolicy .= "script-src " . implode(' ', array_unique($scriptSrc)) . "; ";
        $cspPolicy .= "style-src " . implode(' ', array_unique($styleSrc)) . "; ";
        $cspPolicy .= "connect-src " . implode(' ', array_unique($connectSrc)) . "; ";

        // Lanjutkan permintaan ke aplikasi dan dapatkan respons
        $response = $next($request);

        // Set header CSP di respons
        $response->headers->set('Content-Security-Policy', $cspPolicy);
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(self), microphone=(), camera=()');

        // Log final untuk perbandingan
        $finalCspHeader = $response->headers->get('Content-Security-Policy');
        Log::info('SecurityHeaders: Nonce yang digunakan untuk membangun kebijakan: ' . $nonce);
        Log::info('SecurityHeaders: Header CSP Akhir (di respons): ' . ($finalCspHeader ?? 'NULL'));

        return $response;
    }
}