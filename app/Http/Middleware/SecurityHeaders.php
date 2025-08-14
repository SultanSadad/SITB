<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $isDev = app()->environment(['local', 'development']);

        // Nonce: generate sekali per-request, simpan di request + session untuk dipakai di Blade
        $nonce = $request->attributes->get('csp_nonce');
        if (! $nonce) {
            $nonce = Str::random(32);
            $request->attributes->set('csp_nonce', $nonce);
            Session::put('csp_nonce_session', $nonce);
        } else {
            if (Session::get('csp_nonce_session') !== $nonce) {
                Session::put('csp_nonce_session', $nonce);
            }
        }

        // Sumber CSP
        $fontSrc    = ["'self'", 'data:', 'https://fonts.gstatic.com', 'https://cdnjs.cloudflare.com'];
        $scriptSrc  = ["'self'", "'nonce-{$nonce}'"];
        $styleSrc   = ["'self'", "'nonce-{$nonce}'"];
        $connectSrc = ["'self'"];
        $frameSrc   = ['https://www.youtube.com', 'https://player.vimeo.com']; // sesuaikan jika tak dipakai

        if ($isDev) {
            $vite = rtrim(config('vite.dev_server_url', 'http://localhost:5173'), '/');
            $ws   = preg_replace('#^http#', 'ws', $vite);

            $scriptSrc[]  = $vite;
            $styleSrc[]   = $vite;
            $connectSrc[] = $vite;
            $connectSrc[] = $ws;
            $fontSrc[]    = $vite;
        }

        // CDN yang memang kamu gunakan
        $scriptSrc = array_merge(
            $scriptSrc,
            ['https://cdn.jsdelivr.net', 'https://code.jquery.com']
        );

        $styleSrc = array_merge(
            $styleSrc,
            [
                'https://fonts.googleapis.com',
                'https://cdnjs.cloudflare.com',
                'https://cdn.jsdelivr.net',
            ]
        );

        // Bangun kebijakan
        $csp = implode(' ', [
            "default-src 'self';",
            "img-src 'self' data: blob:;",
            "base-uri 'self';",
            "form-action 'self';",
            "frame-ancestors 'self';",
            "object-src 'none';",
            'font-src '    . implode(' ', array_unique($fontSrc))    . ';',
            'frame-src '   . implode(' ', array_unique($frameSrc))   . ';',
            'script-src '  . implode(' ', array_unique($scriptSrc))  . ';',
            'style-src '   . implode(' ', array_unique($styleSrc))   . ';',
            'connect-src ' . implode(' ', array_unique($connectSrc)) . ';',
        ]);

        $response = $next($request);

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set(
            'Permissions-Policy',
            'geolocation=(self), microphone=(), camera=()'
        );

        return $response;
    }
}
