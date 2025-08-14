<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error {{ $status ?? 500 }}</title>
  <style nonce="{{ $cspNonce }}">
    body {
      font-family: sans-serif;
      margin: 50px;
      text-align: center;
      color: #333
    }

    h1 {
      color: #cc0000
    }

    .message {
      font-size: 1.1em
    }

    .trace {
      text-align: left;
      background: #eee;
      padding: 10px;
      border-radius: 5px;
      overflow-x: auto;
      white-space: pre-wrap;
    }
  </style>
</head>

<body>
  <h1>Error {{ $status ?? 500 }} - {{ class_basename($exception) }}</h1>
  <p class="message">Maaf, terjadi kesalahan teknis pada halaman ini.</p>

  @if(config('app.debug'))
    <p><strong>Debug Info:</strong> {{ $exception->getMessage() }} (File: {{ basename($exception->getFile()) }} Line:
    {{ $exception->getLine() }})</p>
    <pre class="trace">{{ $exception->getTraceAsString() }}</pre>
  @endif

  <p><a href="/">Kembali ke Beranda</a></p>
</body>

</html>