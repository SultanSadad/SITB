<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pasien extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'nik',
        'tanggal_lahir',
        'no_whatsapp',
        'verifikasi',
        'no_erm', // Make sure this is included
    ];
    
    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    

    public function hasilUjiTB()
    {
        return $this->hasMany(HasilUjiTB::class);
    }
}