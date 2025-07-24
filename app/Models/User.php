<?php

// Nama File   = User.php
// Deskripsi   = Model ini merepresentasikan tabel 'users' di database.
//               Kelas ini adalah model autentikasi standar di Laravel yang bisa digunakan
//               untuk berbagai jenis pengguna. Dalam aplikasi ini, model User dapat dikaitkan
//               dengan entitas Staf atau Pasien melalui kolom staf_id atau pasien_id
//               untuk mengelola kredensial login dan peran secara terpusat.
// Dibuat oleh = Salma Aulia - 3312301096
// Tanggal     = 1 april 2025

namespace App\Models;

// Menentukan lokasi (namespace) dari model ini.

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// Trait ini dikomentari, berarti fitur verifikasi email tidak digunakan secara default.
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Import trait HasFactory untuk mendukung factory model (untuk seeding/pengujian).
use Illuminate\Foundation\Auth\User as Authenticatable;
// Import kelas Authenticatable, yang merupakan dasar untuk model yang bisa diotentikasi (login).
use Illuminate\Notifications\Notifiable; // Import trait Notifiable untuk mengaktifkan fitur notifikasi.
use Laravel\Sanctum\HasApiTokens;

// Import trait HasApiTokens dari Laravel Sanctum untuk mendukung token API.

class User extends Authenticatable
{
    // Menggunakan trait HasApiTokens (untuk API), HasFactory (untuk seeding/factory),
    // dan Notifiable (untuk notifikasi).
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * $fillable
     *
     * *Tujuan:* Mendefinisikan atribut-atribut (kolom) tabel yang dapat diisi secara massal (mass assignable).
     * Atribut yang ada di array $fillable bisa diisi menggunakan metode create() atau update()
     * dengan array data, yang merupakan praktik umum di Laravel. Ini adalah fitur keamanan untuk mencegah
     * pengisian data yang tidak diinginkan.
     *
     * @var array<int, string> Daftar kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'name',      // Nama pengguna.
        'email',     // Alamat email pengguna (biasanya unik dan digunakan untuk login).
        'password',  // Password pengguna (akan di-hash).
        'role',      // Peran pengguna (misal: 'admin', 'staf', 'pasien').
        'pasien_id', // Foreign key ke tabel 'pasiens' jika user ini adalah seorang pasien.
        'staf_id',   // Foreign key ke tabel 'staf' jika user ini adalah seorang staf.
        'hasilujiTB' // Kolom ini sepertinya tidak sesuai dengan konteks User dan fillable.
                     // Jika 'hasilujiTB' merujuk ke relasi atau data lain, mungkin lebih baik dihapus dari $fillable,
                     // atau pastikan ini adalah kolom di tabel users yang memang perlu diisi langsung.
                     // Umumnya, hasilujiTB akan menjadi relasi, bukan kolom langsung
                     // di tabel users.
                     // Jika hasilujiTB sebenarnya adalah HasilUjiTB (model), maka ini adalah
                     // penamaan yang membingungkan.
    ];

    /**
     * $hidden
     *
     * *Tujuan:* Mendefinisikan atribut-atribut (kolom) yang seharusnya disembunyikan
     * saat model diubah menjadi array atau JSON. Ini sangat berguna untuk menyembunyikan
     * data sensitif seperti password atau token otentikasi.
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
     * *Tujuan:* Mendefinisikan tipe data native PHP yang seharusnya dijadikan (cast) atribut tertentu.
     * Ini membantu dalam penanganan data, misalnya mengubah string datetime dari database menjadi objek Carbon,
     * atau mengenkripsi password secara otomatis saat diakses.
     *
     * @var array<string, string> Daftar kolom dengan tipe data casting.
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Mengubah nilai kolom ini menjadi objek DateTime (Carbon).
        'password' => 'hashed',            // Laravel akan secara otomatis mengenkripsi password ketika diset
                                           // dan memverifikasinya saat otentikasi.
    ];

    /**
     * staf()
     *
     * *Tujuan:* Mendefinisikan relasi "many-to-one" (belongsTo) dengan model Staf.
     * Ini berarti satu User dapat terkait dengan satu Staf (jika user tersebut adalah staf).
     * Relasi ini menggunakan kolom staf_id di tabel users sebagai foreign key.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relasi dengan model Staf.
     */
    public function staf()
    {
        // Menyatakan bahwa model User 'milik' (belongs to) model Staf.
        // staf_id adalah foreign key di tabel users yang merujuk ke id di tabel staf.
        return $this->belongsTo(Staf::class, 'staf_id');
    }

    /**
     * pasien()
     *
     * *Tujuan:* Mendefinisikan relasi "many-to-one" (belongsTo) dengan model Pasien.
     * Ini berarti satu User dapat terkait dengan satu Pasien (jika user tersebut adalah pasien).
     * Relasi ini menggunakan kolom pasien_id di tabel users sebagai foreign key.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relasi dengan model Pasien.
     */
    public function pasien()
    {
        // Menyatakan bahwa model User 'milik' (belongs to) model Pasien.
        // pasien_id adalah foreign key di tabel users yang merujuk ke id di tabel pasiens.
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    // Catatan: Kolom 'hasilujiTB' di $fillable mungkin dimaksudkan sebagai relasi
    //           jika model User dapat memiliki HasilUjiTB secara langsung.
    //           Namun, dari konteks pasien_id dan staf_id, biasanya HasilUjiTB
    //           akan berelasi dengan Pasien atau Staf, bukan langsung dengan User.
    //           Jika memang ada relasi langsung dari User ke HasilUjiTB, perlu ditambahkan
    //           method relasi seperti hasMany(HasilUjiTB::class) di sini.
}
