<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable(['nama', 'angkatan', 'jurusan_id', 'pekerjaan_saat_ini', 'isi', 'foto', 'is_active'])]
class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'testimoni';

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('id');
    }

    public function imageUrl(): ?string
    {
        if (blank($this->foto)) {
            return null;
        }

        return Storage::disk(config('filesystems.uploads_disk', 'public'))->url($this->foto);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
