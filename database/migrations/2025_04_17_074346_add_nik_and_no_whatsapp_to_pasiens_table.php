<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('pasiens', function (Blueprint $table) {
        $table->string('nik')->unique()->nullable(false)->change(); // ganti jadi NOT NULL
    });
}


public function down()
{
    Schema::table('pasiens', function (Blueprint $table) {
        $table->dropColumn(['nik', 'no_whatsapp']);
    });
}

};
