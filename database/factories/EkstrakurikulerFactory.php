<?php

namespace Database\Factories;

use App\Models\Ekstrakurikuler;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EkstrakurikulerFactory extends Factory
{
    protected $model = Ekstrakurikuler::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'nama' => Str::title($name),
            'slug' => Str::slug($name),
            'deskripsi' => fake()->paragraph(),
            'pembina' => fake()->name(),
            'jadwal' => 'Sabtu, 08.00-10.00',
            'gambar' => null,
            'urutan' => 0,
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
