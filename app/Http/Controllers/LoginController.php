<?php

// Nama File   = LoginController.php
// Deskripsi   = Mengatur semua logika yang berkaitan dengan proses login (masuk)
//               dan logout (keluar) untuk dua jenis pengguna: Pasien dan Staf.
//               Controller ini menentukan halaman login mana yang akan ditampilkan,
//               bagaimana data login divalidasi, dan ke mana pengguna akan diarahkan
//               setelah berhasil atau gagal login/logout.
// Dibuat oleh = Salma  Aulia - 3312301096
// Tanggal     = 1 April 2025

namespace App\Http\Controllers;

// Menentukan lokasi (namespace) dari controller ini.

// =========================================================================
// Import Kelas yang Dibutuhkan
// =========================================================================

// Import Request untuk mengambil data dari form (input pengguna).
use Illuminate\Http\Request;
// Import model Pasien untuk berinteraksi dengan data pasien di database.
use App\Models\Pasien;
// Import model Staf untuk berinteraksi dengan data staf di database.
use App\Models\Staf;
// Import model User. Perhatikan bahwa model User mungkin digunakan untuk guard 'web' default Laravel
// atau untuk relasi umum. Pastikan penggunaannya sesuai dengan konfigurasi autentikasi Anda.
use App\Models\User;
// Import Facade Auth untuk melakukan operasi autentikasi (login/logout).
use Illuminate\Support\Facades\Auth;
// Import Facade Hash untuk mengenkripsi password.
use Illuminate\Support\Facades\Hash;

// =========================================================================
// Definisi Kelas Controller
// =========================================================================

class LoginController extends Controller
{
    /**
     * showPasienLoginForm()
     *
     * **Tujuan:** Menampilkan halaman formulir login khusus untuk pengguna dengan peran 'pasien'.
     *
     * @return \Illuminate\Contracts\View\View Objek View yang menampilkan form login pasien.
     */
    public function showPasienLoginForm()
    {
        // Mengembalikan (menampilkan) view yang berada di 'resources/views/auth/login_pemohon.blade.php'.
        return view('auth.login_pemohon');
    }

    /**
     * loginPasien()
     *
     * **Tujuan:** Memproses permintaan login dari pasien.
     * Mengotentikasi pasien berdasarkan Nomor Induk Kependudukan (NIK) dan Nomor Rekam Medis (No. ERM).
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang berisi NIK dan No. ERM dari form login.
     * @return \Illuminate\Http\RedirectResponse Redirect ke halaman dashboard pasien atau kembali dengan error.
     */
    public function loginPasien(Request $request)
    {
        // 1. Validasi Input: Memastikan data yang diterima dari form sudah benar.
        //    - 'nik' dan 'no_erm' wajib diisi dan harus berupa string.
        $request->validate([
            'nik' => 'required|string',
            'no_erm' => 'required|string',
        ]);

        // 2. Pencarian Pasien: Mencari data pasien di database yang sesuai dengan NIK dan No. ERM.
        $pasien = Pasien::where('nik', $request->nik)
            ->where('no_erm', $request->no_erm)
            ->first(); // Mengambil satu baris data pertama yang cocok.

        // 3. Penanganan Jika Pasien Tidak Ditemukan:
        if (!$pasien) {
            // Jika tidak ada pasien yang ditemukan dengan NIK dan No. ERM tersebut,
            // kembalikan pengguna ke halaman login sebelumnya.
            return back()->withErrors([
                'nik' => 'NIK atau Nomor Rekam Medis tidak valid.', // Pesan error yang akan ditampilkan.
            ])->withInput(); // Menyimpan input NIK agar pengguna tidak perlu mengetik ulang.
        }

        // 4. Proses Login (Autentikasi):
        //    - Menggunakan 'Auth::guard('pasien')->login($pasien);' untuk mengautentikasi pasien.
        //      Ini berarti Laravel akan mencatat pasien ini sebagai pengguna yang sedang login
        //      menggunakan konfigurasi guard 'pasien' yang ada di `config/auth.php`.
        Auth::guard('pasien')->login($pasien);

        // 5. Regenerasi Sesi: Penting untuk keamanan (mencegah Session Fixation Attack).
        $request->session()->regenerate();

        // 6. Pengalihan (Redirect) Setelah Berhasil Login:
        //    - Mengarahkan pengguna ke rute yang diberi nama 'pasien.dashboard'.
        return redirect()->route('pasien.dashboard');
    }

    /**
     * showStafLoginForm()
     *
     * **Tujuan:** Menampilkan halaman formulir login khusus untuk pengguna dengan peran 'staf'.
     *
     * @return \Illuminate\Contracts\View\View Objek View yang menampilkan form login staf.
     */
    public function showStafLoginForm()
    {
        // Mengembalikan (menampilkan) view yang berada di 'resources/views/auth/login_petugas.blade.php'.
        return view('auth.login_petugas');
    }

    /**
     * loginStaf()
     *
     * **Tujuan:** Memproses permintaan login dari staf.
     * Mengautentikasi staf berdasarkan email dan password.
     * Mengarahkan staf ke dashboard yang sesuai dengan peran mereka (rekam_medis atau laboran).
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang berisi email dan password dari form login.
     * @return \Illuminate\Http\RedirectResponse Redirect ke dashboard staf atau kembali dengan error.
     */
    public function loginStaf(Request $request)
    {
        // 1. Validasi Input: Memastikan data yang diterima dari form sudah benar.
        //    - 'email' dan 'password' wajib diisi dan harus berupa string.
        $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        // 2. Siapkan Kredensial: Ambil email dan password dari request.
        $credentials = $request->only('email', 'password');

        // 3. Proses Login (Autentikasi):
        //    - Menggunakan 'Auth::guard('staf')->attempt($credentials)' untuk mencoba login staf.
        //      Fungsi `attempt()` akan memverifikasi password secara otomatis (setelah di-hash).
        //      Jika berhasil, pengguna akan di-login dan `attempt()` mengembalikan `true`.
        if (Auth::guard('staf')->attempt($credentials)) {
            // 4. Regenerasi Sesi: Penting untuk keamanan.
            $request->session()->regenerate();
            // 5. Ambil Data Staf: Dapatkan objek staf yang baru saja berhasil login.
            $staf = Auth::guard('staf')->user();

            // 6. Pengalihan (Redirect) Berdasarkan Peran Staf:
            //    - Jika peran staf adalah 'rekam_medis', arahkan ke dashboard rekam medis.
            if ($staf->peran === 'rekam_medis') {
                return redirect()->intended(route('rekam-medis.dashboard'));
            }
            //    - Jika peran staf adalah 'laboran', arahkan ke dashboard laboran.
            elseif ($staf->peran === 'laboran') {
                return redirect()->intended(route('laboran.dashboard'));
            }
            //    - Untuk peran staf lainnya (atau sebagai fallback), arahkan ke dashboard staf umum.
            else {
                return redirect()->intended(route('staf.dashboard'));
            }
        }

        // 7. Penanganan Jika Login Gagal:
        //    - Jika `attempt()` mengembalikan `false` (kredensial tidak cocok),
        //      kembalikan pengguna ke halaman login sebelumnya dengan pesan error.
        return back()->withErrors([
            'email' => 'Username atau password yang Anda masukkan salah.', // Pesan error.
        ])->withInput($request->only('email')); // Menyimpan input email agar tidak perlu mengetik ulang.
    }

    /**
     * logout()
     *
     * **Tujuan:** Memproses permintaan logout untuk semua jenis pengguna (pasien atau staf).
     * Mengidentifikasi guard yang sedang login dan melakukan logout, lalu mengarahkan
     * pengguna kembali ke halaman login yang sesuai.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request.
     * @return \Illuminate\Http\RedirectResponse Redirect ke halaman login yang sesuai.
     */
    public function logout(Request $request)
    {
        $redirectRoute = 'pasien.login'; // Rute default untuk redirect setelah logout (biasanya login pasien).

        // 1. Cek Guard 'staf': Periksa apakah ada staf yang sedang login.
        if (Auth::guard('staf')->check()) {
            Auth::guard('staf')->logout(); // Jika iya, logout dari guard 'staf'.
            $redirectRoute = 'staf.login'; // Atur rute pengalihan ke halaman login staf.
        }
        // 2. Cek Guard 'web': Jika tidak ada staf, cek apakah ada pengguna dari guard 'web' yang login.
        //    (Guard 'web' sering kali adalah guard default untuk pengguna umum/pasien jika tidak ada guard khusus pasien yang terpisah).
        elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout(); // Jika iya, logout dari guard 'web'.
            $redirectRoute = 'pasien.login'; // Atur rute pengalihan ke halaman login pasien.
        }

        // 3. Hapus Sesi:
        //    - `invalidate()`: Menghapus semua data dari sesi pengguna saat ini.
        $request->session()->invalidate();
        //    - `regenerateToken()`: Menggenerasi ulang token CSRF baru untuk sesi.
        $request->session()->regenerateToken();

        // 4. Baris untuk Debugging (saat ini dikomentari):
        //    - Baris ini bisa diaktifkan untuk melihat status redirect dan sesi saat debugging.
        // dd("Redirecting to: " . $redirectRoute, "Staf check: " . Auth::guard('staf')->check(), "Web check: " . Auth::guard('web')->check(), $request->session()->all());

        // 5. Pengalihan (Redirect) Final:
        //    - Mengarahkan pengguna ke rute login yang sudah ditentukan (`$redirectRoute`).
        return redirect()->route($redirectRoute);
    }
}
