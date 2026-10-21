<?php

namespace Database\Factories;

use App\Models\Unduhan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Unduhan>
 */
class UnduhanFactory extends Factory
{
    protected $model = Unduhan::class;

    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(3),
            'deskripsi' => fake()->paragraph(),
            'berkas' => 'unduhan/contoh.pdf',
            'ukuran' => fake()->numberBetween(1024, 1048576),
            'is_published' => true,
            'urutan' => fake()->numberBetween(0, 20),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['is_published' => false]);
    }
}
