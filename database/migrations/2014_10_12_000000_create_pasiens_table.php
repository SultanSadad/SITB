<?php

// Nama File   = create_pasiens_table.php 
// Deskripsi   = Migrasi ini bertanggung jawab untuk membuat tabel 'pasiens' di database.
//               Tabel ini akan menyimpan data detail pasien, seperti NIK, nomor rekam medis, nama, dll.
// Dibuat oleh = Salma Aulia - 3312301096
// Tanggal     = 1 April 2025

use Illuminate\Database\Migrations\Migration; // Import kelas dasar Migration.
use Illuminate\Database\Schema\Blueprint; // Import kelas Blueprint untuk mendefinisikan struktur tabel.
use Illuminate\Support\Facades\Schema; // Import Facade Schema untuk berinteraksi dengan skema database.

return new class extends Migration
{
    /**
     * up()
     *
     * **Tujuan:** Menjalankan migrasi. Ini adalah metode yang akan dieksekusi
     * ketika Anda menjalankan perintah `php artisan migrate`.
     * Fungsi ini bertanggung jawab untuk membuat tabel dan kolom-kolomnya.
     *
     * @return void
     */
    public function up(): void
    {
        // `Schema::create('pasiens', function (Blueprint $table) { ... });`
        // Perintah ini akan membuat tabel baru bernama 'pasiens' di database.
        // Callback function di dalamnya mendefinisikan struktur kolom tabel.
        Schema::create('pasiens', function (Blueprint $table) {
            // `$table->id();`
            // Membuat kolom 'id' yang otomatis menjadi PRIMARY KEY, auto-incrementing,
            // dan bertipe BIGINT UNSIGNED. Ini adalah konvensi Laravel untuk ID tabel.
            $table->id();

            // `$table->string('nik')->nullable()->unique();`
            // Membuat kolom 'nik' (Nomor Induk Kependudukan) bertipe STRING (VARCHAR).
            // `nullable()`: Kolom ini boleh kosong (tidak wajib diisi).
            // `unique()`: Setiap nilai di kolom ini harus unik (tidak boleh ada NIK yang sama).
            $table->string('nik')->nullable()->unique();

            // `$table->string('no_erm')->nullable()->unique();`
            // Membuat kolom 'no_erm' (Nomor Rekam Medis Elektronik) bertipe STRING.
            // `nullable()`: Kolom ini boleh kosong.
            // `unique()`: Setiap nilai di kolom ini harus unik.
            $table->string('no_erm')->nullable()->unique();

            // `$table->string('nama')->nullable();`
            // Membuat kolom 'nama' (nama lengkap pasien) bertipe STRING.
            // `nullable()`: Kolom ini boleh kosong.
            $table->string('nama')->nullable();

            // `$table->date('tgl_lahir')->nullable();`
            // Membuat kolom 'tgl_lahir' (tanggal lahir pasien) bertipe DATE.
            // `nullable()`: Kolom ini boleh kosong.
            $table->date('tgl_lahir')->nullable();

            // `$table->string('no_whatsapp')->nullable();`
            // Membuat kolom 'no_whatsapp' (nomor WhatsApp pasien) bertipe STRING.
            // `nullable()`: Kolom ini boleh kosong.
            $table->string('no_whatsapp')->nullable();

            // `$table->timestamps();`
            // Membuat dua kolom otomatis: 'created_at' dan 'updated_at'.
            // 'created_at': Otomatis diisi dengan timestamp saat baris dibuat.
            // 'updated_at': Otomatis diperbarui dengan timestamp saat baris diperbarui.
            $table->timestamps();
        });
    }

    /**
     * down()
     *
     * **Tujuan:** Mengembalikan (rollback) migrasi. Ini adalah metode yang akan dieksekusi
     * ketika Anda menjalankan perintah `php artisan migrate:rollback`.
     * Fungsi ini bertanggung jawab untuk menghapus tabel yang dibuat di metode `up()`.
     *
     * @return void
     */
    public function down(): void
    {
        // `Schema::dropIfExists('pasiens');`
        // Perintah ini akan menghapus tabel 'pasiens' dari database jika tabel tersebut ada.
        Schema::dropIfExists('pasiens');
    }
};