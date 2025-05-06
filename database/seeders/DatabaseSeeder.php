<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Dummy Pasien
        $pasienId = DB::table('pasiens')->insertGetId([
            'nik' => '1234567890123456',
            'no_erm' => 'ERM001',
            'nama' => 'Ahmad Pasien',
            'tgl_lahir' => '2000-01-01',
            'no_whatsapp' => '081234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Ahmad Pasien',
            'email' => null,
            'password' => null,
            'role' => 'pasien',
            'profile_id' => $pasienId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Dummy Staf: Laboran
        $laboranId = DB::table('staf')->insertGetId([
            'nip' => 'LBR001',
            'nama' => 'Siti Laboran',
            'email' => 'laboran@example.com',
            'peran' => 'laboran',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Siti Laboran',
            'email' => 'laboran@example.com',
            'password' => Hash::make('password'),
            'role' => 'staf',
            'profile_id' => $laboranId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Dummy Staf: Petugas Rekam Medis
        $rekamId = DB::table('staf')->insertGetId([
            'nip' => 'RM001',
            'nama' => 'Budi Rekam',
            'email' => 'rekam@example.com',
            'peran' => 'rekam_medis',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Budi Rekam',
            'email' => 'rekam@example.com',
            'password' => Hash::make('password'),
            'role' => 'staf',
            'profile_id' => $rekamId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
