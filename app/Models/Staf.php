<?php

// Nama File   = Staf.php
// Deskripsi   = Model ini merepresentasikan tabel 'staf' di database.
//               Kelas ini juga berfungsi sebagai model untuk autentikasi staf (login),
//               memungkinkan staf (seperti rekam medis atau laboran) untuk masuk ke sistem.
// Dibuat oleh = Salma Aulia - 3312301096
// Tanggal     = 1 april 2025

namespace App\Models;

// Menentukan lokasi (namespace) dari model ini.

use Illuminate\Database\Eloquent\Factories\HasFactory; // Import trait HasFactory untuk mendukung factory model (untuk seeding/pengujian).
use Illuminate\Foundation\Auth\User as Authenticatable; // Import kelas Authenticatable, yang merupakan dasar untuk model yang bisa diotentikasi (login).
use Illuminate\Notifications\Notifiable;

// Import trait Notifiable untuk mengaktifkan fitur notifikasi.

class Staf extends Authenticatable
{
    // Menggunakan trait HasFactory (untuk seeding/factory) dan Notifiable (untuk notifikasi).
    use HasFactory;
    use Notifiable;

    /**
     * $table
     *
     * **Tujuan:** Mendefinisikan nama tabel di database yang terhubung dengan model ini.
     * Secara default, Eloquent akan menggunakan bentuk plural dari nama model (misal: 'stafs').
     * Namun, jika nama tabel Anda berbeda, Anda harus menentukannya secara eksplisit di sini.
     *
     * @var string Nama tabel database.
     */
    protected $table = 'staf'; // Menentukan bahwa model ini terhubung ke tabel bernama 'staf'.

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
        'nama',          // Nama lengkap staf.
        'nip',           // Nomor Induk Pegawai (NIP) staf.
        'email',         // Alamat email staf (biasanya digunakan untuk login).
        'no_whatsapp',   // Nomor WhatsApp staf untuk komunikasi.
        'peran',         // Peran staf (misal: 'rekam_medis', 'laboran', 'admin').
        'password',      // Password staf (akan di-hash sebelum disimpan).
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
        'password',       // Password harus selalu disembunyikan untuk keamanan.
        'remember_token', // Token untuk fitur "ingat saya" saat login.
    ];

    /**
     * $casts
     *
     * **Tujuan:** Mendefinisikan tipe data native PHP yang seharusnya dijadikan (cast) atribut tertentu.
     * Ini membantu dalam penanganan data, misalnya mengubah string datetime dari database menjadi objek Carbon.
     *
     * @var array<string, string> Daftar kolom dengan tipe data casting.
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Mengubah nilai kolom ini menjadi objek DateTime (Carbon).
    ];

    /**
     * hasilUji()
     *
     * **Tujuan:** Mendefinisikan relasi "one-to-many" (hasMany) dengan model `HasilUjiTB`.
     * Ini berarti satu `Staf` dapat menginput (memiliki) banyak `HasilUjiTB`.
     * Dengan relasi ini, Anda bisa dengan mudah mendapatkan semua hasil uji TB yang diinput oleh staf ini.
     * Contoh: `$staf->hasilUji` akan mengembalikan koleksi semua hasil uji TB yang diinput staf tersebut.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Relasi dengan model HasilUjiTB.
     */
    public function hasilUji()
    {
        // Menyatakan bahwa model Staf 'memiliki banyak' (has many) model HasilUjiTB.
        // Parameter kedua ('staf_id') secara eksplisit menunjukkan kolom foreign key
        // di tabel `hasil_uji_tb` yang merujuk kembali ke tabel `staf`.
        return $this->hasMany(HasilUjiTB::class, 'staf_id');
    }
}
