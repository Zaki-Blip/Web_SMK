@props([
    'label',
    'value',
    'icon' => 'bi-bar-chart',
    'hint' => null,
    'route' => null,
])

<div class="tk-stat-card position-relative h-100">
    <div class="d-flex justify-content-between align-items-start gap-3">
        <div>
            <p class="text-muted-soft small mb-1">{{ $label }}</p>
            <p class="stat-value mb-0">{{ $value }}</p>

            @if (filled($hint))
                <p class="text-muted-soft small mb-0">{{ $hint }}</p>
            @endif
        </div>

        <span class="tk-stat-icon" aria-hidden="true"><i class="bi {{ $icon }}"></i></span>
    </div>

    @if ($route)
        <a class="stretched-link" href="{{ $route }}">
            <span class="visually-hidden">Buka {{ $label }}</span>
        </a>
    @endif
</div>
