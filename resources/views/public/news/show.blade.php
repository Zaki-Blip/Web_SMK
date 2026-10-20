@extends('layouts.public')

@php
    $schoolName = $site?->school_name ?: config('school.fallback.school_name');
@endphp

@section('title', $news->title.' — '.$schoolName)
@section('meta_description', $news->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($news->body), 150))
@section('og_type', 'article')

@push('head')
    <meta property="article:published_time" content="{{ $news->published_at?->toAtomString() }}">
@endpush

@section('content')
    <article class="section">
        <div class="container" style="max-width: 820px;">
            <p class="mb-2">
                <a href="{{ route('news.index') }}"><i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Kembali ke daftar berita</a>
            </p>

            <h1 class="h3 mb-2">{{ $news->title }}</h1>

            @if ($news->published_at)
                <p class="text-muted-soft small">
                    Dipublikasikan
                    <time datetime="{{ $news->published_at->toDateString() }}">
                        {{ \App\Support\IndonesianDate::long($news->published_at) }}
                    </time>
                </p>
            @endif

            <x-public.media :url="$news->imageUrl()" :alt="'Ilustrasi berita '.$news->title" icon="bi-newspaper"
                            imgClass="rounded-4 w-100 mb-3" width="1200" height="675" />

            <div class="tk-prose mb-3">
                {!! nl2br(e($news->body)) !!}
            </div>

            <hr class="tk-divider">

            @if ($related->isNotEmpty())
                <h2 class="h5 mt-3 mb-3">Berita terkait</h2>
                <div class="row g-3">
                    @foreach ($related as $item)
                        <div class="col-md-6 col-lg-4">
                            <x-public.news-card :news="$item" />
                        </div>
                    @endforeach
                </div>
            @endif

            <p class="mt-3 mb-0">
                <a class="btn btn-tk-outline" href="{{ route('news.index') }}">Kembali ke daftar berita</a>
            </p>
        </div>
    </article>
@endsection
