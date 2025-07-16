<?php

// Nama File   = alter_hasil_uji_tb_make_status_nullable.php 
// Deskripsi   = Migrasi ini bertanggung jawab untuk mengubah kolom 'status'
//               pada tabel 'hasil_uji_tb' agar bisa bernilai NULL (kosong).
//               Sebelumnya, kolom ini kemungkinan wajib diisi.
// Dibuat oleh = Salma Aulia - 3312301096
// Tanggal     = 1 april 2025

use Illuminate\Database\Migrations\Migration; // Import kelas dasar Migration.
use Illuminate\Database\Schema\Blueprint; // Import kelas Blueprint untuk mendefinisikan struktur tabel.
use Illuminate\Support\Facades\Schema; // Import Facade Schema untuk berinteraksi dengan skema database.

class AlterHasilUjiTbMakeStatusNullable extends Migration
{
    /**
     * up()
     *
     * **Tujuan:** Menjalankan migrasi. Ini adalah metode yang akan dieksekusi
     * ketika Anda menjalankan perintah `php artisan migrate`.
     * Fungsi ini bertanggung jawab untuk mengubah kolom 'status' menjadi nullable.
     *
     * @return void
     */
    public function up()
    {
        // `Schema::table('hasil_uji_tb', function (Blueprint $table) { ... });`
        // Perintah ini akan memodifikasi tabel yang sudah ada bernama 'hasil_uji_tb'.
        // Callback function di dalamnya mendefinisikan perubahan pada kolom tabel.
        Schema::table('hasil_uji_tb', function (Blueprint $table) {
            // `$table->string('status')->nullable()->change();`
            // Mengubah kolom 'status' yang sudah ada.
            // `nullable()`: Menetapkan bahwa kolom 'status' sekarang boleh berisi nilai NULL (kosong).
            // `change()`: Perintah ini penting untuk memberitahu Laravel bahwa Anda ingin mengubah
            //             definisi kolom yang sudah ada, bukan menambah kolom baru.
            $table->string('status')->nullable()->change();
        });
    }

    /**
     * down()
     *
     * **Tujuan:** Mengembalikan (rollback) migrasi. Ini adalah metode yang akan dieksekusi
     * ketika Anda menjalankan perintah `php artisan migrate:rollback`.
     * Fungsi ini bertanggung jawab untuk mengembalikan kolom 'status' agar kembali tidak nullable.
     *
     * @return void
     */
    public function down()
    {
        // `Schema::table('hasil_uji_tb', function (Blueprint $table) { ... });`
        // Perintah ini akan memodifikasi kembali tabel 'hasil_uji_tb'.
        Schema::table('hasil_uji_tb', function (Blueprint $table) {
            // `$table->string('status')->nullable(false)->change();`
            // Mengembalikan kolom 'status' ke kondisi sebelumnya, yaitu tidak boleh NULL.
            // `nullable(false)`: Menetapkan bahwa kolom 'status' tidak boleh berisi nilai NULL.
            // `change()`: Perintah ini untuk mengubah definisi kolom yang sudah ada.
            $table->string('status')->nullable(false)->change();
        });
    }
}