<?php

namespace App\Support;

use GdImage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Satu tempat untuk menyimpan, memperkecil (GD), dan menghapus gambar upload.
 *
 * - Format: JPG, PNG, WebP. Ukuran maksimal 2 MB (divalidasi di Form Request).
 * - Nama file diacak; nama asli dari pengguna tidak dipakai.
 * - Resize menjaga rasio, lebar maksimal sesuai kebutuhan modul.
 */
class ImageUploader
{
    /** Batas ukuran berkas dalam kilobyte (2 MB). */
    public const MAX_KILOBYTES = 2048;

    /** Lebar maksimal untuk galeri, berita, dan hero. */
    public const WIDTH_LARGE = 1600;

    /** Lebar maksimal untuk kartu program/fasilitas. */
    public const WIDTH_CARD = 800;

    /** Lebar maksimal untuk logo sekolah. */
    public const WIDTH_LOGO = 400;

    /**
     * Simpan gambar dan kembalikan path relatif pada disk unggahan.
     */
    public function store(UploadedFile $file, string $folder, int $maxWidth): string
    {
        $this->ensureGdIsAvailable();

        $extension = $this->extensionFor($file);
        $path = trim($folder, '/').'/'.Str::random(40).'.'.$extension;

        $this->disk()->put($path, $this->resizeToLimit($file, $maxWidth, $extension));

        return $path;
    }

    /**
     * Hapus file lama bila ada. Dipakai saat gambar diganti atau record dihapus.
     */
    public function delete(?string $path): void
    {
        if (filled($path) && $this->disk()->exists($path)) {
            $this->disk()->delete($path);
        }
    }

    /**
     * Disk unggahan aktif: "public" (lokal) atau "s3" (S3/Cloudflare R2).
     */
    private function disk(): Filesystem
    {
        return Storage::disk(config('filesystems.uploads_disk', 'public'));
    }

    /**
     * Ekstensi ditentukan dari MIME asli berkas, bukan nama berkas kiriman pengguna.
     */
    private function extensionFor(UploadedFile $file): string
    {
        return match ($file->getMimeType()) {
            'image/png' => 'png',
            'image/webp' => function_exists('imagewebp') ? 'webp' : 'jpg',
            default => 'jpg',
        };
    }

    private function ensureGdIsAvailable(): void
    {
        if (! extension_loaded('gd')) {
            throw new RuntimeException(
                'Upload gagal: ekstensi PHP GD tidak aktif di server ini. Hubungi penyedia hosting.'
            );
        }
    }

    /**
     * Baca berkas, perkecil bila melebihi lebar maksimal, lalu encode ulang.
     * Encode ulang juga menghapus metadata EXIF dari berkas asli.
     */
    private function resizeToLimit(UploadedFile $file, int $maxWidth, string $extension): string
    {
        $contents = (string) file_get_contents($file->getRealPath());
        $image = @imagecreatefromstring($contents);

        if (! $image instanceof GdImage) {
            throw new RuntimeException('Upload gagal: berkas gambar tidak dapat dibaca.');
        }

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width > $maxWidth) {
            $targetHeight = max(1, (int) round($height * ($maxWidth / $width)));
            $resized = imagescale($image, $maxWidth, $targetHeight, IMG_BICUBIC);

            if ($resized instanceof GdImage) {
                imagedestroy($image);
                $image = $resized;
            }
        }

        return $this->encode($image, $extension);
    }

    private function encode(GdImage $image, string $extension): string
    {
        ob_start();

        match ($extension) {
            'png' => $this->encodePng($image),
            'webp' => imagewebp($image, null, 82),
            default => imagejpeg($image, null, 85),
        };

        $binary = (string) ob_get_clean();
        imagedestroy($image);

        if ($binary === '') {
            throw new RuntimeException('Upload gagal: gambar tidak dapat diproses oleh GD.');
        }

        return $binary;
    }

    private function encodePng(GdImage $image): void
    {
        // Pertahankan transparansi PNG.
        imagealphablending($image, false);
        imagesavealpha($image, true);

        imagepng($image, null, 6);
    }
}
