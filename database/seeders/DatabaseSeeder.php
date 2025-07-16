<?php

// Nama File   = DatabaseSeeder.php
// Deskripsi   = Seeder ini bertanggung jawab untuk mengisi database dengan data awal (dummy data)
//               yang diperlukan untuk pengujian dan pengembangan aplikasi.
//               Ini akan membuat data untuk tabel 'pasiens', 'staf', 'users', dan 'hasil_uji_tb'.
// Dibuat oleh = Salma Aulia - 3312301096
// Tanggal     = 1 april 2025

namespace Database\Seeders; // Menentukan lokasi (namespace) dari seeder ini.

use Illuminate\Database\Seeder; // Import kelas dasar Seeder.
use Illuminate\Support\Facades\DB; // Import Facade DB untuk interaksi langsung dengan database.
use Illuminate\Support\Facades\Hash; // Import Facade Hash untuk mengenkripsi password.
use App\Models\User; // Opsional: Perlu ini jika Anda ingin menggunakan User::factory() (saat ini tidak dipakai).
use App\Models\Pasien; // Opsional: Perlu ini jika Anda ingin menggunakan Pasien::factory() (saat ini tidak dipakai).
use App\Models\Staf; // Opsional: Perlu ini jika Anda ingin menggunakan Staf::factory() (saat ini tidak dipakai).

class DatabaseSeeder extends Seeder
{
    /**
     * run()
     *
     * **Tujuan:** Menjalankan operasi seeding (mengisi data dummy).
     * Metode ini akan dieksekusi ketika Anda menjalankan perintah `php artisan db:seed`.
     * Data akan diisi secara berurutan agar relasi antar tabel bisa terbentuk dengan benar.
     *
     * @return void
     */
    public function run(): void
    {
        // Catatan: Jika Anda menggunakan Factory untuk membuat data Pasien/Staf,
        // pastikan factory tersebut sudah dibuat dan metode `create()` dipanggil.
        // Saat ini, kode menggunakan `DB::table()->insertGetId()`, yang juga valid.

        // ==========================================================
        // 1. Mengisi Data Dummy Pasien
        // ==========================================================

        // Memasukkan satu data pasien baru ke tabel 'pasiens'.
        // `insertGetId()` akan mengembalikan ID dari baris yang baru saja dimasukkan.
        $pasienId = DB::table('pasiens')->insertGetId([
            'nik' => '1234567890123456',      // NIK unik.
            'no_erm' => 'ERM001',            // Nomor Rekam Medis unik.
            'nama' => 'Ahmad Pasien',        // Nama pasien.
            'tanggal_lahir' => '2000-01-01', // Tanggal lahir.
            'no_whatsapp' => '081234567890', // Nomor WhatsApp.
            'created_at' => now(),           // Waktu pembuatan data.
            'updated_at' => now(),           // Waktu terakhir diupdate.
        ]);

        // ==========================================================
        // 2. Mengisi Data Dummy Staf
        // ==========================================================

        // Memasukkan satu data staf (peran: Laboran) ke tabel 'staf'.
        $laboranId = DB::table('staf')->insertGetId([
            'nip' => 'LBR001',              // NIP unik.
            'nama' => 'Siti Laboran',       // Nama staf.
            'email' => 'laboran@example.com', // Email unik (digunakan untuk login).
            'no_whatsapp' => '081234567891', // Nomor WhatsApp.
            'peran' => 'laboran',           // Peran staf sebagai 'laboran'.
            'password' => Hash::make('password'), // Password di-hash (misal: 'password').
                                                  // Catatan: Pastikan password di `users` juga sesuai.
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Memasukkan satu data staf (peran: Petugas Rekam Medis) ke tabel 'staf'.
        $rekamId = DB::table('staf')->insertGetId([
            'nip' => 'RM001',               // NIP unik.
            'nama' => 'Budi Rekam',         // Nama staf.
            'email' => 'rekam@example.com', // Email unik.
            'no_whatsapp' => '081234567892', // Nomor WhatsApp.
            'peran' => 'rekam_medis',       // Peran staf sebagai 'rekam_medis'.
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ==========================================================
        // 3. Mengisi Data Dummy Users
        // ==========================================================

        // Memasukkan beberapa data user ke tabel 'users'.
        // Penting: Pastikan kolom 'role' di sini cocok dengan ENUM di migrasi tabel 'users'.
        DB::table('users')->insert([
            // User untuk Pasien:
            [
                'name' => 'Ahmad Pasien',           // Nama user.
                'email' => null,                    // Email bisa null jika login pasien tidak pakai email.
                'password' => null,                 // Password bisa null jika login pasien tidak pakai password.
                'role' => 'pasien',                 // Peran user ini adalah 'pasien'.
                'pasien_id' => $pasienId,           // Kaitkan dengan ID pasien yang baru dibuat.
                'staf_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // User untuk Laboran:
            [
                'name' => 'Siti Laboran',           // Nama user.
                'email' => 'laboran@example.com',   // Email untuk login laboran.
                'password' => Hash::make('password'), // Password untuk login laboran.
                'role' => 'laboran',                // Peran user ini adalah 'laboran'.
                                                    // HARUS 'laboran' agar middleware bisa mendeteksinya.
                'pasien_id' => null,
                'staf_id' => $laboranId,            // Kaitkan dengan ID staf laboran yang baru dibuat.
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // User untuk Petugas Rekam Medis:
            [
                'name' => 'Budi Rekam',             // Nama user.
                'email' => 'rekam@example.com',     // Email untuk login rekam medis.
                'password' => Hash::make('password'), // Password untuk login rekam medis.
                'role' => 'rekam_medis',            // Peran user ini adalah 'rekam_medis'.
                                                    // HARUS 'rekam_medis' agar middleware bisa mendeteksinya.
                'pasien_id' => null,
                'staf_id' => $rekamId,              // Kaitkan dengan ID staf rekam medis yang baru dibuat.
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // User untuk Admin (jika Anda memiliki peran admin terpisah):
            [
                'name' => 'Admin Utama',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',                  // Peran user ini adalah 'admin'.
                'pasien_id' => null,
                'staf_id' => null,                  // Jika admin tidak terkait langsung dengan staf_id tertentu.
                                                    // Atau bisa dikaitkan jika admin juga merupakan tipe staf.
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ==========================================================
        // 4. Mengisi Data Dummy Hasil Uji TB
        // ==========================================================

        // Memasukkan satu data hasil uji TB baru ke tabel 'hasil_uji_tb'.
        DB::table('hasil_uji_tb')->insert([
            'pasien_id' => $pasienId,       // ID pasien yang terkait.
            'staf_id' => $laboranId,        // ID staf (laboran) yang menginput data ini.
            'tanggal_uji' => '2024-05-01',  // Tanggal pemeriksaan.
            'tanggal_upload' => now(),      // Tanggal upload data.
            'status' => 'Negatif',          // Status hasil uji.
            'file' => null,                 // Path file hasil uji (saat ini null).
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}