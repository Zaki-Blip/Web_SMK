<?php

namespace App\Http\Requests\Admin;

use App\Support\ImageUploader;
use Illuminate\Foundation\Http\FormRequest;

class MitraIndustriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:150'],
            'bidang' => ['nullable', 'string', 'max:100'],
            'website' => ['nullable', 'string', 'url', 'max:255'],
            'urutan' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['required', 'boolean'],
            'logo' => [
                'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'mimetypes:image/jpeg,image/png,image/webp',
                'max:'.ImageUploader::MAX_KILOBYTES,
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama mitra wajib diisi.',
            'website.url' => 'Website harus berupa tautan lengkap.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'logo.image' => 'Berkas yang diunggah harus berupa gambar.',
            'logo.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'logo.max' => 'Ukuran gambar maksimal 2 MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'urutan' => (int) $this->input('urutan'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
