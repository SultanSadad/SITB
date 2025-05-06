<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('staf', function (Blueprint $table) {
        $table->string('no_whatsapp')->nullable();
    });
}

public function down()
{
    Schema::table('staf', function (Blueprint $table) {
        $table->dropColumn('no_whatsapp');
    });
}

};
