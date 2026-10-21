@extends('layouts.public')
@section('title', 'Industri & Karier')
@section('meta_description', 'Mitra industri dan program praktik kerja lapangan SMK Negeri 64 Jakarta.')
@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading level="h1" title="Mitra Industri" description="Kerja sama sekolah dengan dunia usaha dan dunia industri." :compact="true" />
        </div>
    </section>

    <section class="section">
        <div class="container">
            <p class="text-muted-soft">Kegiatan PKL/prakerin bekerja sama dengan mitra industri.</p>

            <div class="row g-3">
                @forelse ($mitras as $mitra)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="tk-card text-center p-3">
                            <x-public.media :url="$mitra->imageUrl()" :alt="$mitra->nama" icon="bi-building" imgClass="mb-2" placeholderClass="tk-placeholder" :width="120" :height="80" />
                            <div class="fw-semibold">{{ $mitra->nama }}</div>
                            <div class="text-muted-soft small">{{ $mitra->bidang }}</div>
                            @if ($mitra->website)
                                <a href="{{ $mitra->website }}" target="_blank" rel="noopener" class="small">Website</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <x-empty-state
                            icon="bi-buildings"
                            title="Belum ada mitra industri"
                            message="Daftar mitra industri akan tampil setelah pihak sekolah menambahkannya."
                        />
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection