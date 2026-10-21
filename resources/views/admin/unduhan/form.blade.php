@php
    $berkasId = 'berkas-upload';
    $hasBerkasError = $errors->has('berkas');
@endphp

<x-admin.form-field name="judul" label="Judul unduhan" :value="$item->judul" required maxlength="200" />
<x-admin.form-field name="deskripsi" type="textarea" label="Deskripsi" :value="$item->deskripsi" :rows="4" maxlength="5000" />

<div class="mb-3">
    <label class="form-label" for="{{ $berkasId }}">
        Berkas
        @if (! $item->exists)
            <span class="text-danger" aria-hidden="true">*</span>
            <span class="visually-hidden">wajib diisi</span>
        @endif
    </label>
    <input type="file" class="form-control{{ $hasBerkasError ? ' is-invalid' : '' }}" id="{{ $berkasId }}" name="berkas"
           accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.txt"
           @if (! $item->exists) required @endif
           @if ($hasBerkasError) aria-invalid="true" aria-describedby="{{ $berkasId }}-error" @endif>
    <p class="form-text" id="{{ $berkasId }}-help">PDF, DOC/DOCX, XLS/XLSX, PPT/PPTX, ZIP, atau TXT. Maksimal 10 MB.</p>
    @error('berkas')
        <div class="invalid-feedback d-block" id="{{ $berkasId }}-error">{{ $message }}</div>
    @enderror

    @if ($item->berkas)
        <p class="form-text mb-0">
            Berkas saat ini:
            <a href="{{ $item->fileUrl() }}" target="_blank" rel="noopener">{{ basename($item->berkas) }}</a>
        </p>
    @endif
</div>

<div class="row g-3">
    <div class="col-md-4">
        <x-admin.form-field name="urutan" type="number" label="Urutan" :value="$item->urutan" min="0" max="9999" required />
    </div>
    <div class="col-md-8 d-flex align-items-center">
        <x-admin.form-field name="is_published" type="switch" label="Status" :value="$item->is_published" placeholder="Terbit" />
    </div>
</div>
