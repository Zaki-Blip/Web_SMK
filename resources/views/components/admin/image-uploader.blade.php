@props([
    'name' => 'image',
    'label' => 'Gambar',
    'currentUrl' => null,
    'help' => null,
    'required' => false,
    'currentLabel' => 'Gambar saat ini',
])

@php
    $id = 'upload-'.str_replace(['[', ']', '.'], ['-', '-', '-'], $name);
    $hasError = $errors->has($name);
@endphp

<div class="mb-3">
    <label class="form-label" for="{{ $id }}">
        {{ $label }}
        @if ($required)
            <span class="text-danger" aria-hidden="true">*</span>
            <span class="visually-hidden">wajib diisi</span>
        @endif
    </label>

    <input type="file" class="form-control{{ $hasError ? ' is-invalid' : '' }}" id="{{ $id }}" name="{{ $name }}"
           accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
           @if ($required) required @endif
           @if ($hasError) aria-invalid="true" aria-describedby="{{ $id }}-error" @endif
           data-image-input>

    <p class="form-text" id="{{ $id }}-help">
        {{ $help ?: 'Format JPG, PNG, atau WebP. Maksimal 2 MB. Gambar otomatis diperkecil tanpa mengubah rasio.' }}
    </p>

    @error($name)
        <div class="invalid-feedback d-block" id="{{ $id }}-error">{{ $message }}</div>
    @enderror

    <div class="d-flex flex-wrap gap-3 mt-2">
        @if ($currentUrl)
            <figure class="mb-0">
                <img src="{{ $currentUrl }}" alt="{{ $currentLabel }}" class="tk-thumb">
                <figcaption class="form-text mb-0">{{ $currentLabel }}</figcaption>
            </figure>
        @endif

        <figure class="mb-0 d-none" data-image-preview-wrapper>
            <img src="" alt="Pratinjau gambar yang akan diunggah" class="tk-thumb" data-image-preview>
            <figcaption class="form-text mb-0">Pratinjau gambar baru</figcaption>
        </figure>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var input = document.getElementById('{{ $id }}');

        if (!input) {
            return;
        }

        var wrapper = input.parentElement.querySelector('[data-image-preview-wrapper]');
        var preview = wrapper ? wrapper.querySelector('[data-image-preview]') : null;

        if (!wrapper || !preview) {
            return;
        }

        input.addEventListener('change', function () {
            var file = input.files && input.files[0];

            if (!file) {
                wrapper.classList.add('d-none');
                preview.removeAttribute('src');
                return;
            }

            var reader = new FileReader();

            reader.onload = function (event) {
                preview.setAttribute('src', event.target.result);
                wrapper.classList.remove('d-none');
            };

            reader.readAsDataURL(file);
        });
    });
</script>
