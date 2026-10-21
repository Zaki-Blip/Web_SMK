<?php

namespace App\Http\Requests\Admin;

use App\Support\ImageUploader;
use Illuminate\Foundation\Http\FormRequest;

class TestimoniRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:150'],
            'angkatan' => ['nullable', 'string', 'max:20'],
            'jurusan_id' => ['nullable', 'exists:jurusan,id'],
            'pekerjaan_saat_ini' => ['nullable', 'string', 'max:150'],
            'isi' => ['required', 'string', 'max:2000'],
            'is_active' => ['required', 'boolean'],
            'foto' => [
                'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'mimetypes:image/jpeg,image/png,image/webp',
                'max:'.ImageUploader::MAX_KILOBYTES,
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'isi.required' => 'Isi testimoni wajib diisi.',
            'is_active.required' => 'Status wajib dipilih.',
            'foto.image' => 'Berkas yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'foto.max' => 'Ukuran gambar maksimal 2 MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
