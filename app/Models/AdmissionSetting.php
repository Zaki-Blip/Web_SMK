<?php

namespace App\Models;

use App\Support\WhatsappNumber;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title',
    'description',
    'schedule',
    'requirements',
    'registration_steps',
    'fee_information',
    'whatsapp_number',
    'is_active',
])]
class AdmissionSetting extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Pengaturan PPDB hanya satu record.
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
