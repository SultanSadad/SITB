<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = ['nama', 'nik', 'tanggal_lahir', 'no_whatsapp'];
}
