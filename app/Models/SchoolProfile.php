<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['school_name', 'history', 'vision', 'mission', 'description'])]
class SchoolProfile extends Model
{
    /**
     * Profil sekolah hanya satu record. Dipakai halaman publik dan dashboard.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
