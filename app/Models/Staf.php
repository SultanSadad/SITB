<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staf extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'staf';

    protected $fillable = [
        'nama',
        'nip',
        'email',
        'no_whatsapp',
        'peran',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi ke hasil uji TB yang diinput oleh staf ini.
     */
    public function hasilUji()
    {
        return $this->hasMany(HasilUjiTB::class, 'staf_id');
    }
}
