<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\HasilUjiTB;
use App\Models\Pasien;
use App\Models\Staf;

class HasilUjiTBFactory extends Factory
{
    protected $model = HasilUjiTB::class;

    public function definition()
    {
        return [
            'pasien_id' => Pasien::factory(), // auto create pasien jika belum diset manual
            'staf_id' => Staf::factory(),     // auto create staf jika belum diset
            'tanggal_uji' => $this->faker->date(),
            'tanggal_upload' => $this->faker->date(),
            'file' => 'dummy.pdf', // bisa ganti saat test upload
        ];
    }
}
