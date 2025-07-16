<?php

// Nama File   = StafFactory.php
// Deskripsi   = Factory ini digunakan untuk membuat data dummy (palsu) untuk model Staf.
//               Ini sangat berguna untuk mengisi database dengan data contoh saat pengembangan
//               atau untuk pengujian aplikasi (seeding database).
// Dibuat oleh = Sultan Sadad - 3312301102
// Tanggal     = 1 April 2025

namespace Database\Factories; // Menentukan lokasi (namespace) dari factory ini.

use Illuminate\Database\Eloquent\Factories\Factory; // Import kelas dasar Factory dari Eloquent.

class StafFactory extends Factory
{
    /**
     * definition()
     *
     * **Tujuan:** Mendefinisikan status default model Staf. Ini adalah blueprint untuk membuat
     * data dummy. Setiap atribut (kolom) di sini akan diisi dengan nilai palsu yang dihasilkan
     * oleh faker.
     *
     * @return array<string, mixed> Array berisi definisi atribut-atribut model.
     */
    public function definition(): array
    {
        return [
            // 'nip': Menghasilkan Nomor Induk Pegawai (NIP) palsu yang unik.
            //        `unique()`: Memastikan nilai yang dihasilkan unik di antara data dummy lain.
            //        `numerify('NIP###')`: Menghasilkan string 'NIP' diikuti 3 digit angka acak.
            'nip' => $this->faker->unique()->numerify('NIP###'),

            // 'nama': Menghasilkan nama lengkap acak.
            'nama' => $this->faker->name(),

            // 'email': Menghasilkan alamat email palsu yang aman (tidak akan mengarah ke alamat email asli).
            'email' => $this->faker->safeEmail(),

            // 'no_whatsapp': Menghasilkan nomor WhatsApp palsu.
            //                Dimulai dengan '08' diikuti 10 digit angka acak.
            'no_whatsapp' => '08' . $this->faker->numerify('##########'),

            // 'peran': Mengatur peran default untuk staf yang dibuat factory ini menjadi 'laboran'.
            //          Anda bisa mengubah ini atau menimpanya saat memanggil factory.
            'peran' => 'laboran',

            // 'password': Mengatur password default menjadi 'password' yang sudah di-hash.
            //             `bcrypt('password')` adalah fungsi helper Laravel untuk menghash string.
            'password' => bcrypt('password'),
        ];
    }
}