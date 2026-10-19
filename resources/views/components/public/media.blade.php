@props([
    'url' => null,
    'alt' => '',
    'icon' => 'bi-image',
    'imgClass' => 'tk-card-img',
    'placeholderClass' => 'tk-placeholder',
    'width' => 800,
    'height' => 450,
])

{{-- Menampilkan gambar bila ada; bila belum ada memakai placeholder netral (bukan foto stok anak). --}}
@if ($url)
    <img src="{{ $url }}" alt="{{ $alt }}" class="{{ $imgClass }}"
         width="{{ $width }}" height="{{ $height }}" loading="lazy" decoding="async">
@else
    <div class="{{ $placeholderClass }}" role="img" aria-label="{{ $alt }}">
        <i class="bi {{ $icon }}" aria-hidden="true"></i>
    </div>
@endif
