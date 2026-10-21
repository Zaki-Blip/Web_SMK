<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StrukturOrganisasiRequest extends FormRequest
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
        $item = $this->route('struktur');
        $parentRules = ['nullable', 'integer', 'exists:struktur_organisasi,id'];

        if ($item) {
            $parentRules[] = Rule::notIn([$item->getKey()]);
        }

        return [
            'nama' => ['required', 'string', 'max:150'],
            'jabatan' => ['required', 'string', 'max:150'],
            'parent_id' => $parentRules,
            'urutan' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'parent_id.exists' => 'Atasan yang dipilih tidak ditemukan.',
            'parent_id.not_in' => 'Atasan tidak boleh diri sendiri.',
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
