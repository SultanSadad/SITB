<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilUjiTB extends Model
{
    use HasFactory;

    protected $table = 'hasil_uji_tb';

    protected $fillable = [
        'pasien_id',
        'staf_id',
        'tanggal_uji',
        'tanggal_upload',
        'status',
        'file',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function staf()
    {
        return $this->belongsTo(Staf::class);
    }
}
