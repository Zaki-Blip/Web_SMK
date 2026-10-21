<?php

namespace App\Http\Requests\Admin;

use App\Support\ImageUploader;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EkstrakurikulerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $item = $this->route('ekstrakurikuler');

        return [
            'nama' => ['required', 'string', 'max:150'],
            'slug' => [
                'required', 'string', 'max:150',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('ekstrakurikuler', 'slug')->ignore($item?->getKey()),
            ],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'pembina' => ['nullable', 'string', 'max:100'],
            'jadwal' => ['nullable', 'string', 'max:150'],
            'urutan' => ['required', 'integer', 'min:0', 'max:9999'],
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
            'nama.required' => 'Nama ekstrakurikuler wajib diisi.',
            'slug.regex' => 'Slug hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
            'slug.unique' => 'Slug ini sudah dipakai.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'gambar.image' => 'Berkas yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug((string) ($this->input('slug') ?: $this->input('nama'))),
            'urutan' => (int) $this->input('urutan'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
