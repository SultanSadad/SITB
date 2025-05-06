<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staf extends Model
{
    use HasFactory;
    
    protected $table = 'staf';
    
    protected $fillable = [
        'nip',
        'nama',
        'email',
        'no_whatsapp',
        'peran',
    ];
    
    // Relation with User
    public function user()
    {
        return $this->hasOne(User::class, 'profile_id')->where('role', 'staf');
    }
}