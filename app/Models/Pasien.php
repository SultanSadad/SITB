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
        'tanggal_lahir',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
}
