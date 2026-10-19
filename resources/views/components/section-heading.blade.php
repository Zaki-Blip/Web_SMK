@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'align' => 'start',
    'level' => 'h2',
])

<div class="mb-4 {{ $align === 'center' ? 'text-center mx-auto' : '' }}"
     @if ($align === 'center') style="max-width: 720px;" @endif>
    @if ($eyebrow)
        <p class="tk-badge mb-2">{{ $eyebrow }}</p>
    @endif

    <{{ $level }} class="mb-2 {{ $level === 'h1' ? 'h1' : 'h2' }}">{{ $title }}</{{ $level }}>

    @if ($description)
        <p class="text-muted-soft mb-0">{{ $description }}</p>
    @endif
</div>
