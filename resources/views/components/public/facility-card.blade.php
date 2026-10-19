@props(['facility'])

<article class="tk-card d-flex flex-column h-100">
    <x-public.media :url="$facility->imageUrl()" :alt="'Ilustrasi fasilitas '.$facility->name" icon="bi-building" />

    <div class="p-3 d-flex flex-column flex-grow-1">
        <h3 class="h6 mb-2">{{ $facility->name }}</h3>

        @if (filled($facility->description))
            <p class="text-muted-soft mb-0">{{ \Illuminate\Support\Str::limit($facility->description, 160) }}</p>
        @else
            <p class="text-muted-soft mb-0">Keterangan fasilitas belum diisi.</p>
        @endif
    </div>
</article>
