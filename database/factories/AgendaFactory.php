<?php

namespace Database\Factories;

use App\Models\Agenda;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Agenda>
 */
class AgendaFactory extends Factory
{
    protected $model = Agenda::class;

    public function definition(): array
    {
        $judul = Str::title(fake()->unique()->words(4, true));
        $mulai = fake()->dateTimeBetween('now', '+2 months');

        return [
            'judul' => $judul,
            'slug' => Str::slug($judul),
            'deskripsi' => fake()->paragraph(),
            'mulai' => $mulai,
            'selesai' => null,
            'lokasi' => 'SMKN 64 Jakarta',
            'is_published' => true,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['is_published' => false]);
    }
}
