{{-- Nama File   = login_pemohon.blade.php --}}
{{-- Deskripsi   = Halaman Login Staf--}}
{{-- Dibuat oleh = Saskia Nadira- 3312301196 --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HasilLaboratorium - Login</title> <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> <style>
        /* CSS Umum */
        * { box-sizing: border-box; } /* Memastikan padding dan border disertakan dalam total lebar/tinggi elemen */
        body {
            margin: 0; padding: 0; font-family: 'Roboto', sans-serif;
            background: url('{{ asset('/statis/image/bg-login.jpg') }}') no-repeat center center fixed; /* Gambar latar belakang */
            background-size: cover; /* Menutupi seluruh area */
            overflow: hidden; /* Mencegah scrolling pada body */
        }
        .container {
            width: 100%; min-height: 100vh; background-color: rgba(255, 255, 255, 0.6); /* Overlay transparan */
            display: flex; align-items: center; justify-content: center; padding: 20px; /* Layout center */
        }
        .login-box {
            background-color: rgba(217, 217, 217, 0.25); border-radius: 15px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 100%; max-width: 800px; display: flex; flex-direction: column; overflow: hidden;
        }
        .login-header { text-align: center; background-color: rgba(255, 255, 255, 0.9); padding: 20px 0; }
        .login-header h1 { margin: 0; font-size: 32px; color: #333; }
        .login-content { display: flex; flex-direction: row; flex-wrap: wrap; }
        .left, .right { flex: 1 1 50%; padding: 30px; } /* Pembagian 50% untuk kiri dan kanan */
        .left {
            background-color: #ffffffc2; display: flex; flex-direction: column;
            align-items: center; justify-content: center; /* Konten kiri di tengah */
        }
        .left img { width: 250px; margin-bottom: 20px; } /* Ukuran logo */
        .right { background-color: rgba(255, 255, 255, 0.85); } /* Latar belakang form login */
        .right h3 { text-align: center; margin-bottom: 20px; color: #333; }
        .form-group { margin-bottom: 20px; position: relative; } /* Posisi relatif untuk ikon toggle password */
        .form-group input {
            width: 100%; padding: 12px; padding-right: 40px; border: 1px solid #ccc;
            border-radius: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            background: #fff; transition: all 0.2s ease;
        }
        .form-group input:focus { outline: none; border-color: #007bff; }
        .toggle-icon {
            position: absolute; top: 50%; right: 12px; transform: translateY(-50%);
            cursor: pointer; width: 20px; height: 20px; fill: #666; /* Styling ikon toggle password */
        }
        .btn-login {
            width: 100%; padding: 12px; background-color: #4CAF50; border: none;
            color: white; border-radius: 8px; cursor: pointer; font-size: 16px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); margin-top: 10px; /* Styling tombol login */
        }
        .btn-login:hover { background-color: #45a049; }

        /* Media Queries untuk Responsif */
        @media (max-width: 768px) { /* Untuk tablet dan mobile */
            .login-content { flex-direction: column; } /* Konten login jadi vertikal */
            .left, .right { flex: 1 1 100%; padding: 24px; }
            .left img { width: 140px; margin-bottom: 10px; }
            .login-header h1 { font-size: 24px; padding: 0 16px; }
            .form-group input { padding: 14px; font-size: 16px; }
            .btn-login { padding: 14px; font-size: 16px; }
            .login-box { margin: 0 16px; } /* Tambah jarak samping */
        }
        @media (max-width: 480px) { /* Untuk mobile kecil */
            .left img { width: 120px; }
            .login-header h1 { font-size: 20px; }
            .right h3 { font-size: 18px; margin-bottom: 16px; }
            .login-box { border-radius: 10px; }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-box">
            <div class="login-header">
                <h2>Hasil Pemeriksaan Laboratorium UPT Puskesmas Baloi Permai</h2>
            </div>
            <div class="login-content">
                <div class="left">
                 <img src="{{ asset('statis/image/logoepus.png') }}" alt="Logo Puskesmas">

                </div>
                <div class="right">
                    <h3>LOGIN STAF</h3>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('staf.login') }}">
                        @csrf <div class="form-group">
                            <input type="text" name="email" value="{{ old('email') }}" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" id="password" name="password" placeholder="Password" required>
                            <svg id="togglePassword" class="toggle-icon" viewBox="0 0 24 24" onclick="togglePassword()">
                                <path
                                    d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 13a5.5 5.5 0 110-11 5.5 5.5 0 010 11zm0-9a3.5 3.5 0 100 7 3.5 3.5 0 000-7z" />
                            </svg>
                        </div>
                        <button type="submit" class="btn-login">Login</button> </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const input = document.getElementById('password'); // Ambil input password
            const icon = document.getElementById('togglePassword').querySelector('path'); // Ambil path SVG ikon

            if (input.type === 'password') { // Jika tipe input adalah password (tersembunyi)
                input.type = 'text'; // Ubah menjadi teks (terlihat)
                // Ganti ikon menjadi mata terbuka
                icon.setAttribute("d", "M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5z");
            } else { // Jika tipe input adalah teks (terlihat)
                input.type = 'password'; // Ubah menjadi password (tersembunyi)
                // Ganti ikon menjadi mata tertutup
                icon.setAttribute("d", "M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 13a5.5 5.5 0 110-11 5.5 5.5 0 010 11zm0-9a3.5 3.5 0 100 7 3.5 3.5 0 000-7z");
            }
        }
    </script>

</body>

</html>