<?php

namespace Database\Factories;

use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JurusanFactory extends Factory
{
    protected $model = Jurusan::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'nama' => Str::title($name),
            'singkatan' => strtoupper(Str::slug($name, '')),
            'slug' => Str::slug($name),
            'ringkasan' => fake()->sentence(),
            'deskripsi' => fake()->paragraph(),
            'kompetensi' => ['Kompetensi 1', 'Kompetensi 2'],
            'prospek_karier' => fake()->sentence(),
            'lama_belajar' => '3 tahun',
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
