<?php

// Nama File   = [timestamp]_create_hasil_uji_tb_table.php
// Deskripsi   = Migrasi ini bertanggung jawab untuk membuat tabel 'hasil_uji_tb' di database.
//               Tabel ini akan menyimpan semua data hasil pemeriksaan Tuberkulosis (TB),
//               termasuk detail pasien dan staf yang terkait, tanggal uji, status hasil, dan lokasi file.
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
     * Fungsi ini bertanggung jawab untuk membuat tabel 'hasil_uji_tb' dan kolom-kolomnya,
     * termasuk mendefinisikan foreign key.
     *
     * @return void
     */
    public function up(): void
    {
        // `Schema::create('hasil_uji_tb', function (Blueprint $table) { ... });`
        // Perintah ini akan membuat tabel baru bernama 'hasil_uji_tb' di database.
        // Callback function di dalamnya mendefinisikan struktur kolom tabel.
        Schema::create('hasil_uji_tb', function (Blueprint $table) {
            // `$table->id();`
            // Membuat kolom 'id' yang otomatis menjadi PRIMARY KEY, auto-incrementing,
            // dan bertipe BIGINT UNSIGNED. Ini adalah konvensi Laravel untuk ID tabel.
            $table->id();

            // `$table->unsignedBigInteger('pasien_id');`
            // Membuat kolom 'pasien_id' bertipe UNSIGNED BIGINT. Ini akan menjadi foreign key
            // yang merujuk ke tabel 'pasiens'. `unsigned` memastikan nilainya positif.
            $table->unsignedBigInteger('pasien_id');

            // `$table->unsignedBigInteger('staf_id')->nullable();`
            // Membuat kolom 'staf_id' bertipe UNSIGNED BIGINT. Ini akan menjadi foreign key
            // yang merujuk ke tabel 'staf'.
            // `nullable()`: Kolom ini boleh kosong, yang berarti hasil uji bisa saja tidak
            //               langsung terkait dengan staf tertentu saat dibuat.
            $table->unsignedBigInteger('staf_id')->nullable(); // staf yang menginput data

            // `$table->date('tanggal_uji');`
            // Membuat kolom 'tanggal_uji' (tanggal dilakukannya pemeriksaan) bertipe DATE.
            // Kolom ini WAJIB diisi.
            $table->date('tanggal_uji');

            // `$table->date('tanggal_upload')->nullable();`
            // Membuat kolom 'tanggal_upload' (tanggal file hasil uji diunggah) bertipe DATE.
            // `nullable()`: Kolom ini boleh kosong.
            $table->date('tanggal_upload')->nullable();

            // `$table->string('status');`
            // Membuat kolom 'status' (hasil pemeriksaan, contoh: 'Negatif', 'Positif') bertipe STRING.
            // Kolom ini WAJIB diisi.
            $table->string('status'); // Contoh: Negatif / Positif

            // `$table->string('file')->nullable();`
            // Membuat kolom 'file' (path atau nama file hasil uji, misal PDF atau gambar) bertipe STRING.
            // `nullable()`: Kolom ini boleh kosong.
            $table->string('file')->nullable(); // untuk file PDF atau gambar hasil uji

            // `$table->timestamps();`
            // Membuat dua kolom otomatis: 'created_at' dan 'updated_at'.
            // 'created_at': Otomatis diisi dengan timestamp saat baris dibuat.
            // 'updated_at': Otomatis diperbarui dengan timestamp saat baris diperbarui.
            $table->timestamps();

            // ==========================================================
            // Definisi Foreign Key (Kunci Asing)
            // ==========================================================

            // `$table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');`
            // Mendefinisikan 'pasien_id' sebagai foreign key yang merujuk
            // ke kolom 'id' di tabel 'pasiens'.
            // `onDelete('cascade')`: Jika sebuah pasien dihapus dari tabel 'pasiens',
            //                     semua baris di tabel 'hasil_uji_tb' yang terkait dengan pasien tersebut
            //                     juga akan otomatis dihapus (cascade delete).
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');

            // `$table->foreign('staf_id')->references('id')->on('staf')->onDelete('cascade');`
            // Mendefinisikan 'staf_id' sebagai foreign key yang merujuk
            // ke kolom 'id' di tabel 'staf'.
            // `onDelete('cascade')`: Jika seorang staf dihapus dari tabel 'staf',
            //                     semua baris di tabel 'hasil_uji_tb' yang terkait dengan staf tersebut
            //                     juga akan otomatis dihapus.
            $table->foreign('staf_id')->references('id')->on('staf')->onDelete('cascade');
        });
    }

    /**
     * down()
     *
     * **Tujuan:** Mengembalikan (rollback) migrasi. Ini adalah metode yang akan dieksekusi
     * ketika Anda menjalankan perintah `php artisan migrate:rollback`.
     * Fungsi ini bertanggung jawab untuk menghapus tabel 'hasil_uji_tb' yang dibuat di metode `up()`.
     * Penting: Foreign key harus dihapus terlebih dahulu sebelum tabel induk.
     *
     * @return void
     */
    public function down(): void
    {
        // `Schema::dropIfExists('hasil_uji_tb');`
        // Perintah ini akan menghapus tabel 'hasil_uji_tb' dari database jika tabel tersebut ada.
        Schema::dropIfExists('hasil_uji_tb');
    }
};