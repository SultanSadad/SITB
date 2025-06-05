<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StafFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nip' => $this->faker->unique()->numerify('NIP###'),
            'nama' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'no_whatsapp' => '08' . $this->faker->numerify('##########'),
            'peran' => 'laboran',
            'password' => bcrypt('password'),
        ];
    }
}
