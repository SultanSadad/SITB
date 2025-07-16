<?php

// Nama File   = UserFactory.php
// Deskripsi   = Factory ini digunakan untuk membuat data dummy (palsu) untuk model User.
//               Ini sangat berguna untuk mengisi database dengan data contoh saat pengembangan
//               atau untuk pengujian aplikasi (seeding database). Factory ini juga cerdas
//               dalam membuat data Pasien atau Staf terkait secara otomatis berdasarkan peran user.
// Dibuat oleh = Sultan Sadad - 3312301102
// Tanggal     = 1 April 2025

namespace Database\Factories; // Menentukan lokasi (namespace) dari factory ini.

use Illuminate\Database\Eloquent\Factories\Factory; // Import kelas dasar Factory dari Eloquent.
use Illuminate\Support\Facades\Hash; // Import Facade Hash untuk mengenkripsi password.
use Illuminate\Support\Str; // Import Str untuk fungsi string helper (misal: Str::random).
use App\Models\User; // Import model User yang akan dibuatkan data dummy-nya.
use App\Models\Pasien; // Import model Pasien untuk relasi.
use App\Models\Staf; // Import model Staf untuk relasi.

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 * Penjelasan: Ini adalah DocBlock standar yang menunjukkan bahwa factory ini
 * memperluas kelas Factory Laravel dan dikhususkan untuk model User.
 */
class UserFactory extends Factory
{
    /**
     * $password
     *
     * **Tujuan:** Menyimpan password yang sedang digunakan oleh factory untuk pembuatan user.
     * Ini mencegah password di-hash berulang kali jika beberapa user dibuat dalam satu proses.
     *
     * @var string|null Password saat ini yang di-hash, atau null.
     */
    protected static ?string $password;

    /**
     * definition()
     *
     * **Tujuan:** Mendefinisikan status default model User. Ini adalah blueprint untuk membuat
     * data dummy. Setiap atribut (kolom) di sini akan diisi dengan nilai palsu yang dihasilkan
     * oleh faker.
     *
     * @return array<string, mixed> Array berisi definisi atribut-atribut model.
     */
    public function definition(): array
    {
        return [
            // 'name': Menghasilkan nama lengkap acak.
            'name' => fake()->name(),
            // 'email': Menghasilkan alamat email palsu yang unik dan aman.
            'email' => fake()->unique()->safeEmail(),
            // 'email_verified_at': Mengatur tanggal verifikasi email ke waktu saat ini.
            'email_verified_at' => now(),
            // 'password': Menggunakan password default 'password' yang di-hash.
            //             `static::$password ??= Hash::make('password')`: Ini akan menghash 'password' sekali
            //             dan menyimpannya di `$password` untuk penggunaan berikutnya agar tidak di-hash berulang.
            'password' => static::$password ??= Hash::make('password'),
            // 'remember_token': Menghasilkan string acak 10 karakter untuk token "ingat saya".
            'remember_token' => Str::random(10),
            // 'role': Menghasilkan peran acak dari daftar peran yang valid.
            //         Pastikan daftar ini cocok dengan kolom ENUM 'role' di database Anda.
            'role' => $this->faker->randomElement(['pasien', 'laboran', 'rekam_medis', 'admin']),
            // 'pasien_id': Secara default diatur ke `null`. Akan diisi setelah user dibuat (lihat `afterCreating`).
            'pasien_id' => null,
            // 'staf_id': Secara default diatur ke `null`. Akan diisi setelah user dibuat (lihat `afterCreating`).
            'staf_id' => null,
        ];
    }

    /**
     * configure()
     *
     * **Tujuan:** Mengkonfigurasi factory ini, terutama untuk menambahkan callback yang akan
     * dijalankan setelah sebuah model User berhasil dibuat.
     *
     * @return static Mengembalikan instance factory untuk chaining method.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            // Logika ini dijalankan SETELAH sebuah User berhasil dibuat dan disimpan ke database.

            // 1. Jika User adalah 'pasien' dan belum memiliki `pasien_id`:
            if ($user->role === 'pasien' && is_null($user->pasien_id)) {
                // Buat data Pasien baru menggunakan PasienFactory.
                $pasien = Pasien::factory()->create();
                // Kaitkan User ini dengan Pasien yang baru dibuat.
                $user->pasien_id = $pasien->id;
                $user->save(); // Simpan perubahan pada User.
            }
            // 2. Jika User adalah 'laboran', 'rekam_medis', atau 'admin' (semua jenis staf)
            //    dan belum memiliki `staf_id`:
            if (in_array($user->role, ['laboran', 'rekam_medis', 'admin']) && is_null($user->staf_id)) {
                // Buat data Staf baru menggunakan StafFactory.
                // (Asumsi StafFactory tidak bergantung pada peran spesifik saat dibuat).
                $staf = Staf::factory()->create();
                // Kaitkan User ini dengan Staf yang baru dibuat.
                $user->staf_id = $staf->id;
                $user->save(); // Simpan perubahan pada User.
            }
        });
    }

    /**
     * unverified()
     *
     * **Tujuan:** State (kondisi) factory ini yang menunjukkan bahwa alamat email user belum diverifikasi.
     * Saat dipanggil, ini akan menimpa `email_verified_at` menjadi `null`.
     * Contoh penggunaan: `User::factory()->unverified()->create();`
     *
     * @return static Mengembalikan instance factory untuk chaining method.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * pasien()
     *
     * **Tujuan:** State (kondisi) factory ini untuk membuat User dengan peran 'pasien'.
     * Contoh penggunaan: `User::factory()->pasien()->create();`
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pasien(): Factory
    {
        return $this->state(fn (array $attributes) => ['role' => 'pasien']);
    }

    /**
     * laboran()
     *
     * **Tujuan:** State (kondisi) factory ini untuk membuat User dengan peran 'laboran'.
     * Contoh penggunaan: `User::factory()->laboran()->create();`
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function laboran(): Factory
    {
        return $this->state(fn (array $attributes) => ['role' => 'laboran']);
    }

    /**
     * rekamMedis()
     *
     * **Tujuan:** State (kondisi) factory ini untuk membuat User dengan peran 'rekam_medis'.
     * Contoh penggunaan: `User::factory()->rekamMedis()->create();`
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function rekamMedis(): Factory
    {
        return $this->state(fn (array $attributes) => ['role' => 'rekam_medis']);
    }

    /**
     * admin()
     *
     * **Tujuan:** State (kondisi) factory ini untuk membuat User dengan peran 'admin'.
     * Contoh penggunaan: `User::factory()->admin()->create();`
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin(): Factory
    {
        return $this->state(fn (array $attributes) => ['role' => 'admin']);
    }
}