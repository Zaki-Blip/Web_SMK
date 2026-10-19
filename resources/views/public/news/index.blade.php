@extends('layouts.public')

@section('title', 'Berita — '.($site?->school_name ?: config('school.fallback.school_name')))
@section('meta_description', 'Berita dan kegiatan terbaru '.($site?->school_name ?: config('school.fallback.school_name')).'.')

@section('content')
    <section class="tk-hero py-4">
        <div class="container">
            <x-section-heading level="h1" title="Berita" description="Berita dan kegiatan terbaru sekolah." />
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if ($newsItems->isNotEmpty())
                <div class="row g-3">
                    @foreach ($newsItems as $news)
                        <div class="col-md-6 col-lg-4">
                            <x-public.news-card :news="$news" />
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $newsItems->links() }}
                </div>
            @else
                <x-empty-state
                    icon="bi-newspaper"
                    title="Belum ada berita yang dipublikasikan"
                    message="Berita terbaru akan tampil setelah pihak sekolah mempublikasikannya."
                />
            @endif
        </div>
    </section>
@endsection
