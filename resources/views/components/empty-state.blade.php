@props([
    'icon' => 'bi-inbox',
    'title' => 'Belum ada data',
    'message' => null,
])

<div class="tk-empty-state">
    <i class="bi {{ $icon }}" aria-hidden="true"></i>
    <p class="fw-semibold text-dark mt-3 mb-1">{{ $title }}</p>
    @if ($message)
        <p class="mb-0">{{ $message }}</p>
    @endif
</div>
