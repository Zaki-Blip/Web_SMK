<?php

namespace App\Http\Requests\Admin;

use App\Support\ImageUploader;
use Illuminate\Foundation\Http\FormRequest;

class GaleriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        // Gambar wajib saat menambah foto baru, opsional saat mengubah metadata.
        $model = $this->route('galeri');

        return [
            'title' => ['required', 'string', 'max:150'],
            'caption' => ['nullable', 'string', 'max:500'],
            'category' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_published' => ['required', 'boolean'],
            'image' => [
                $model ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:'.ImageUploader::MAX_KILOBYTES,
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul foto wajib diisi.',
            'image.required' => 'Pilih berkas gambar yang akan diunggah.',
            'image.image' => 'Berkas yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'image.mimetypes' => 'Isi berkas tidak sesuai dengan format gambar yang diizinkan.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
            'sort_order.integer' => 'Urutan harus berupa angka.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'sort_order' => (int) $this->input('sort_order'),
            'is_published' => $this->boolean('is_published'),
        ]);
    }
}
