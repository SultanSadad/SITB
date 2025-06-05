<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan Auth di-import

class PastikanPeranRekamMedis
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah pengguna sudah login dan memiliki staf_id
        if (Auth::check() && Auth::user()->staf_id) {
            // Ambil data staf terkait pengguna
            $staf = Auth::user()->staf; // Asumsi ada relasi 'staf' di model User
            
            // Cek apakah peran staf adalah 'rekam_medis'
            if ($staf && $staf->peran === 'rekam_medis') {
                return $next($request);
            }
        }

        // Jika tidak, redirect atau berikan response error
        // Anda bisa redirect ke halaman login staf atau halaman error 'unauthorized'
        Auth::logout(); // Logout pengguna karena mencoba akses tidak sah
        return redirect()->route('staf.login')->withErrors(['access_denied' => 'Anda tidak memiliki izin untuk mengakses halaman ini.']);
        // atau abort(403, 'Unauthorized action.');
    }
}