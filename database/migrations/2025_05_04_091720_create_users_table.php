<?php

// Nama File   = create_users_table.php
// Deskripsi   = Migrasi ini bertanggung jawab untuk membuat tabel 'users' di database.
//               Tabel ini akan menyimpan informasi dasar pengguna sistem, termasuk kredensial login,
//               peran, dan relasi ke tabel 'pasiens' atau 'staf'.
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
     * Fungsi ini bertanggung jawab untuk membuat tabel 'users' dan kolom-kolomnya,
     * termasuk mendefinisikan foreign key.
     *
     * @return void
     */
    public function up(): void
    {
        // `Schema::create('users', function (Blueprint $table) { ... });`
        // Perintah ini akan membuat tabel baru bernama 'users' di database.
        // Callback function di dalamnya mendefinisikan struktur kolom tabel.
        Schema::create('users', function (Blueprint $table) {
            // `$table->id();`
            // Membuat kolom 'id' yang otomatis menjadi PRIMARY KEY, auto-incrementing,
            // dan bertipe BIGINT UNSIGNED. Ini adalah konvensi Laravel untuk ID tabel.
            $table->id();

            // `$table->string('name');`
            // Membuat kolom 'name' (nama pengguna) bertipe STRING.
            // Kolom ini WAJIB diisi.
            $table->string('name');

            // `$table->string('email')->nullable()->unique();`
            // Membuat kolom 'email' (alamat email pengguna) bertipe STRING.
            // `nullable()`: Kolom ini boleh kosong.
            // `unique()`: Setiap nilai di kolom ini harus unik (tidak boleh ada email yang sama).
            $table->string('email')->nullable()->unique();

            // `$table->timestamp('email_verified_at')->nullable();`
            // Membuat kolom 'email_verified_at' bertipe TIMESTAMP.
            // Digunakan untuk menandai kapan email pengguna diverifikasi.
            // `nullable()`: Kolom ini boleh kosong jika email belum diverifikasi.
            $table->timestamp('email_verified_at')->nullable();

            // `$table->string('password')->nullable();`
            // Membuat kolom 'password' bertipe STRING.
            // `nullable()`: Kolom ini boleh kosong. (Mungkin diisi nanti atau ada mekanisme login lain).
            $table->string('password')->nullable();

            // `$table->enum('role', ['pasien', 'staf', 'laboran', 'rekam_medis', 'admin']);`
            // Membuat kolom 'role' (peran pengguna) dengan tipe ENUM.
            // Nilai kolom ini hanya bisa salah satu dari yang disebutkan dalam array.
            // Ini adalah perbaikan untuk memastikan semua peran yang valid ada.
            $table->enum('role', ['pasien', 'staf', 'laboran', 'rekam_medis', 'admin']);

            // `$table->unsignedBigInteger('pasien_id')->nullable();`
            // Membuat kolom 'pasien_id' bertipe UNSIGNED BIGINT.
            // Ini akan menjadi foreign key yang merujuk ke tabel 'pasiens'.
            // `nullable()`: Kolom ini boleh kosong, karena tidak semua user adalah pasien.
            $table->unsignedBigInteger('pasien_id')->nullable();

            // `$table->unsignedBigInteger('staf_id')->nullable();`
            // Membuat kolom 'staf_id' bertipe UNSIGNED BIGINT.
            // Ini akan menjadi foreign key yang merujuk ke tabel 'staf'.
            // `nullable()`: Kolom ini boleh kosong, karena tidak semua user adalah staf.
            $table->unsignedBigInteger('staf_id')->nullable();

            // ==========================================================
            // Definisi Foreign Key (Kunci Asing)
            // ==========================================================

            // `$table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');`
            // Mendefinisikan 'pasien_id' sebagai foreign key yang merujuk
            // ke kolom 'id' di tabel 'pasiens'.
            // `onDelete('cascade')`: Jika sebuah pasien dihapus, user terkait juga dihapus.
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');

            // `$table->foreign('staf_id')->references('id')->on('staf')->onDelete('cascade');`
            // Mendefinisikan 'staf_id' sebagai foreign key yang merujuk
            // ke kolom 'id' di tabel 'staf'.
            // `onDelete('cascade')`: Jika seorang staf dihapus, user terkait juga dihapus.
            $table->foreign('staf_id')->references('id')->on('staf')->onDelete('cascade');

            // `$table->rememberToken();`
            // Membuat kolom 'remember_token' bertipe STRING (VARCHAR(100)).
            // Digunakan oleh fitur "ingat saya" pada saat login.
            $table->rememberToken();

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
     * Fungsi ini bertanggung jawab untuk menghapus tabel 'users' yang dibuat di metode `up()`.
     * Penting: Foreign key harus dihapus terlebih dahulu sebelum tabel induk.
     *
     * @return void
     */
    public function down(): void
    {
        // `Schema::dropIfExists('users');`
        // Perintah ini akan menghapus tabel 'users' dari database jika tabel tersebut ada.
        Schema::dropIfExists('users');
    }
};