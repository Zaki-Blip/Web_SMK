<?php

namespace Database\Factories;

use App\Models\MitraIndustri;
use Illuminate\Database\Eloquent\Factories\Factory;

class MitraIndustriFactory extends Factory
{
    protected $model = MitraIndustri::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->company(),
            'bidang' => fake()->word(),
            'logo' => null,
            'website' => fake()->url(),
            'urutan' => 0,
            'is_active' => true,
        ];
    }
}
