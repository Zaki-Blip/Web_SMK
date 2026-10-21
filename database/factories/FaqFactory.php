<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition(): array
    {
        return [
            'pertanyaan' => fake()->sentence().'?',
            'jawaban' => fake()->paragraph(),
            'kategori' => 'umum',
            'urutan' => 0,
            'is_active' => true,
        ];
    }
}
