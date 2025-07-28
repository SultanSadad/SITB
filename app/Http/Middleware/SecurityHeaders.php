<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str; // Tambahkan ini untuk menggunakan Str::random()

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $isDevelopment = app()->environment('local') || app()->environment('development');

        // Generate a fresh nonce for each request
        $nonce = Str::random(32);
        $request->attributes->set('csp_nonce', $nonce); // Simpan nonce di request untuk diakses di Blade

        // Base CSP policy
        $cspPolicy = "default-src 'self';";
        $cspPolicy .= "img-src 'self' data:;";

        // Perbarui font-src untuk mencakup semua CDN yang mungkin
        $cspPolicy .= "font-src 'self' data: " .
                      "https://fonts.gstatic.com " . // Untuk Google Fonts
                      "https://cdnjs.cloudflare.com;"; // Untuk Font Awesome

        if ($isDevelopment) {
            // -- Development specific CSP (more lenient) --
            // Tambahkan 'unsafe-eval' jika Anda yakin ada library yang memerlukannya (Chart.js kadang butuh)
            // Namun, cobalah tanpa ini dulu jika memungkinkan.
            $cspPolicy .= "script-src 'self' 'unsafe-inline' 'nonce-{$nonce}' " .
                          "http://localhost:5173 http://127.0.0.1:5173 " . // Vite assets
                          "https://cdn.jsdelivr.net;"; // Chart.js CDN

            $cspPolicy .= "style-src 'self' 'unsafe-inline' 'nonce-{$nonce}' " .
                          "http://localhost:5173 http://127.0.0.1:5173 " . // Vite assets
                          "https://fonts.googleapis.com https://cdnjs.cloudflare.com;"; // CDN CSS dan Font

            // Perbarui connect-src untuk mencakup semua yang dibutuhkan Vite
            $cspPolicy .= "connect-src 'self' " .
                          "http://localhost:5173 http://127.0.0.1:5173 " . // Vite dev server
                          "ws://localhost:5173 ws://127.0.0.1:5173;"; // Vite HMR (WebSockets)

        } else {
            // -- Production specific CSP (strict) --
            $cspPolicy .= "script-src 'self' 'nonce-{$nonce}' " .
                          "https://cdn.jsdelivr.net;"; // Chart.js CDN untuk produksi
            $cspPolicy .= "style-src 'self' 'nonce-{$nonce}' " .
                          "https://fonts.googleapis.com https://cdnjs.cloudflare.com;";
            $cspPolicy .= "connect-src 'self';";
        }

        $response->headers->set('Content-Security-Policy', $cspPolicy);

        // Header keamanan lainnya
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(self), microphone=(), camera=()');

        return $response;
    }
}     