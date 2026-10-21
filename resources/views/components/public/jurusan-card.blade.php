@props(['jurusan'])

<article class="tk-card d-flex flex-column h-100">
    <x-public.media :url="$jurusan->imageUrl()" :alt="'Ilustrasi jurusan '.$jurusan->nama" icon="bi-journal-bookmark" />

    <div class="p-3 d-flex flex-column flex-grow-1">
        <h3 class="h6 mb-2">{{ $jurusan->nama }}</h3>

        @if (filled($jurusan->ringkasan))
            <p class="text-muted-soft mb-0">{{ $jurusan->ringkasan }}</p>
        @else
            <p class="text-muted-soft mb-0">Keterangan jurusan belum diisi.</p>
        @endif
    </div>
</article>
