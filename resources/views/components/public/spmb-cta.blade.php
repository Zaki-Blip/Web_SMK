@props([
    'whatsappUrl' => null,
    'whatsappLabel' => 'Hubungi via WhatsApp',
    'contactUrl' => true,
])

<div class="d-flex flex-wrap gap-2">
    @if ($whatsappUrl)
        <a class="btn btn-tk-accent" href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer">
            <i class="bi bi-whatsapp me-1" aria-hidden="true"></i>{{ $whatsappLabel }}
        </a>
    @endif

    @if ($contactUrl)
        <a class="btn btn-tk-outline" href="{{ route('kontak.index') }}">Halaman kontak</a>
    @endif
</div>
