@props([
    'value' => null,
    'name' => 'q',
    'label' => 'Cari data',
    'placeholder' => 'Cari…',
])

@php
    $id = 'search-'.str_replace(['[', ']', '.'], ['-', '-', '-'], $name);
@endphp

<form method="get" class="d-flex flex-wrap gap-2" role="search">
    <div class="flex-grow-1" style="min-width: 12rem;">
        <label class="visually-hidden" for="{{ $id }}">{{ $label }}</label>
        <input type="search" class="form-control" id="{{ $id }}" name="{{ $name }}"
               value="{{ $value }}" placeholder="{{ $placeholder }}">
    </div>

    <button type="submit" class="btn btn-tk-primary">
        <i class="bi bi-search me-1" aria-hidden="true"></i>Cari
    </button>

    @if (filled($value))
        <a class="btn btn-tk-outline" href="{{ url()->current() }}">Reset</a>
    @endif
</form>
