<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterHasilUjiTbMakeStatusNullable extends Migration
{
    public function up()
    {
        Schema::table('hasil_uji_tb', function (Blueprint $table) {
            $table->string('status')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('hasil_uji_tb', function (Blueprint $table) {
            $table->string('status')->nullable(false)->change();
        });
    }
}

