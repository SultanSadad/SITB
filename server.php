<?php
// server.php — router untuk PHP built-in server (dipakai artisan serve)

if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
    $file = __DIR__ . '/public' . $path;

    if (is_file($file)) {
        // Deteksi MIME sederhana
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mimes = [
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
            'webp' => 'image/webp',
            'woff' => 'font/woff',
            'woff2'=> 'font/woff2',
            'ttf'  => 'font/ttf',
            'eot'  => 'application/vnd.ms-fontobject',
            'ico'  => 'image/x-icon',
            'map'  => 'application/json',
        ];
        $mime = $mimes[$ext] ?? 'application/octet-stream';

        // Header keamanan + tipe konten untuk file statis
        header('Content-Type: ' . $mime);
        header('X-Content-Type-Options: nosniff');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('X-Frame-Options: SAMEORIGIN');
        // opsional cache dev: comment aja kalau nggak perlu
        // header('Cache-Control: public, max-age=604800');

        readfile($file);
        return true;
    }
}

// selain file statis → teruskan ke front controller Laravel
require __DIR__ . '/public/index.php';
