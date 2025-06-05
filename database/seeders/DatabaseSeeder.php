<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Dummy Pasien
        $pasienId = DB::table('pasiens')->insertGetId([
            'nik' => '1234567890123456',
            'no_erm' => 'ERM001',
            'nama' => 'Ahmad Pasien',
            'tanggal_lahir' => '2000-01-01',
            'no_whatsapp' => '081234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Dummy Staf: Laboran
        $laboranId = DB::table('staf')->insertGetId([
            'nip' => 'LBR001',
            'nama' => 'Siti Laboran',
            'email' => 'laboran@example.com',
            'no_whatsapp' => '081234567891',
            'peran' => 'laboran',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Dummy Staf: Petugas Rekam Medis
        $rekamId = DB::table('staf')->insertGetId([
            'nip' => 'RM001',
            'nama' => 'Budi Rekam',
            'email' => 'rekam@example.com',
            'no_whatsapp' => '081234567892',
            'peran' => 'rekam_medis',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Users (tanpa profile_id, langsung staf/pasien_id nanti)
        DB::table('users')->insert([
            [
                'name' => 'Ahmad Pasien',
                'email' => null,
                'password' => null,
                'role' => 'pasien',
                'pasien_id' => $pasienId,
                'staf_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Laboran',
                'email' => 'laboran@example.com',
                'password' => Hash::make('password'),
                'role' => 'staf',
                'pasien_id' => null,
                'staf_id' => $laboranId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Rekam',
                'email' => 'rekam@example.com',
                'password' => Hash::make('password'),
                'role' => 'staf',
                'pasien_id' => null,
                'staf_id' => $rekamId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Dummy hasil uji TB
        DB::table('hasil_uji_tb')->insert([
            'pasien_id' => $pasienId,
            'staf_id' => $laboranId,
            'tanggal_uji' => '2024-05-01',
            'tanggal_upload' => now(),
            'status' => 'Negatif',
            'file' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
