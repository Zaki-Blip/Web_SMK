<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable(['nama', 'singkatan', 'slug', 'ringkasan', 'deskripsi', 'kompetensi', 'prospek_karier', 'lama_belajar', 'gambar', 'urutan', 'is_active'])]
class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';

    protected function casts(): array
    {
        return [
            'kompetensi' => 'array',
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
        if (blank($this->gambar)) {
            return null;
        }

        return Storage::disk(config('filesystems.uploads_disk', 'public'))->url($this->gambar);
    }

    public function guru(): HasMany
    {
        return $this->hasMany(Guru::class);
    }

    public function testimoni(): HasMany
    {
        return $this->hasMany(Testimoni::class);
    }
}
