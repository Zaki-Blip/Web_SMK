@props(['testimoni'])

<article class="tk-card h-100 p-3 d-flex flex-column">
    <div class="d-flex align-items-center gap-3 mb-3">
        <x-public.media
            :url="$testimoni->imageUrl()"
            :alt="'Foto '.$testimoni->nama"
            icon="bi-person"
            imgClass="tk-avatar"
            placeholderClass="tk-avatar tk-avatar-placeholder"
            :width="64"
            :height="64"
        />

        <div>
            <h3 class="h6 mb-0">{{ $testimoni->nama }}</h3>
            <p class="text-muted-soft small mb-0">
                @if (filled($testimoni->angkatan))
                    Angkatan {{ $testimoni->angkatan }}
                @endif
                @if (filled($testimoni->jurusan))
                    @if (filled($testimoni->angkatan)) &middot; @endif
                    {{ $testimoni->jurusan->nama }}
                @endif
            </p>
        </div>
    </div>

    <blockquote class="mb-0 flex-grow-1">
        <p class="text-muted-soft mb-2">&ldquo;{{ \Illuminate\Support\Str::limit($testimoni->isi, 220) }}&rdquo;</p>
        @if (filled($testimoni->pekerjaan_saat_ini))
            <footer class="small text-muted-soft">{{ $testimoni->pekerjaan_saat_ini }}</footer>
        @endif
    </blockquote>
</article>
