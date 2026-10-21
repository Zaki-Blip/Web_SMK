<?php

namespace Database\Factories;

use App\Models\AlurPkl;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AlurPkl>
 */
class AlurPklFactory extends Factory
{
    protected $model = AlurPkl::class;

    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(3),
            'deskripsi' => fake()->paragraph(),
            'urutan' => fake()->numberBetween(0, 20),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
