<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBScan - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background: url('{{ asset('image/bg-login.jpeg') }}') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            width: 100%;
            min-height: 100vh;
            background-color: rgba(255, 255, 255, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-box {
            background-color: rgba(217, 217, 217, 0.25);
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 800px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .login-header {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px 0;
        }

        .login-header h1 {
            margin: 0;
            font-size: 32px;
            color: #333;
        }

        .login-content {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }

        .left,
        .right {
            flex: 1 1 50%;
            padding: 30px;
        }

        .left {
            background-color: #ffffffc2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .left img {
            width: 120px;
            margin-bottom: 20px;
        }

        .left h2 {
            margin: 0;
            font-size: 22px;
            color: #000;
        }

        .right {
            background-color: rgba(255, 255, 255, 0.85);
        }

        .right h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .btn-login:hover {
            background-color: #45a049;
        }

        /* Responsive rules */
        @media (max-width: 768px) {
            .login-content {
                flex-direction: column;
            }

            .left,
            .right {
                flex: 1 1 100%;
                padding: 20px;
            }

            .left img {
                width: 100px;
            }

            .login-header h1 {
                font-size: 28px;
            }
        }

        @media (max-width: 480px) {
            .login-header h1 {
                font-size: 24px;
            }

            .left h2 {
                font-size: 18px;
            }

            .right h3 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-box">
            <div class="login-header">
                <h1>TBScan</h1>
            </div>
            <div class="login-content">
                <div class="left">
                    <img src="{{ asset('image/logo-login.png') }}" alt="Logo Pendidikan">
                    <h2>Kota Batam</h2>
                </div>
                <div class="right">
                    <h3>LOGIN PASIEN</h3>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('pasien.login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" id="nik" value="{{ old('nik') }}" name="nik" placeholder="NIK" required>
                        </div>
                        <div class="form-group">
                            <label for="no_erm">Nomor Rekam Medis</label>
                            <input type="text" id="no_erm" value="{{ old('no_erm') }}" name="no_erm"
                                placeholder="Nomor Rekam Medis" required>
                        </div>
                        <button type="submit" class="btn-login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>