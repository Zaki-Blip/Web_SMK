<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable(['judul', 'deskripsi', 'berkas', 'ukuran', 'is_published', 'urutan'])]
class Unduhan extends Model
{
    use HasFactory;

    protected $table = 'unduhan';

    protected function casts(): array
    {
        return [
            'ukuran' => 'integer',
            'is_published' => 'boolean',
            'urutan' => 'integer',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('urutan')->orderBy('judul');
    }

    public function fileUrl(): ?string
    {
        if (blank($this->berkas)) {
            return null;
        }

        return Storage::disk(config('filesystems.uploads_disk', 'public'))->url($this->berkas);
    }

    public function ukuranTampil(): string
    {
        $bytes = max(0, (int) $this->ukuran);

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1, ',', '.').' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 0, ',', '.').' KB';
        }

        return $bytes.' B';
    }
}
