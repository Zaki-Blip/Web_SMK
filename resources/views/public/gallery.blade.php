@extends('layouts.public')

@section('title', 'Galeri — '.($site?->school_name ?: config('school.fallback.school_name')))
@section('meta_description', 'Galeri foto kegiatan '.($site?->school_name ?: config('school.fallback.school_name')).'.')

@section('content')
    <section class="tk-hero py-4">
        <div class="container">
            <x-section-heading level="h1" title="Galeri" description="Foto kegiatan sekolah yang dipublikasikan." />
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if ($items->isNotEmpty())
                <x-public.gallery-grid :items="$items" />

                <div class="mt-4">
                    {{ $items->links() }}
                </div>
            @else
                <x-empty-state
                    icon="bi-images"
                    title="Belum ada foto pada galeri"
                    message="Foto kegiatan akan tampil setelah pihak sekolah mengunggahnya melalui dashboard admin."
                />
            @endif
        </div>
    </section>
@endsection
