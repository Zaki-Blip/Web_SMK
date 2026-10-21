<?php

namespace App\Http\Requests\Admin;

use App\Support\DocumentUploader;
use Illuminate\Foundation\Http\FormRequest;

class UnduhanRequest extends FormRequest
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
        $unduhan = $this->route('unduhan');

        return [
            'judul' => ['required', 'string', 'max:200'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'berkas' => [
                $unduhan ? 'nullable' : 'required',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,txt',
                'max:'.DocumentUploader::MAX_KILOBYTES,
            ],
            'urutan' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_published' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul unduhan wajib diisi.',
            'berkas.required' => 'Berkas wajib diunggah.',
            'berkas.file' => 'Berkas tidak valid.',
            'berkas.mimes' => 'Format berkas harus PDF, DOC/DOCX, XLS/XLSX, PPT/PPTX, ZIP, atau TXT.',
            'berkas.max' => 'Ukuran berkas maksimal 10 MB.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'is_published.required' => 'Status wajib dipilih.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'urutan' => (int) $this->input('urutan'),
            'is_published' => $this->boolean('is_published'),
        ]);
    }
}
