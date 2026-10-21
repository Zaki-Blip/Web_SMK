<?php

return [
    /*
     * Menampilkan banner "Versi demo — bukan website resmi" di halaman publik.
     * Diaktifkan saat data demo dipakai.
     */
    'demo_mode' => env('DEMO_MODE', false),

    'fallback' => [
        'school_name' => 'SMKN 64 Jakarta',
        'subtitle' => 'Sekolah Menengah Kejuruan',
        'address' => 'Jl. Mpo Nori RT 09 RW 03, Bambu Apus, Cipayung, Jakarta Timur, DKI Jakarta 13890',
        'phone' => '[BELUM DIKONFIRMASI]',
        'email' => '[BELUM DIKONFIRMASI]',
        'opening_hours' => '[BELUM DIKONFIRMASI]',
        'whatsapp_number' => null,
        'maps_url' => null,
    ],
];
