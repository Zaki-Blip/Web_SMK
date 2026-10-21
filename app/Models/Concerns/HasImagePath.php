<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

/**
 * Dipakai model yang punya kolom image_path (fasilitas, galeri, berita).
 */
trait HasImagePath
{
    /**
     * URL gambar pada disk unggahan, atau null bila belum ada gambar.
     */
    public function imageUrl(): ?string
    {
        if (blank($this->image_path)) {
            return null;
        }

        return Storage::disk(config('filesystems.uploads_disk', 'public'))->url($this->image_path);
    }
}
