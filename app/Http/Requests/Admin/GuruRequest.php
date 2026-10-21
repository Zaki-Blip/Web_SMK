<?php

namespace App\Http\Requests\Admin;

use App\Support\ImageUploader;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $guru = $this->route('guru');

        return [
            'nama' => ['required', 'string', 'max:150'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'tipe' => ['required', Rule::in(['guru', 'staf'])],
            'mata_pelajaran' => ['nullable', 'string', 'max:150'],
            'jurusan_id' => ['nullable', 'exists:jurusan,id'],
            'urutan' => ['required', 'integer', 'min:0', 'max:9999'],
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
            'tipe.required' => 'Tipe wajib dipilih.',
            'tipe.in' => 'Tipe tidak dikenal.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'foto.image' => 'Berkas yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'foto.max' => 'Ukuran gambar maksimal 2 MB.',
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
