<?php

// Nama File   = create_staf_table.php 
// Deskripsi   = Migrasi ini bertanggung jawab untuk membuat tabel 'staf' di database.
//               Tabel ini akan menyimpan data detail semua staf yang bekerja di sistem,
//               termasuk informasi login seperti email dan password.
// Dibuat oleh = Salma Aulia - 3312301096
// Tanggal     = 1 april 2025

use Illuminate\Database\Migrations\Migration; // Import kelas dasar Migration.
use Illuminate\Database\Schema\Blueprint; // Import kelas Blueprint untuk mendefinisikan struktur tabel.
use Illuminate\Support\Facades\Schema; // Import Facade Schema untuk berinteraksi dengan skema database.

return new class extends Migration {
    /**
     * up()
     *
     * **Tujuan:** Menjalankan migrasi. Metode ini akan dieksekusi
     * ketika Anda menjalankan perintah `php artisan migrate`.
     * Fungsi ini bertanggung jawab untuk membuat tabel 'staf' dan kolom-kolomnya.
     *
     * @return void
     */
    public function up(): void
    {
        // `Schema::create('staf', function (Blueprint $table) { ... });`
        // Perintah ini akan membuat tabel baru bernama 'staf' di database.
        // Callback function di dalamnya mendefinisikan struktur kolom tabel.
        Schema::create('staf', function (Blueprint $table) {
            // `$table->id();`
            // Membuat kolom 'id' yang otomatis menjadi PRIMARY KEY, auto-incrementing,
            // dan bertipe BIGINT UNSIGNED. Ini adalah konvensi Laravel untuk ID tabel.
            $table->id();

            // `$table->string('nip')->nullable();`
            // Membuat kolom 'nip' (Nomor Induk Pegawai) bertipe STRING (VARCHAR).
            // `nullable()`: Kolom ini boleh kosong (tidak wajib diisi).
            $table->string('nip')->nullable();

            // `$table->string('nama');`
            // Membuat kolom 'nama' (nama lengkap staf) bertipe STRING.
            // Kolom ini WAJIB diisi (defaultnya tidak nullable).
            $table->string('nama');

            // `$table->string('email')->unique();`
            // Membuat kolom 'email' bertipe STRING.
            // `unique()`: Setiap nilai di kolom ini harus unik (tidak boleh ada email yang sama).
            // Kolom ini WAJIB diisi.
            $table->string('email')->unique();

            // `$table->string('no_whatsapp')->nullable();`
            // Membuat kolom 'no_whatsapp' (nomor WhatsApp staf) bertipe STRING.
            // `nullable()`: Kolom ini boleh kosong.
            $table->string('no_whatsapp')->nullable();

            // `$table->string('peran');`
            // Membuat kolom 'peran' (peran staf, contoh: 'laboran' atau 'rekam_medis') bertipe STRING.
            // Kolom ini WAJIB diisi.
            $table->string('peran'); // contoh: 'laboran' atau 'rekam_medis'

            // `$table->string('password')->nullable();`
            // Membuat kolom 'password' bertipe STRING.
            // `nullable()`: Kolom ini boleh kosong. (Biasanya password wajib,
            //               tapi nullable mungkin digunakan jika password diatur setelah pembuatan akun).
            $table->string('password')->nullable();

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
     * **Tujuan:** Mengembalikan (rollback) migrasi. Metode ini akan dieksekusi
     * ketika Anda menjalankan perintah `php artisan migrate:rollback`.
     * Fungsi ini bertanggung jawab untuk menghapus tabel 'staf' yang dibuat di metode `up()`.
     *
     * @return void
     */
    public function down(): void
    {
        // `Schema::dropIfExists('staf');`
        // Perintah ini akan menghapus tabel 'staf' dari database jika tabel tersebut ada.
        Schema::dropIfExists('staf');
    }
};