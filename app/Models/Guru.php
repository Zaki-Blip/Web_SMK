<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable(['nama', 'jabatan', 'tipe', 'mata_pelajaran', 'jurusan_id', 'foto', 'urutan', 'is_active'])]
class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'urutan' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('urutan')->orderBy('nama');
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
