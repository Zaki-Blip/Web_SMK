<?php

namespace App\Support;

/**
 * Normalisasi nomor WhatsApp ke format internasional tanpa tanda plus (mis. 62812xxxxxxx).
 */
class WhatsappNumber
{
    /**
     * Mengubah input pengguna (08xx, +62 8xx, 62-8xx) menjadi format simpan 628xx.
     */
    public static function normalize(?string $value): ?string
    {
        $digits = preg_replace('/\D/', '', (string) $value);

        if (blank($digits)) {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            return '62'.ltrim($digits, '0');
        }

        if (! str_starts_with($digits, '62')) {
            return '62'.$digits;
        }

        return $digits;
    }

    /**
     * Tautan wa.me dari nomor yang sudah dinormalisasi.
     */
    public static function url(?string $value): ?string
    {
        $number = self::normalize($value);

        return $number ? 'https://wa.me/'.$number : null;
    }
}
