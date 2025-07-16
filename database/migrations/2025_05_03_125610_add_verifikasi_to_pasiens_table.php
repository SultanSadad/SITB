<?php

// Nama File   = add_verifikasi_to_pasiens_table.php 
// Deskripsi   = Migrasi ini bertanggung jawab untuk menambahkan kolom baru 'verifikasi'
//               ke tabel 'pasiens'. Kolom ini akan digunakan untuk menandai apakah data pasien
//               sudah diverifikasi atau belum.
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
     * Fungsi ini bertanggung jawab untuk menambahkan kolom 'verifikasi' ke tabel 'pasiens'.
     *
     * @return void
     */
    public function up(): void
    {
        // `Schema::table('pasiens', function (Blueprint $table) { ... });`
        // Perintah ini akan memodifikasi tabel yang sudah ada bernama 'pasiens'.
        // Callback function di dalamnya mendefinisikan perubahan pada kolom tabel.
        Schema::table('pasiens', function (Blueprint $table) {
            // `$table->boolean('verifikasi')->default(false);`
            // Menambahkan kolom baru bernama 'verifikasi' bertipe BOOLEAN.
            // `default(false)`: Nilai default kolom ini akan menjadi `false` (belum diverifikasi)
            //                    jika tidak ada nilai yang secara eksplisit diberikan saat data dibuat.
            $table->boolean('verifikasi')->default(false);
        });
    }

    /**
     * down()
     *
     * **Tujuan:** Mengembalikan (rollback) migrasi. Ini adalah metode yang akan dieksekusi
     * ketika Anda menjalankan perintah `php artisan migrate:rollback`.
     * Fungsi ini bertanggung jawab untuk menghapus kolom 'verifikasi' yang ditambahkan di metode `up()`.
     *
     * @return void
     */
    public function down(): void
    {
        // `Schema::table('pasiens', function (Blueprint $table) { ... });`
        // Perintah ini akan memodifikasi kembali tabel 'pasiens'.
        Schema::table('pasiens', function (Blueprint $table) {
            // `$table->dropColumn('verifikasi');`
            // Menghapus kolom 'verifikasi' dari tabel 'pasiens'.
            $table->dropColumn('verifikasi');
        });
    }
};