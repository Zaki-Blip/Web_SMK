<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

#[Fillable(['judul', 'perusahaan', 'lokasi', 'tipe', 'deskripsi', 'persyaratan', 'tautan_daftar', 'batas_waktu', 'is_published'])]
class LowonganBkk extends Model
{
    use HasFactory;

    protected $table = 'lowongan_bkk';

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'batas_waktu' => 'date',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->whereNull('batas_waktu')->orWhere('batas_waktu', '>=', Carbon::today());
        });
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }
}
