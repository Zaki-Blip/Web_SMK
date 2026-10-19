<?php

namespace App\Models;

use App\Support\WhatsappNumber;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'school_name',
    'logo_path',
    'address',
    'phone',
    'email',
    'opening_hours',
    'whatsapp_number',
    'maps_url',
    'meta_title',
    'meta_description',
])]
class SiteSetting extends Model
{
    /**
     * Pengaturan situs hanya satu record.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }

    /**
     * Tautan WhatsApp (wa.me) dari nomor yang sudah dinormalisasi.
     */
    public function whatsappUrl(): ?string
    {
        return WhatsappNumber::url($this->whatsapp_number);
    }
}
