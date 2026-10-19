@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'help' => null,
    'required' => false,
    'rows' => 6,
    'options' => [],
    'placeholder' => null,
    'min' => null,
    'max' => null,
    'step' => null,
    'maxlength' => null,
])

@php
    // id unik untuk menghubungkan label, input, dan pesan error.
    $id = 'field-'.str_replace(['[', ']', '.'], ['-', '-', '-'], $name);
    $fieldValue = old($name, $value);
    $hasError = $errors->has($name);
    $describedBy = trim(implode(' ', array_filter([
        filled($help) ? $id.'-help' : null,
        $hasError ? $id.'-error' : null,
    ])));
    $inputClass = 'form-control'.($hasError ? ' is-invalid' : '');
@endphp

<div class="mb-3">
    <label class="form-label" for="{{ $id }}">
        {{ $label }}
        @if ($required)
            <span class="text-danger" aria-hidden="true">*</span>
            <span class="visually-hidden">wajib diisi</span>
        @endif
    </label>

    @if ($type === 'textarea')
        <textarea class="{{ $inputClass }}" id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}"
                  placeholder="{{ $placeholder }}"
                  @if ($required) required @endif
                  @if ($maxlength) maxlength="{{ $maxlength }}" @endif
                  @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
                  @if ($hasError) aria-invalid="true" @endif>{{ $fieldValue }}</textarea>
    @elseif ($type === 'select')
        <select class="{{ $inputClass }}" id="{{ $id }}" name="{{ $name }}"
                @if ($required) required @endif
                @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
                @if ($hasError) aria-invalid="true" @endif>
            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected((string) $fieldValue === (string) $optionValue)>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
    @elseif ($type === 'switch')
        <div class="form-check form-switch">
            <input type="hidden" name="{{ $name }}" value="0">
            <input class="form-check-input" type="checkbox" role="switch" id="{{ $id }}" name="{{ $name }}" value="1"
                   @checked((bool) $fieldValue)
                   @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif>
            <label class="form-check-label" for="{{ $id }}">{{ $placeholder ?: 'Aktif' }}</label>
        </div>
    @else
        <input type="{{ $type }}" class="{{ $inputClass }}" id="{{ $id }}" name="{{ $name }}"
               value="{{ $type === 'password' ? '' : $fieldValue }}"
               placeholder="{{ $placeholder }}"
               @if ($required) required @endif
               @if (! is_null($min)) min="{{ $min }}" @endif
               @if (! is_null($max)) max="{{ $max }}" @endif
               @if (! is_null($step)) step="{{ $step }}" @endif
               @if ($maxlength) maxlength="{{ $maxlength }}" @endif
               @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
               @if ($hasError) aria-invalid="true" @endif>
    @endif

    @if (filled($help))
        <p class="form-text" id="{{ $id }}-help">{{ $help }}</p>
    @endif

    @error($name)
        <div class="invalid-feedback d-block" id="{{ $id }}-error">{{ $message }}</div>
    @enderror
</div>
