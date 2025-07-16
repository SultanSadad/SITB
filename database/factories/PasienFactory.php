<?php

// Nama File   = PasienFactory.php
// Deskripsi   = Factory ini digunakan untuk membuat data dummy (palsu) untuk model Pasien.
//               Ini sangat berguna untuk mengisi database dengan data contoh saat pengembangan
//               atau untuk pengujian aplikasi (seeding database).
// Dibuat oleh = Sultan Sadad - 3312301102
// Tanggal     = 1 April 2025

namespace Database\Factories; // Menentukan lokasi (namespace) dari factory ini.

use Illuminate\Database\Eloquent\Factories\Factory; // Import kelas dasar Factory dari Eloquent.

class PasienFactory extends Factory
{
    /**
     * definition()
     *
     * **Tujuan:** Mendefinisikan status default model Pasien. Ini adalah blueprint untuk membuat
     * data dummy. Setiap atribut (kolom) di sini akan diisi dengan nilai palsu yang dihasilkan
     * oleh faker.
     *
     * @return array<string, mixed> Array berisi definisi atribut-atribut model.
     */
    public function definition(): array
    {
        return [
            // 'nik': Menghasilkan Nomor Induk Kependudukan (NIK) palsu yang unik.
            //        `unique()`: Memastikan nilai yang dihasilkan unik di antara data dummy lain.
            //        `numerify('###############')`: Menghasilkan 16 digit angka (sesuai format NIK).
            'nik' => $this->faker->unique()->numerify('###############'),

            // 'no_erm': Menghasilkan Nomor Rekam Medis Elektronik (No. ERM) palsu yang unik.
            //           `numerify('ERM###')`: Menghasilkan string 'ERM' diikuti 3 digit angka acak.
            'no_erm' => $this->faker->unique()->numerify('ERM###'),

            // 'nama': Menghasilkan nama lengkap acak.
            'nama' => $this->faker->name(),

            // 'tanggal_lahir': Menghasilkan tanggal lahir acak.
            'tanggal_lahir' => $this->faker->date(),

            // 'no_whatsapp': Menghasilkan nomor WhatsApp palsu yang unik.
            //                `numerify('08##########')`: Menghasilkan '08' diikuti 10 digit angka acak.
            'no_whatsapp' => $this->faker->unique()->numerify('08##########'),

            // 'verifikasi': Mengatur status verifikasi default ke `true` (terverifikasi).
            'verifikasi' => true,
        ];
    }
}