<?php

namespace Database\Factories;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuruFactory extends Factory
{
    protected $model = Guru::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'jabatan' => 'Guru',
            'tipe' => 'guru',
            'mata_pelajaran' => fake()->word(),
            'jurusan_id' => null,
            'foto' => null,
            'urutan' => 0,
            'is_active' => true,
        ];
    }
}
