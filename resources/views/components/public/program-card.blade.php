@props(['program'])

<article class="tk-card d-flex flex-column h-100">
    <x-public.media :url="$program->imageUrl()" :alt="'Ilustrasi program '.$program->name" icon="bi-journal-bookmark" />

    <div class="p-3 d-flex flex-column flex-grow-1">
        <h3 class="h6 mb-2">{{ $program->name }}</h3>

        @if (filled($program->short_description))
            <p class="text-muted-soft mb-0">{{ $program->short_description }}</p>
        @else
            <p class="text-muted-soft mb-0">Keterangan program belum diisi.</p>
        @endif
    </div>
</article>
