@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'align' => 'start',
    'level' => 'h2',
    'link' => null,
    'linkLabel' => 'Lihat semua',
    'compact' => false,
])

<div class="tk-section-heading {{ $compact ? 'tk-section-heading--compact' : 'mb-3' }} {{ $align === 'center' ? 'text-center mx-auto' : '' }}"
     @if ($align === 'center') style="max-width: 720px;" @endif>
    <div>
        @if ($eyebrow)
            <p class="tk-badge mb-2">{{ $eyebrow }}</p>
        @endif

        <{{ $level }} class="mb-2 {{ $level === 'h1' ? 'h1' : 'h3' }}">{{ $title }}</{{ $level }}>

        @if ($description)
            <p class="text-muted-soft mb-0">{{ $description }}</p>
        @endif
    </div>

    @if ($link)
        <a class="tk-section-heading__link" href="{{ $link }}">
            {{ $linkLabel }} <i class="bi bi-arrow-right" aria-hidden="true"></i>
        </a>
    @endif
</div>
