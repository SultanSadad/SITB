<?php

// Nama File   = rename_tgl_lahir_to_tanggal_lahir_in_pasiens_table.php 
// Deskripsi   = Migrasi ini bertanggung jawab untuk mengganti nama kolom 'tgl_lahir'
//               menjadi 'tanggal_lahir' di tabel 'pasiens'. Ini dilakukan untuk
//               konsistensi penamaan kolom di database.
// Dibuat oleh = Salma Aulia - 3312301096
// Tanggal     = 1 april 2025

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
     * Fungsi ini bertanggung jawab untuk mengubah nama kolom 'tgl_lahir' menjadi 'tanggal_lahir'.
     *
     * @return void
     */
    public function up(): void
    {
        // `Schema::table('pasiens', function (Blueprint $table) { ... });`
        // Perintah ini akan memodifikasi tabel yang sudah ada bernama 'pasiens'.
        // Callback function di dalamnya mendefinisikan perubahan pada kolom tabel.
        Schema::table('pasiens', function (Blueprint $table) {
            // `$table->renameColumn('tgl_lahir', 'tanggal_lahir');`
            // Mengganti nama kolom dari 'tgl_lahir' menjadi 'tanggal_lahir'.
            $table->renameColumn('tgl_lahir', 'tanggal_lahir');
        });
    }

    /**
     * down()
     *
     * **Tujuan:** Mengembalikan (rollback) migrasi. Ini adalah metode yang akan dieksekusi
     * ketika Anda menjalankan perintah `php artisan migrate:rollback`.
     * Fungsi ini bertanggung jawab untuk mengembalikan nama kolom
     * dari 'tanggal_lahir' kembali menjadi 'tgl_lahir'.
     *
     * @return void
     */
    public function down(): void
    {
        // `Schema::table('pasiens', function (Blueprint $table) { ... });`
        // Perintah ini akan memodifikasi kembali tabel 'pasiens'.
        Schema::table('pasiens', function (Blueprint $table) {
            // `$table->renameColumn('tanggal_lahir', 'tgl_lahir');`
            // Mengembalikan nama kolom dari 'tanggal_lahir' menjadi 'tgl_lahir'.
            $table->renameColumn('tanggal_lahir', 'tgl_lahir');
        });
    }
};