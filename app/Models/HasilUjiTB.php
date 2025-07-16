<?php

// Nama File   = HasilUjiTB.php
// Deskripsi   = Model ini merepresentasikan tabel 'hasil_uji_tb' di database.
//               Ini digunakan untuk mengelola data hasil uji Tuberkulosis (TB),
//               termasuk detail seperti pasien terkait, staf yang mengunggah,
//               tanggal uji, tanggal unggah, status, dan lokasi file hasil uji.
// Dibuat oleh = Salma Aulia - 3312301096
// Tanggal     = 1 april 2025

namespace App\Models; // Menentukan lokasi (namespace) dari model ini.

use Illuminate\Database\Eloquent\Model; // Import kelas dasar Model dari Eloquent ORM.
use Illuminate\Database\Eloquent\Factories\HasFactory; // Import trait HasFactory untuk mendukung factory model (untuk seeding/pengujian).

class HasilUjiTB extends Model
{
    use HasFactory; // Mengaktifkan penggunaan factory untuk model ini.

    /**
     * $table
     *
     * **Tujuan:** Mendefinisikan nama tabel di database yang terhubung dengan model ini.
     * Secara default, Eloquent akan menggunakan bentuk plural dari nama model (misal: 'hasil_uji_t_b_s').
     * Namun, jika nama tabel Anda berbeda, Anda harus menentukannya secara eksplisit di sini.
     *
     * @var string Nama tabel database.
     */
    protected $table = 'hasil_uji_tb';

    /**
     * $fillable
     *
     * **Tujuan:** Mendefinisikan atribut-atribut (kolom) tabel yang dapat diisi secara massal (mass assignable).
     * Atribut yang ada di array `$fillable` bisa diisi menggunakan metode `create()` atau `update()`
     * dengan array data, yang merupakan praktik umum di Laravel. Ini adalah fitur keamanan untuk mencegah
     * pengisian data yang tidak diinginkan.
     *
     * @var array<int, string> Daftar kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'pasien_id',      // ID pasien yang terkait dengan hasil uji ini. (Foreign Key)
        'staf_id',        // ID staf yang mengunggah hasil uji ini. (Foreign Key)
        'tanggal_uji',    // Tanggal dilakukannya uji TB.
        'tanggal_upload', // Tanggal file hasil uji diunggah ke sistem.
        'status',         // Status hasil uji (misal: 'Positif', 'Negatif', 'Pending').
        'file',           // Path atau lokasi penyimpanan file hasil uji (misal: PDF).
    ];

    /**
     * pasien()
     *
     * **Tujuan:** Mendefinisikan relasi "many-to-one" (belongsTo) dengan model `Pasien`.
     * Ini berarti satu `HasilUjiTB` hanya dimiliki oleh satu `Pasien`.
     * Dengan relasi ini, Anda bisa dengan mudah mendapatkan data pasien dari objek HasilUjiTB.
     * Contoh: `$hasilUji->pasien->nama`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relasi dengan model Pasien.
     */
    public function pasien()
    {
        // Menyatakan bahwa model HasilUjiTB 'milik' (belongs to) model Pasien.
        // Eloquent akan mencari kolom `pasien_id` di tabel `hasil_uji_tb`
        // dan mencocokkannya dengan kolom `id` di tabel `pasiens`.
        return $this->belongsTo(Pasien::class);
    }

    /**
     * staf()
     *
     * **Tujuan:** Mendefinisikan relasi "many-to-one" (belongsTo) dengan model `Staf`.
     * Ini berarti satu `HasilUjiTB` hanya diunggah oleh satu `Staf`.
     * Dengan relasi ini, Anda bisa dengan mudah mendapatkan data staf dari objek HasilUjiTB.
     * Contoh: `$hasilUji->staf->nama`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relasi dengan model Staf.
     */
    public function staf()
    {
        // Menyatakan bahwa model HasilUjiTB 'milik' (belongs to) model Staf.
        // Eloquent akan mencari kolom `staf_id` di tabel `hasil_uji_tb`
        // dan mencocokkannya dengan kolom `id` di tabel `stafs`.
        return $this->belongsTo(Staf::class);
    }
}