<?php

namespace App\Models;

use App\Models\Concerns\HasImagePath;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

#[Fillable(['title', 'slug', 'excerpt', 'body', 'image_path', 'published_at', 'status'])]
class News extends Model
{
    use HasFactory;
    use HasImagePath;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /**
     * Hanya berita berstatus published dan tanggal publikasinya sudah lewat.
     * Draft dan berita terjadwal di masa depan tidak ikut tampil.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', self::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now());
    }

    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->orderByDesc('published_at')->orderByDesc('id');
    }

    /**
     * Status untuk tampilan admin: draft, terjadwal (tanggal masih di depan), atau terbit.
     */
    public function displayStatus(): string
    {
        if ($this->status !== self::STATUS_PUBLISHED) {
            return self::STATUS_DRAFT;
        }

        if ($this->published_at === null || $this->published_at->isFuture()) {
            return 'scheduled';
        }

        return self::STATUS_PUBLISHED;
    }
}
