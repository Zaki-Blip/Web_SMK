@extends('layouts.public')

@section('title', 'Program — '.($site?->school_name ?: config('school.fallback.school_name')))
@section('meta_description', 'Program pembelajaran yang dipublikasikan '.($site?->school_name ?: config('school.fallback.school_name')).'.')

@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading level="h1" title="Program" description="Program pembelajaran yang dipublikasikan sekolah." :compact="true" />
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if ($programs->isNotEmpty())
                <div class="row g-3">
                    @foreach ($programs as $program)
                        <div class="col-md-6 col-lg-4">
                            <x-public.program-card :program="$program" />
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    {{ $programs->links() }}
                </div>
            @else
                <x-empty-state
                    icon="bi-journal-bookmark"
                    title="Belum ada program yang dipublikasikan"
                    message="Daftar program akan tampil setelah pihak sekolah menambahkannya melalui dashboard admin."
                />
            @endif
        </div>
    </section>
@endsection
