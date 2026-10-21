<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['tahun_ajaran', 'jalur', 'syarat', 'alur', 'jadwal', 'tautan_pendaftaran', 'kontak_panitia', 'is_open'])]
class Spmb extends Model
{
    protected $table = 'spmb';

    protected function casts(): array
    {
        return [
            'jalur' => 'array',
            'alur' => 'array',
            'jadwal' => 'array',
            'is_open' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
