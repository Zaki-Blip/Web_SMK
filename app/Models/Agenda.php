<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['judul', 'slug', 'deskripsi', 'mulai', 'selesai', 'lokasi', 'is_published'])]
class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agenda';

    protected function casts(): array
    {
        return [
            'mulai' => 'datetime',
            'selesai' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('mulai')->orderBy('judul');
    }

    public function sudahSelesai(): bool
    {
        return ($this->selesai ?: $this->mulai)->isPast();
    }
}
