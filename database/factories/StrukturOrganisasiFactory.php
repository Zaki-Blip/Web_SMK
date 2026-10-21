<?php

namespace Database\Factories;

use App\Models\StrukturOrganisasi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StrukturOrganisasi>
 */
class StrukturOrganisasiFactory extends Factory
{
    protected $model = StrukturOrganisasi::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'jabatan' => fake()->randomElement(['Kepala Sekolah', 'Wakil Kepala', 'Kepala Tata Usaha', 'Guru']),
            'parent_id' => null,
            'urutan' => fake()->numberBetween(0, 20),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
