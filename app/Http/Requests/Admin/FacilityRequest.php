<?php

namespace App\Http\Requests\Admin;

use App\Support\ImageUploader;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FacilityRequest extends FormRequest
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
        $facility = $this->route('facility');

        return [
            'name' => ['required', 'string', 'max:150'],
            'slug' => [
                'required',
                'string',
                'max:150',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('facilities', 'slug')->ignore($facility?->getKey()),
            ],
            'description' => ['nullable', 'string', 'max:5000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_published' => ['required', 'boolean'],
            'image' => [
                'nullable',
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
            'name.required' => 'Nama fasilitas wajib diisi.',
            'slug.regex' => 'Slug hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
            'slug.unique' => 'Slug ini sudah dipakai fasilitas lain.',
            'sort_order.integer' => 'Urutan harus berupa angka.',
            'image.image' => 'Berkas yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'image.mimetypes' => 'Isi berkas tidak sesuai dengan format gambar yang diizinkan.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug((string) ($this->input('slug') ?: $this->input('name'))),
            'sort_order' => (int) $this->input('sort_order'),
            'is_published' => $this->boolean('is_published'),
        ]);
    }
}
