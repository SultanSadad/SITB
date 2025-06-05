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
        Schema::create('hasil_uji_tb', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->unsignedBigInteger('staf_id')->nullable(); // staf yang menginput data
            $table->date('tanggal_uji');
            $table->date('tanggal_upload')->nullable();
            $table->string('status'); // Contoh: Negatif / Positif
            $table->string('file')->nullable(); // untuk file PDF atau gambar hasil uji
            $table->timestamps();

            // Foreign key relasi
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');
            $table->foreign('staf_id')->references('id')->on('staf')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_uji_tb');
    }
};
