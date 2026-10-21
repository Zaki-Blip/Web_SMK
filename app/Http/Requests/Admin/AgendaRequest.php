<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AgendaRequest extends FormRequest
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
        $agenda = $this->route('agenda');

        return [
            'judul' => ['required', 'string', 'max:200'],
            'slug' => [
                'required',
                'string',
                'max:200',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('agenda', 'slug')->ignore($agenda?->getKey()),
            ],
            'deskripsi' => ['nullable', 'string', 'max:10000'],
            'mulai' => ['required', 'date'],
            'selesai' => ['nullable', 'date', 'after_or_equal:mulai'],
            'lokasi' => ['nullable', 'string', 'max:200'],
            'is_published' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul agenda wajib diisi.',
            'slug.unique' => 'Slug ini sudah dipakai agenda lain.',
            'slug.regex' => 'Slug hanya boleh berisi huruf kecil, angka, dan tanda hubung.',
            'mulai.required' => 'Waktu mulai wajib diisi.',
            'selesai.after_or_equal' => 'Waktu selesai tidak boleh sebelum waktu mulai.',
            'is_published.required' => 'Status wajib dipilih.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug((string) ($this->input('slug') ?: $this->input('judul'))),
            'is_published' => $this->boolean('is_published'),
        ]);
    }
}
