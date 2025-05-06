<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilUjiTB extends Model
{
    protected $table = 'hasil_uji_tb';

    protected $fillable = [
        'pasien_id', 'tanggal_uji', 'tanggal_upload', 'file'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}

