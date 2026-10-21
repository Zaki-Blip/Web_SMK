<?php

namespace App\Http\Requests\Admin;

use App\Support\ImageUploader;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JurusanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $jurusan = $this->route('jurusan');

        return [
            'nama' => ['required', 'string', 'max:150'],
            'singkatan' => ['nullable', 'string', 'max:20'],
            'slug' => [
                'required', 'string', 'max:150',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('jurusan', 'slug')->ignore($jurusan?->getKey()),
            ],
            'ringkasan' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:20000'],
            'kompetensi' => ['nullable'],
            'prospek_karier' => ['nullable', 'string', 'max:5000'],
            'lama_belajar' => ['nullable', 'string', 'max:50'],
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
            'nama.required' => 'Nama jurusan wajib diisi.',
            'slug.regex' => 'Slug hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
            'slug.unique' => 'Slug ini sudah dipakai jurusan lain.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'gambar.image' => 'Berkas yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $kompetensi = $this->input('kompetensi');
        if (is_string($kompetensi)) {
            $kompetensi = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $kompetensi)), fn ($v) => $v !== ''));
        }

        $this->merge([
            'slug' => Str::slug((string) ($this->input('slug') ?: $this->input('nama'))),
            'urutan' => (int) $this->input('urutan'),
            'is_active' => $this->boolean('is_active'),
            'kompetensi' => $kompetensi,
        ]);
    }
}
