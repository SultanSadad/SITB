<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Cek prefix URL agar diarahkan ke login yang sesuai
            if ($request->is('pasien/*')) {
                return route('pasien.login');
            } elseif ($request->is('staf/*') || $request->is('rekam_medis/*') || $request->is('laboran/*')) {
                return route('staf.login');
            }

            // Fallback: redirect ke login staf jika tidak dikenali
            return route('staf.login');
        }
    }
}
