@extends('layouts.public')

@php
    $spmb = $spmb ?? \App\Models\Spmb::current();
@endphp

@section('title', 'SPMB')
@section('meta_description', 'Informasi jalur, persyaratan, alur, dan jadwal SPMB SMK Negeri 64 Jakarta.')

@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading
                level="h1"
                title="Sistem Penerimaan Murid Baru"
                description="Informasi jalur, persyaratan, alur, dan jadwal penerimaan peserta didik baru."
                :compact="true"
            />
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if (! $spmb->is_open)
                <x-empty-state
                    icon="bi-clipboard-check"
                    title="Informasi pendaftaran belum dibuka"
                    message="Informasi pendaftaran akan diperbarui oleh pihak sekolah."
                />
            @else
                <div class="row g-4">
                    <div class="col-lg-8">
                        @if ($spmb->tahun_ajaran)
                            <p class="text-muted-soft">
                                Tahun ajaran <strong class="text-body">{{ $spmb->tahun_ajaran }}</strong>
                            </p>
                        @endif

                        @if (is_array($spmb->jalur) && count($spmb->jalur))
                            <div class="tk-card p-3 p-md-4 mb-3">
                                <h2 class="h5 mb-3">Jalur &amp; Kuota</h2>
                                <div class="table-responsive">
                                    <table class="table table-sm align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Jalur</th>
                                                <th scope="col">Kuota</th>
                                                <th scope="col">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($spmb->jalur as $j)
                                                <tr>
                                                    <td class="fw-semibold">{{ $j['nama'] ?? '' }}</td>
                                                    <td>{{ $j['kuota'] ?? '—' }}</td>
                                                    <td class="text-muted-soft">{{ $j['keterangan'] ?? '—' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if ($spmb->syarat)
                            <div class="tk-card p-3 p-md-4 mb-3">
                                <h2 class="h5 mb-3">Persyaratan</h2>
                                <div class="tk-prose">{!! nl2br(e($spmb->syarat)) !!}</div>
                            </div>
                        @endif

                        @if (is_array($spmb->alur) && count($spmb->alur))
                            <div class="tk-card p-3 p-md-4 mb-3">
                                <h2 class="h5 mb-3">Alur Pendaftaran</h2>
                                <ol class="mb-0">
                                    @foreach ($spmb->alur as $a)
                                        <li class="mb-2">{{ is_array($a) ? ($a['teks'] ?? $a['langkah'] ?? '') : $a }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        @endif

                        @if (is_array($spmb->jadwal) && count($spmb->jadwal))
                            <div class="tk-card p-3 p-md-4">
                                <h2 class="h5 mb-3">Jadwal</h2>
                                <div class="table-responsive">
                                    <table class="table table-sm align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Kegiatan</th>
                                                <th scope="col">Mulai</th>
                                                <th scope="col">Selesai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($spmb->jadwal as $j)
                                                <tr>
                                                    <td class="fw-semibold">{{ $j['kegiatan'] ?? '' }}</td>
                                                    <td>{{ $j['mulai'] ?? '—' }}</td>
                                                    <td>{{ $j['selesai'] ?? '—' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>

                    <aside class="col-lg-4">
                        <div class="tk-card p-3 p-md-4">
                            <h2 class="h6 text-uppercase text-muted-soft mb-3">Pendaftaran</h2>

                            @if ($spmb->tautan_pendaftaran)
                                <a href="{{ $spmb->tautan_pendaftaran }}" target="_blank" rel="noopener" class="btn btn-tk-primary w-100">
                                    Daftar Sekarang
                                </a>
                            @else
                                <p class="text-muted-soft small mb-0">
                                    Tautan pendaftaran belum tersedia. Silakan hubungi panitia untuk informasi lebih lanjut.
                                </p>
                            @endif

                            @if ($spmb->kontak_panitia)
                                <hr class="tk-divider my-3">
                                <h3 class="h6 mb-1">Kontak Panitia</h3>
                                <p class="mb-0 small">{{ $spmb->kontak_panitia }}</p>
                            @endif
                        </div>
                    </aside>
                </div>
            @endif
        </div>
    </section>

    <section class="section bg-white border-top">
        <div class="container">
            <x-section-heading
                eyebrow="FAQ"
                title="Pertanyaan seputar SPMB"
                description="Jawaban singkat untuk pertanyaan yang paling sering diajukan."
            />

            <x-public.faq-list :items="$faqs" id="faq-spmb" />
        </div>
    </section>
@endsection
