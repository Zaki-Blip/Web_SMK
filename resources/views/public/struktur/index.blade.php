@extends('layouts.public')

@section('title', 'Struktur Organisasi')
@section('meta_description', 'Struktur organisasi dan susunan jabatan di sekolah.')

@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading
                level="h1"
                title="Struktur Organisasi"
                description="Susunan jabatan dan unit kerja yang mendukung penyelenggaraan pendidikan."
                :compact="true"
            />
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if ($tree->isNotEmpty())
                <div class="row g-3">
                    @foreach ($tree as $node)
                        <div class="col-12">
                            <x-public.struktur-node :node="$node" />
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty-state
                    icon="bi-diagram-3"
                    title="Struktur organisasi belum diisi"
                    message="Susunan organisasi akan tampil setelah pihak sekolah menambahkannya."
                />
            @endif
        </div>
    </section>
@endsection
