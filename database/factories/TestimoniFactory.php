<?php

namespace Database\Factories;

use App\Models\Testimoni;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimoniFactory extends Factory
{
    protected $model = Testimoni::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'angkatan' => '2023',
            'jurusan_id' => null,
            'pekerjaan_saat_ini' => fake()->jobTitle(),
            'isi' => fake()->paragraph(),
            'foto' => null,
            'is_active' => true,
        ];
    }
}
