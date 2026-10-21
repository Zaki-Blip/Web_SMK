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
    'facebook_url',
    'instagram_url',
    'youtube_url',
    'tiktok_url',
])]
class SiteSetting extends Model
{
    protected $table = 'site_settings';

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

    /**
     * Daftar tautan media sosial yang sudah diisi admin.
     *
     * @return array<int, array{label: string, icon: string, url: string}>
     */
    public function socialLinks(): array
    {
        return array_values(array_filter([
            filled($this->facebook_url) ? ['label' => 'Facebook', 'icon' => 'bi-facebook', 'url' => $this->facebook_url] : null,
            filled($this->instagram_url) ? ['label' => 'Instagram', 'icon' => 'bi-instagram', 'url' => $this->instagram_url] : null,
            filled($this->youtube_url) ? ['label' => 'YouTube', 'icon' => 'bi-youtube', 'url' => $this->youtube_url] : null,
            filled($this->tiktok_url) ? ['label' => 'TikTok', 'icon' => 'bi-tiktok', 'url' => $this->tiktok_url] : null,
        ]));
    }
}
