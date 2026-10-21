@extends('layouts.public')
@section('title', 'Guru & Staf')
@section('meta_description', 'Guru dan staf yang mendukung pembelajaran di SMK Negeri 64 Jakarta.')
@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading level="h1" title="Guru & Staf" description="Tenaga pendidik dan kependidikan sekolah." :compact="true" />
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-3">
                @forelse ($gurus as $guru)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="tk-card text-center p-3">
                            <x-public.media :url="$guru->imageUrl()" :alt="$guru->nama" icon="bi-person" imgClass="rounded-circle mb-2" placeholderClass="tk-placeholder" :width="120" :height="120" />
                            <div class="fw-semibold">{{ $guru->nama }}</div>
                            <div class="text-muted-soft small">{{ $guru->jabatan }}</div>
                            <div class="text-muted-soft small">{{ $guru->mata_pelajaran }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <x-empty-state
                            icon="bi-people"
                            title="Belum ada data guru"
                            message="Data guru dan staf akan tampil setelah pihak sekolah menambahkannya."
                        />
                    </div>
                @endforelse
            </div>

            @if ($gurus->hasPages())
                <div class="mt-3">{{ $gurus->links() }}</div>
            @endif
        </div>
    </section>
@endsection