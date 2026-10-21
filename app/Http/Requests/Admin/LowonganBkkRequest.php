<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LowonganBkkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:200'],
            'perusahaan' => ['required', 'string', 'max:150'],
            'lokasi' => ['nullable', 'string', 'max:150'],
            'tipe' => ['required', Rule::in(['penuh_waktu', 'kontrak', 'magang'])],
            'deskripsi' => ['nullable', 'string', 'max:10000'],
            'persyaratan' => ['nullable', 'string', 'max:5000'],
            'tautan_daftar' => ['nullable', 'string', 'url', 'max:500'],
            'batas_waktu' => ['nullable', 'date'],
            'is_published' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul lowongan wajib diisi.',
            'perusahaan.required' => 'Nama perusahaan wajib diisi.',
            'tipe.required' => 'Tipe wajib dipilih.',
            'tipe.in' => 'Tipe tidak dikenal.',
            'tautan_daftar.url' => 'Tautan pendaftaran harus berupa URL lengkap.',
            'is_published.required' => 'Status publikasi wajib dipilih.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
        ]);
    }
}
