<?php

namespace Database\Factories;

use App\Models\Galeri;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Galeri>
 */
class GaleriFactory extends Factory
{
    protected $model = Galeri::class;

    public function definition(): array
    {
        return [
            'title' => Str::title(fake()->unique()->words(3, true)),
            'caption' => fake()->sentence(),
            'image_path' => 'galeri/'.fake()->unique()->uuid().'.jpg',
            'category' => fake()->randomElement(['Kegiatan', 'Kelas', 'Lingkungan']),
            'sort_order' => 0,
            'is_published' => true,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn () => ['is_published' => false]);
    }
}
