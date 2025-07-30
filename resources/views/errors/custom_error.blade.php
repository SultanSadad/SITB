<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error {{ $exception->getStatusCode() ?? 500 }}</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 50px;
            text-align: center;
            color: #333;
        }
        h1 {
            color: #cc0000;
        }
        .message {
            font-size: 1.2em;
        }
        .code {
            font-weight: bold;
        }
    </style>
    @php
        // Pastikan $cspNonce tersedia dari Handler
        $cspNonce = $cspNonce ?? ''; // Fallback jika tidak ada
    @endphp
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'nonce-{{ $cspNonce }}'; style-src 'self' 'nonce-{{ $cspNonce }}';">
</head>
<body>
    <h1>Error {{ $exception->getStatusCode() ?? 500 }} - {{ class_basename($exception) }}</h1>
    <p class="message">Maaf, terjadi kesalahan teknis pada halaman ini.</p>
    @if(config('app.debug'))
        <p><strong>Debug Info:</strong> {{ $exception->getMessage() }} (File: {{ basename($exception->getFile()) }} Line: {{ $exception->getLine() }})</p>
    @endif
    <a href="/">Kembali ke Beranda</a>
</body>
</html>