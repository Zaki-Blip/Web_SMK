<?php

namespace Database\Factories;

use App\Models\GalleryItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<GalleryItem>
 */
class GalleryItemFactory extends Factory
{
    protected $model = GalleryItem::class;

    public function definition(): array
    {
        return [
            'title' => Str::title(fake()->unique()->words(3, true)),
            'caption' => fake()->sentence(),
            'image_path' => 'gallery/'.fake()->unique()->uuid().'.jpg',
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
