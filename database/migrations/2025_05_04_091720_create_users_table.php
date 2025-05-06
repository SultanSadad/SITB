<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('role', ['pasien', 'staf']);

            // profile_id mengarah ke 'pasiens' jika role == 'pasien'
            // profile_id mengarah ke 'staf' jika role == 'staf'
            // Tidak perlu foreign key strict karena profile_id fleksibel ke dua tabel yang berbeda
            $table->unsignedBigInteger('profile_id'); 
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
