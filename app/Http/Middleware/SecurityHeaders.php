<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

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
        $request->attributes->set('csp_nonce', $nonce); // For Blade access

        // Base CSP policy
        $cspPolicy  = "default-src 'self';";
        $cspPolicy .= "img-src 'self' data:;"; // untuk logo, avatar, dsb
        $cspPolicy .= "font-src 'self' data: https://fonts.gstatic.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net;";

        if ($isDevelopment) {
            // CSP longgar untuk lokal development
            $cspPolicy .= "script-src 'self' 'unsafe-inline' 'nonce-{$nonce}' " .
                "http://localhost:5173 http://127.0.0.1:5173 " .
                "https://cdn.jsdelivr.net " .
                "https://cdnjs.cloudflare.com " .
                "https://cdn.tailwindcss.com " .
                "https://code.jquery.com;";

            $cspPolicy .= "style-src 'self' 'unsafe-inline' 'nonce-{$nonce}' " .
                "http://localhost:5173 http://127.0.0.1:5173 " .
                "https://fonts.googleapis.com " .
                "https://cdnjs.cloudflare.com " .
                "https://cdn.jsdelivr.net " .
                "https://cdn.tailwindcss.com;";

            $cspPolicy .= "connect-src 'self' " .
                "http://localhost:5173 http://127.0.0.1:5173 " .
                "ws://localhost:5173 ws://127.0.0.1:5173;";

            $cspPolicy .= "frame-src 'none';";
            $cspPolicy .= "object-src 'none';";
            $cspPolicy .= "base-uri 'self';";

        } else {
            // CSP untuk production (lebih ketat)
            $cspPolicy .= "script-src 'self' 'nonce-{$nonce}' https://cdn.jsdelivr.net https://code.jquery.com;";
            $cspPolicy .= "style-src 'self' 'nonce-{$nonce}' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net;";
            $cspPolicy .= "connect-src 'self';";
            $cspPolicy .= "frame-src 'none';";
            $cspPolicy .= "object-src 'none';";
            $cspPolicy .= "base-uri 'self';";
        }

        $response->headers->set('Content-Security-Policy', $cspPolicy);

        // Header keamanan tambahan
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(self), microphone=(), camera=()');

        return $response;
    }
}
