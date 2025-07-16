<?php

// Nama File   = HasilUjiTBFactory.php
// Deskripsi   = Factory ini digunakan untuk membuat data dummy (palsu) untuk model HasilUjiTB.
//               Ini sangat berguna untuk mengisi database dengan data contoh saat pengembangan
//               atau untuk pengujian aplikasi (seeding database).
// Dibuat oleh = Sultan Sadad - 3312301102
// Tanggal     = 1 April 2025

namespace Database\Factories; // Menentukan lokasi (namespace) dari factory ini.

use Illuminate\Database\Eloquent\Factories\Factory; // Import kelas dasar Factory dari Eloquent.
use App\Models\HasilUjiTB; // Import model HasilUjiTB yang akan dibuatkan data dummy-nya.
use App\Models\Pasien; // Import model Pasien untuk relasi.
use App\Models\Staf; // Import model Staf untuk relasi.

class HasilUjiTBFactory extends Factory
{
    /**
     * $model
     *
     * **Tujuan:** Mendefinisikan model Eloquent mana yang akan dibuatkan data dummy-nya oleh factory ini.
     *
     * @var string Nama kelas model.
     */
    protected $model = HasilUjiTB::class;

    /**
     * definition()
     *
     * **Tujuan:** Mendefinisikan status default model. Ini adalah blueprint untuk membuat
     * data dummy. Setiap atribut (kolom) di sini akan diisi dengan nilai palsu yang dihasilkan
     * oleh faker.
     *
     * @return array<string, mixed> Array berisi definisi atribut-atribut model.
     */
    public function definition(): array
    {
        return [
            // 'pasien_id': Menggunakan `Pasien::factory()` untuk secara otomatis membuat pasien baru
            //              dan mendapatkan ID-nya. Jika Anda ingin mengaitkannya dengan pasien yang sudah ada,
            //              Anda bisa menimpa ini saat memanggil factory.
            'pasien_id' => Pasien::factory(),

            // 'staf_id': Menggunakan `Staf::factory()` untuk secara otomatis membuat staf baru
            //            dan mendapatkan ID-nya. Jika Anda ingin mengaitkannya dengan staf yang sudah ada,
            //            Anda bisa menimpa ini saat memanggil factory.
            'staf_id' => Staf::factory(),

            // 'tanggal_uji': Menggunakan `faker->date()` untuk menghasilkan tanggal acak.
            'tanggal_uji' => $this->faker->date(),

            // 'tanggal_upload': Menggunakan `faker->date()` untuk menghasilkan tanggal acak.
            'tanggal_upload' => $this->faker->date(),

            // 'file': Mengatur nama file default menjadi 'dummy.pdf'.
            //         Ini bisa diganti secara manual saat membuat data untuk pengujian upload file yang sebenarnya.
            'file' => 'dummy.pdf',
        ];
    }
}