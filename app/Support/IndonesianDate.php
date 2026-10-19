<?php

namespace App\Support;

use Illuminate\Support\Carbon;

class IndonesianDate
{
    /**
     * Format tanggal berbahasa Indonesia, mis. "31 Juli 2026".
     */
    public static function long(?Carbon $date): string
    {
        return $date ? $date->copy()->locale('id')->translatedFormat('j F Y') : '';
    }

    /**
     * Format tanggal dan waktu berbahasa Indonesia, mis. "31 Juli 2026, 08.30".
     */
    public static function longWithTime(?Carbon $date): string
    {
        return $date ? $date->copy()->locale('id')->translatedFormat('j F Y, H.i') : '';
    }
}
