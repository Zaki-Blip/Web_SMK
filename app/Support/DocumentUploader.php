<?php

namespace App\Support;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Penyimpanan berkas unduhan (dokumen) pada disk unggahan.
 *
 * Nama asli tidak dipakai; ekstensi diambil dari hasil deteksi MIME dan
 * dibatasi ke daftar yang diizinkan. Validasi ukuran dilakukan di FormRequest.
 */
class DocumentUploader
{
    /** Batas ukuran berkas dalam kilobyte (10 MB). */
    public const MAX_KILOBYTES = 10240;

    /** Ekstensi yang boleh disimpan. */
    public const EXTENSIONS = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'txt'];

    public function store(UploadedFile $file, string $folder = 'unduhan'): string
    {
        $extension = strtolower($file->extension() ?: $file->getClientOriginalExtension());

        if (! in_array($extension, self::EXTENSIONS, true)) {
            throw new RuntimeException('Upload gagal: format berkas tidak diizinkan.');
        }

        $name = Str::random(40).'.'.$extension;
        $path = trim($folder, '/').'/'.$name;

        if (! $this->disk()->putFileAs(trim($folder, '/'), $file, $name)) {
            throw new RuntimeException('Upload gagal: berkas tidak dapat disimpan.');
        }

        return $path;
    }

    public function delete(?string $path): void
    {
        if (filled($path) && $this->disk()->exists($path)) {
            $this->disk()->delete($path);
        }
    }

    public function size(string $path): int
    {
        if (! $this->disk()->exists($path)) {
            return 0;
        }

        return (int) $this->disk()->size($path);
    }

    private function disk(): Filesystem
    {
        return Storage::disk(config('filesystems.uploads_disk', 'public'));
    }
}
