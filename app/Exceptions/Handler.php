<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            Log::error('App Error Reported: ' . $e->getMessage(), ['exception' => $e]);
        });

        $this->renderable(function (Throwable $e, Request $request) {
            Log::info('Handler: renderable() dipanggil untuk error: ' . get_class($e));

            // Generate nonce untuk respons error
            $nonce = Str::random(32);
            Log::info('Handler: Nonce digenerasi untuk halaman error: ' . $nonce);

            // Tentukan status code default jika tidak ada
            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

            // Tangani error tertentu dengan view kustom sederhana atau respons langsung
            if (in_array($statusCode, [404, 419, 500]) || // Targetkan error umum
                $e instanceof \Symfony\Component\ErrorHandler\Error\FatalError ||
                $e instanceof \ErrorException ||
                $e instanceof \OutOfMemoryError
            ) {
                Log::info("Handler: Menerapkan CSP dan merender view error kustom untuk status $statusCode.");

                try {
                    // Render view error kustom
                    $response = response()->view('errors.custom_error', [
                        'exception' => $e,
                        'cspNonce' => $nonce, // Kirim nonce ke view
                    ], $statusCode);

                    // Bangun kebijakan CSP (seperti sebelumnya, tapi lebih sederhana jika bisa)
                    $cspPolicy = "default-src 'self'; ";
                    $cspPolicy .= "img-src 'self' data: blob:; ";
                    // Untuk view error sederhana ini, kita hanya butuh ini:
                    $cspPolicy .= "script-src 'self' 'nonce-{$nonce}'; ";
                    $cspPolicy .= "style-src 'self' 'nonce-{$nonce}'; ";
                    $cspPolicy .= "connect-src 'self'; "; // Jika view error tidak memuat AJAX/WS
                    $cspPolicy .= "font-src 'self'; "; // Jika tidak memuat font eksternal
                    $cspPolicy .= "frame-ancestors 'self'; ";
                    $cspPolicy .= "form-action 'self'; ";
                    $cspPolicy .= "frame-src 'self'; "; // Jika tidak ada iframe

                    $response->headers->set('Content-Security-Policy', $cspPolicy);
                    $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
                    $response->headers->set('X-Content-Type-Options', 'nosniff');
                    $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
                    $response->headers->set('Permissions-Policy', 'geolocation=(self), microphone=(), camera=()');

                    Log::info('Handler: Header CSP berhasil ditambahkan ke respons error kustom.');
                    return $response;

                } catch (Throwable $renderException) {
                    Log::error('Handler: Gagal merender view error kustom atau menerapkan CSP: ' . $renderException->getMessage(), ['exception' => $renderException]);
                    // Jika rendering view kustom pun gagal, kembali ke respons teks sederhana
                    return response('<h1>Error ' . $statusCode . ' - Fatal Issue</h1><p>Maaf, ada masalah teknis lebih lanjut.</p>', $statusCode)
                                ->header('Content-Type', 'text/html');
                }
            }

            // Untuk error lainnya, biarkan Laravel menangani seperti biasa
            return parent::render($request, $e);
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
                    ? response()->json(['message' => $exception->getMessage()], 401)
                    : redirect()->guest($exception->redirectTo() ?? route('login'));
    }
}