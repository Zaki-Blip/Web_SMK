<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        $title = Str::title(fake()->unique()->words(4, true));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->sentence(),
            'body' => fake()->paragraphs(3, true),
            'image_path' => null,
            'published_at' => now()->subDay(),
            'status' => News::STATUS_PUBLISHED,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => News::STATUS_DRAFT,
            'published_at' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn () => [
            'status' => News::STATUS_PUBLISHED,
            'published_at' => now()->addWeek(),
        ]);
    }
}
