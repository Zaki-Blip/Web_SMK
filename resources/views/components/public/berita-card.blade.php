@props(['news'])

<article class="tk-card position-relative d-flex flex-column h-100">
    <x-public.media :url="$news->imageUrl()" :alt="'Ilustrasi berita '.$news->title" icon="bi-newspaper" />

    <div class="p-3 d-flex flex-column flex-grow-1">
        @if (filled($news->kategori))
            <p class="mb-2"><span class="tk-badge">{{ ucfirst($news->kategori) }}</span></p>
        @endif

        @if ($news->published_at)
            <p class="text-muted-soft small mb-1">
                <time datetime="{{ $news->published_at->toDateString() }}">
                    {{ \App\Support\IndonesianDate::long($news->published_at) }}
                </time>
            </p>
        @endif

        <h3 class="h6 mb-2">
            <a class="stretched-link" href="{{ route('berita.show', $news->slug) }}">{{ $news->title }}</a>
        </h3>

        @if (filled($news->excerpt))
            <p class="text-muted-soft mb-0">{{ \Illuminate\Support\Str::limit($news->excerpt, 140) }}</p>
        @endif
    </div>
</article>
