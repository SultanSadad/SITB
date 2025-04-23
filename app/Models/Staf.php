<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staf extends Model
{
    use HasFactory;

    protected $table = 'staf'; // menentukan nama tabel yang sebenarnya
    
    protected $fillable = [
        'nama',
        'nip',
        'email',
        'no_whatsapp',
        'role', // laboran atau rekammedis
        'password',
    ];
    
    // Sembunyikan password dari JSON/array output
    protected $hidden = [
        'password',
    ];
}