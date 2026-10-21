<?php

namespace Database\Factories;

use App\Models\Prestasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrestasiFactory extends Factory
{
    protected $model = Prestasi::class;

    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(4),
            'tingkat' => 'nasional',
            'tahun' => (int) now()->year,
            'peraih' => fake()->name(),
            'deskripsi' => fake()->paragraph(),
            'gambar' => null,
            'is_active' => true,
        ];
    }
}
