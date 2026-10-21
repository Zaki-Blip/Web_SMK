<?php

namespace App\Http\Requests\Admin;

use App\Support\ImageUploader;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PrestasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:200'],
            'tingkat' => ['required', Rule::in(['sekolah', 'kota', 'provinsi', 'nasional', 'internasional'])],
            'tahun' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'peraih' => ['nullable', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'is_active' => ['required', 'boolean'],
            'gambar' => [
                'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'mimetypes:image/jpeg,image/png,image/webp',
                'max:'.ImageUploader::MAX_KILOBYTES,
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul prestasi wajib diisi.',
            'tingkat.required' => 'Tingkat wajib dipilih.',
            'tingkat.in' => 'Tingkat tidak dikenal.',
            'is_active.required' => 'Status wajib dipilih.',
            'gambar.image' => 'Berkas yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
