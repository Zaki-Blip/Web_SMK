<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable(['judul', 'tingkat', 'tahun', 'peraih', 'deskripsi', 'gambar', 'is_active'])]
class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'tahun' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('tahun')->orderBy('judul');
    }

    public function imageUrl(): ?string
    {
        if (blank($this->gambar)) {
            return null;
        }

        return Storage::disk(config('filesystems.uploads_disk', 'public'))->url($this->gambar);
    }
}
