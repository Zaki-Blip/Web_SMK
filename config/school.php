<?php

return [
    /*
     * Menampilkan banner "Versi demo — bukan website resmi" di halaman publik.
     * Diaktifkan saat data demo ([CONTOH]) sedang dipakai (lihat PROJECT_SPEC.md bagian 8).
     */
    'demo_mode' => env('DEMO_MODE', false),

    /*
     * Nilai sementara sebelum tabel site_settings diisi lewat dashboard admin.
     * Akan diganti SiteSetting::current() pada Fase 3/4.
     */
    'fallback' => [
        'school_name' => 'TK Angkasa 8',
        'subtitle' => 'Halim Perdanakusuma, Jakarta Timur',
        'address' => 'Jl. Raya Pd. Gede No. 7, RT.7/RW.3, Halim Perdanakusuma, Kecamatan Makasar, Kota Jakarta Timur, DKI Jakarta 13610',
        'phone' => '[BELUM DIKONFIRMASI]',
        'email' => '[BELUM DIKONFIRMASI]',
        'opening_hours' => '[BELUM DIKONFIRMASI]',
        'whatsapp_number' => null,
        'maps_url' => null,
    ],
];
