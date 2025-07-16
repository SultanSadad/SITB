<?php

// Nama File   = NoCacheAfterLogout.php
// Deskripsi   = Middleware ini bertujuan untuk mencegah browser menyimpan salinan halaman (caching)
//               setelah pengguna logout. Ini sangat penting untuk keamanan, terutama di halaman yang
//               membutuhkan otentikasi. Jika halaman di-cache, pengguna lain yang menggunakan komputer yang sama
//               bisa melihat konten yang seharusnya hanya bisa diakses saat login, meskipun sudah logout.
// Dibuat oleh = Salma
// Tanggal     = 16 Juli 2025 (Menggunakan tanggal saat ini sesuai konteks)

namespace App\Http\Middleware; // Menentukan lokasi (namespace) dari middleware ini.

// Import Closure untuk tipe data callback.
use Closure;
// Import kelas Request untuk bekerja dengan permintaan HTTP.
use Illuminate\Http\Request;
// Import kelas Response dari Symfony untuk tipe data respons HTTP.
use Symfony\Component\HttpFoundation\Response;

// =========================================================================
// Definisi Kelas Middleware
// =========================================================================

class NoCacheAfterLogout
{
    /**
     * handle()
     *
     * **Tujuan:** Memproses permintaan HTTP yang masuk dan menambahkan header yang mencegah caching pada respons.
     * Middleware ini bertindak sebagai "penjaga" yang memodifikasi respons server sebelum dikirimkan ke browser pengguna.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang sedang diproses.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next Closure yang mewakili middleware berikutnya dalam tumpukan atau handler utama aplikasi.
     * @return \Symfony\Component\HttpFoundation\Response Objek Respons HTTP yang dimodifikasi.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Lewatkan Permintaan ke Middleware/Handler Berikutnya:
        //    - `$response = $next($request);` akan menjalankan permintaan melalui
        //      middleware lain (jika ada) dan kemudian controller, lalu mendapatkan respons asli
        //      yang dihasilkan oleh aplikasi.
        $response = $next($request);

        // 2. Menambahkan Header Anti-Caching ke Respons:
        //    - Header ini memberitahu browser dan server proxy untuk TIDAK menyimpan halaman ini di cache.
        //    - `Cache-Control: no-store, no-cache, must-revalidate, max-age=0`
        //      - `no-store`: Jangan menyimpan respons sama sekali, bahkan di disk sementara.
        //      - `no-cache`: Cache mungkin disimpan, tapi harus divalidasi ulang dengan server.
        //      - `must-revalidate`: Harus divalidasi ulang dengan server, bahkan jika sudah kadaluarsa.
        //      - `max-age=0`: Respons dianggap kadaluarsa segera.
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');

        //    - `Pragma: no-cache`
        //      - Header lama yang digunakan untuk mencegah caching, kompatibilitas mundur dengan HTTP/1.0.
        $response->headers->set('Pragma', 'no-cache');

        //    - `Expires: Sat, 01 Jan 2000 00:00:00 GMT`
        //      - Menentukan tanggal kadaluarsa di masa lalu, memberitahu browser bahwa konten ini sudah tidak valid.
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT'); // Tanggal lampau

        // 3. Mengembalikan Respons yang Sudah Dimodifikasi:
        //    - Respons yang sudah ditambahkan header anti-caching akan dikirimkan kembali ke browser pengguna.
        return $response;
    }
}