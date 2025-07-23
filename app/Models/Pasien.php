<?php

// Nama File   = Pasien.php
// Deskripsi   = Model ini merepresentasikan tabel 'pasiens' di database.
//               Kelas ini juga berfungsi sebagai model untuk autentikasi pasien (login),
//               memungkinkan pasien untuk masuk ke sistem.
// Dibuat oleh = Salma Aulia - 3312301096
// Tanggal     = 1 april 2025

namespace App\Models;

// Menentukan lokasi (namespace) dari model ini.

use Illuminate\Database\Eloquent\Factories\HasFactory; // Import trait HasFactory untuk mendukung factory model (untuk seeding/pengujian).
use Illuminate\Foundation\Auth\User as Authenticatable; // Import kelas Authenticatable, yang merupakan dasar untuk model yang bisa diotentikasi (login).
use Illuminate\Notifications\Notifiable;

// Import trait Notifiable untuk mengaktifkan fitur notifikasi.

class Pasien extends Authenticatable
{
    // Menggunakan trait HasFactory (untuk seeding/factory) dan Notifiable (untuk notifikasi).
    use HasFactory;
    use Notifiable;

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
        'nama',          // Nama lengkap pasien.
        'nik',           // Nomor Induk Kependudukan (NIK) pasien.
        'tanggal_lahir', // Tanggal lahir pasien.
        'no_whatsapp',   // Nomor WhatsApp pasien untuk komunikasi.
        'verifikasi',    // Status verifikasi pasien (boolean: true/false).
        'no_erm',        // Nomor Rekam Medis Elektronik (No. ERM) pasien. Pastikan kolom ini sudah ada di tabel.
    ];

    /**
     * $hidden
     *
     * **Tujuan:** Mendefinisikan atribut-atribut (kolom) yang seharusnya disembunyikan
     * saat model diubah menjadi array atau JSON. Ini sangat berguna untuk menyembunyikan
     * data sensitif seperti password atau token.
     *
     * @var array<int, string> Daftar kolom yang akan disembunyikan.
     */
    protected $hidden = [
        'remember_token', // Token untuk fitur "ingat saya" saat login.
    ];

    /**
     * $casts
     *
     * **Tujuan:** Mendefinisikan tipe data native PHP yang seharusnya dijadikan (cast) atribut tertentu.
     * Ini membantu dalam penanganan data, misalnya mengubah string tanggal dari database menjadi objek Carbon,
     * atau angka 0/1 menjadi boolean.
     *
     * @var array<string, string> Daftar kolom dengan tipe data casting.
     */
    protected $casts = [
        'tanggal_lahir' => 'date',   // Mengubah string tanggal_lahir dari DB menjadi objek Carbon (tanggal).
        'verifikasi' => 'boolean',   // Mengubah nilai 0/1 dari DB menjadi boolean (true/false).
    ];

    /**
     * hasilUjiTB()
     *
     * **Tujuan:** Mendefinisikan relasi "one-to-many" (hasMany) dengan model `HasilUjiTB`.
     * Ini berarti satu `Pasien` dapat memiliki banyak `HasilUjiTB`.
     * Dengan relasi ini, Anda bisa dengan mudah mendapatkan semua hasil uji TB yang dimiliki oleh pasien ini.
     * Contoh: `$pasien->hasilUjiTB` akan mengembalikan koleksi semua hasil uji TB pasien tersebut.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Relasi dengan model HasilUjiTB.
     */
    public function hasilUjiTB()
    {
        // Menyatakan bahwa model Pasien 'memiliki banyak' (has many) model HasilUjiTB.
        // Eloquent akan mencari kolom `pasien_id` di tabel `hasil_uji_tb`
        // yang cocok dengan kolom `id` dari tabel `pasiens` ini.
        return $this->hasMany(HasilUjiTB::class);
    }
}
