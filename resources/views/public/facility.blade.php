@extends('layouts.public')

@section('title', 'Fasilitas — '.($site?->school_name ?: config('school.fallback.school_name')))
@section('meta_description', 'Fasilitas sekolah yang dipublikasikan '.($site?->school_name ?: config('school.fallback.school_name')).'.')

@section('content')
    <section class="tk-hero py-4">
        <div class="container">
            <x-section-heading level="h1" title="Fasilitas" description="Fasilitas sekolah yang dipublikasikan." />
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if ($facilities->isNotEmpty())
                <div class="row g-3">
                    @foreach ($facilities as $facility)
                        <div class="col-md-6 col-lg-4">
                            <x-public.facility-card :facility="$facility" />
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $facilities->links() }}
                </div>
            @else
                <x-empty-state
                    icon="bi-building"
                    title="Belum ada fasilitas yang dipublikasikan"
                    message="Daftar fasilitas akan tampil setelah pihak sekolah menambahkannya melalui dashboard admin."
                />
            @endif
        </div>
    </section>
@endsection
