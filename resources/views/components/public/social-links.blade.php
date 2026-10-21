@props(['site' => null])

@php
    $links = $site?->socialLinks() ?? [];
@endphp

@if (count($links))
    <ul class="list-unstyled d-flex flex-wrap gap-2 mb-0">
        @foreach ($links as $link)
            <li>
                <a class="btn btn-sm btn-tk-outline" href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer">
                    <i class="bi {{ $link['icon'] }} me-1" aria-hidden="true"></i>{{ $link['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
@endif
