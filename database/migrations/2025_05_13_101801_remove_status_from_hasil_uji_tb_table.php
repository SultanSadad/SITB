<?php

// Nama File   = remove_status_hasil_uji_tb.php 
// Deskripsi   = Migrasi ini adalah placeholder atau migrasi yang belum diisi.
//               Saat ini, tidak ada perubahan skema database yang dilakukan pada tabel 'hasil_uji_tb'.
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
     *
     * Saat ini, fungsi ini tidak melakukan perubahan apapun pada tabel 'hasil_uji_tb'.
     * Anda bisa menambahkan kolom, mengubah tipe kolom, atau operasi skema lainnya di sini.
     *
     * @return void
     */
    public function up(): void
    {
        // `Schema::table('hasil_uji_tb', function (Blueprint $table) { ... });`
        // Perintah ini akan memodifikasi tabel yang sudah ada bernama 'hasil_uji_tb'.
        // Namun, saat ini, callback function di dalamnya kosong,
        // sehingga tidak ada perubahan yang akan diterapkan ke tabel.
        Schema::table('hasil_uji_tb', function (Blueprint $table) {
            // Contoh perubahan yang bisa ditambahkan di sini:
            // $table->string('kolom_baru')->nullable(); // Menambah kolom baru
            // $table->dropColumn('kolom_lama'); // Menghapus kolom lama
            // $table->string('nama_kolom')->change(); // Mengubah tipe kolom
        });
    }

    /**
     * down()
     *
     * **Tujuan:** Mengembalikan (rollback) migrasi. Ini adalah metode yang akan dieksekusi
     * ketika Anda menjalankan perintah `php artisan migrate:rollback`.
     *
     * Saat ini, fungsi ini tidak melakukan rollback apapun, karena metode `up()` juga kosong.
     * Anda akan menambahkan logika untuk membalikkan perubahan yang dilakukan di `up()` di sini.
     *
     * @return void
     */
    public function down(): void
    {
        // `Schema::table('hasil_uji_tb', function (Blueprint $table) { ... });`
        // Perintah ini akan memodifikasi kembali tabel 'hasil_uji_tb'.
        // Namun, saat ini, callback function di dalamnya kosong.
        Schema::table('hasil_uji_tb', function (Blueprint $table) {
            // Contoh pembalikan perubahan (jika up() diisi):
            // $table->dropColumn('kolom_baru'); // Menghapus kolom yang ditambahkan di up()
        });
    }
};