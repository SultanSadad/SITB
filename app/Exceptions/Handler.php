<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        // 1) Validation: redirect back + flash
        $this->renderable(function (ValidationException $e, Request $request) {
            Log::info('Handler: ValidationException ditangani dengan redirect back + flash.');

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validasi gagal.',
                    'errors'  => $e->errors(),
                ], 422);
            }

            $msg = collect($e->errors())->flatten()->take(3)->implode(' • ');

            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('notif_type', 'error')
                ->with('notif_message', $msg);
        });

        // 2) Error lain: render custom (kecuali auth & validation)
        $this->renderable(function (Throwable $e, Request $request) {
            Log::info('Handler: renderable(Throwable) dipanggil: ' . get_class($e));

            if ($e instanceof AuthenticationException || $e instanceof ValidationException) {
                return null; // biarkan ke handler bawaan
            }

            $nonce  = Str::random(32);
            $status = 500;

            if ($e instanceof HttpExceptionInterface) {
                $status = $e->getStatusCode();
            } elseif (property_exists($e, 'status') && (int) $e->status) {
                $status = (int) $e->status;
            }

            try {
                $resp = response()->view('errors.custom_error', [
                    'exception' => $e,
                    'cspNonce'  => $nonce,
                    'status'    => $status,
                ], $status);

                $csp = "default-src 'self'; "
                    . "img-src 'self' data: blob:; "
                    . "base-uri 'self'; form-action 'self'; frame-ancestors 'self'; "
                    . "script-src 'self' 'nonce-{$nonce}'; "
                    . "style-src 'self' 'nonce-{$nonce}'; "
                    . "font-src 'self' data: https://fonts.gstatic.com; "
                    . "connect-src 'self'; frame-src 'self';";

                $resp->headers->set('Content-Security-Policy', $csp);
                $resp->headers->set('X-Frame-Options', 'SAMEORIGIN');
                $resp->headers->set('X-Content-Type-Options', 'nosniff');
                $resp->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

                return $resp;
            } catch (Throwable $re) {
                Log::error('Handler: gagal render error view: ' . $re->getMessage());

                return response(
                    '<h1>Error ' . $status . ' - Fatal Issue</h1><p>Maaf, ada masalah teknis lebih lanjut.</p>',
                    $status
                )->header('Content-Type', 'text/html');
            }
        });
    }

    /**
     * Auto-logout ketika akses lintas guard, lalu redirect ke login yang tepat.
     */
    protected function unauthenticated($request, AuthenticationException $e)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Tentukan guard tujuan dari exception / pola route
        $guard = $e->guards()[0] ?? null;

        $to = match ($guard) {
            'pasien'          => route('pasien.login'),
            'rekam_medis'     => route('rekam-medis.login'),
            'staf', 'laboran' => route('staf.login'),
            default           => null,
        };

        if (! $to) {
            if ($request->routeIs('pasien.*') || $request->is('pemohon/pasien/*')) {
                $to = route('pasien.login');
            } elseif ($request->routeIs('rekam-medis.*') || $request->is('petugas/rekam_medis/*')) {
                $to = route('rekam-medis.login');
            } else {
                $to = route('staf.login');
            }
        }

        // >>> KUNCI: logout semua guard + reset session (single-session policy)
        $this->logoutAllGuardsAndResetSession($request);

        return redirect()->guest($to);
    }

    /**
     * Logout seluruh guard yang mungkin aktif & reset session supaya tombol back tidak menampilkan halaman lama.
     */
    private function logoutAllGuardsAndResetSession(Request $request): void
    {
        foreach (['pasien', 'staf', 'rekam_medis', 'web'] as $g) {
            try {
                if (Auth::guard($g)->check()) {
                    Auth::guard($g)->logout();
                }
            } catch (Throwable $ex) {
                // guard mungkin tidak terdaftar - aman di-skip
            }
        }

        // Matikan sesi & token supaya benar-benar bersih
        try {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } catch (Throwable $ex) {
            // ignore jika tidak ada session
        }
    }
}
