<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AlurPklRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:200'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'urutan' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul langkah wajib diisi.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'is_active.required' => 'Status wajib dipilih.',
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
