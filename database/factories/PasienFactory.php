<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PasienFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nik' => $this->faker->unique()->numerify('###############'),
            'no_erm' => $this->faker->unique()->numerify('ERM###'),
            'nama' => $this->faker->name(),
            'tanggal_lahir' => $this->faker->date(),
            'no_whatsapp' => $this->faker->unique()->numerify('08##########'),
        ];
    }
}
