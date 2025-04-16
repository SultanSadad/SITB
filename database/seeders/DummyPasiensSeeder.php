<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyPasiensSeeder extends Seeder
{

    public function run(): void
    {
        $pasienData = [
            [
                'nama' => 'Salma',
                'tanggal_lahir' => '2004-06-27',
            ],
            [
                'nama' => 'Pipah',
                'tanggal_lahir' => '2003-10-31',
            ],
            [
                'nama' => 'Saskia',
                'tanggal_lahir' => '2005-05-25',
            ],
        ];

        foreach ($pasienData as $key => $val) {
            Pasien::create($val);
        }
    }
}
