@props(['state' => 'draft'])

@php
    // Status ringkas untuk tabel admin; warna tidak menjadi satu-satunya penanda.
    $map = [
        'published' => ['label' => 'Terbit', 'class' => 'tk-badge-success'],
        'draft' => ['label' => 'Draft', 'class' => 'tk-badge-muted'],
        'scheduled' => ['label' => 'Terjadwal', 'class' => 'tk-badge-warning'],
        'active' => ['label' => 'Aktif', 'class' => 'tk-badge-success'],
        'inactive' => ['label' => 'Nonaktif', 'class' => 'tk-badge-muted'],
    ];

    $state = $map[$state] ?? $map['draft'];
@endphp

<span class="tk-badge {{ $state['class'] }}">{{ $state['label'] }}</span>
