<?php

namespace App\Http\Requests\Admin;

use App\Models\Berita;
use App\Support\ImageUploader;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BeritaRequest extends FormRequest
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
        $news = $this->route('berita');

        return [
            'title' => ['required', 'string', 'max:200'],
            'slug' => [
                'required',
                'string',
                'max:200',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('berita', 'slug')->ignore($news?->getKey()),
            ],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'kategori' => ['nullable', 'string', 'max:50'],
            'body' => ['required', 'string', 'max:20000'],
            'status' => ['required', Rule::in([Berita::STATUS_DRAFT, Berita::STATUS_PUBLISHED])],
            'published_at' => ['nullable', 'date'],
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
            'title.required' => 'Judul berita wajib diisi.',
            'slug.unique' => 'Slug ini sudah dipakai berita lain.',
            'slug.regex' => 'Slug hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
            'body.required' => 'Isi berita wajib diisi.',
            'status.in' => 'Status berita tidak dikenal.',
            'published_at.date' => 'Tanggal publikasi tidak valid.',
            'image.image' => 'Berkas yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'image.mimetypes' => 'Isi berkas tidak sesuai dengan format gambar yang diizinkan.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $status = (string) $this->input('status', Berita::STATUS_DRAFT);
        $publishedAt = $this->input('published_at');

        // Berita yang langsung diterbitkan tanpa mengisi tanggal memakai waktu sekarang.
        if ($status === Berita::STATUS_PUBLISHED && blank($publishedAt)) {
            $publishedAt = now()->format('Y-m-d\TH:i');
        }

        $this->merge([
            'slug' => Str::slug((string) ($this->input('slug') ?: $this->input('title'))),
            'status' => $status,
            'published_at' => $publishedAt,
        ]);
    }
}
