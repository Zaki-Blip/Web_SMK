<?php

namespace Database\Factories;

use App\Models\LowonganBkk;
use Illuminate\Database\Eloquent\Factories\Factory;

class LowonganBkkFactory extends Factory
{
    protected $model = LowonganBkk::class;

    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(4),
            'perusahaan' => fake()->company(),
            'lokasi' => fake()->city(),
            'tipe' => 'penuh_waktu',
            'deskripsi' => fake()->paragraph(),
            'persyaratan' => fake()->sentence(),
            'tautan_daftar' => null,
            'batas_waktu' => now()->addMonth()->toDateString(),
            'is_published' => true,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn () => ['is_published' => false]);
    }

    public function expired(): static
    {
        return $this->state(fn () => ['batas_waktu' => now()->subDay()->toDateString()]);
    }
}
