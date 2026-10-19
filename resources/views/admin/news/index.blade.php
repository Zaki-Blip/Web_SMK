@extends('layouts.admin')

@section('title', 'Berita')
@section('heading', 'Berita')

@php
    // Tautan filter mempertahankan kata kunci pencarian yang sedang aktif.
    $filterUrl = fn (string $value) => route('admin.news.index', array_filter(['q' => $search ?: null, 'status' => $value ?: null]));
@endphp

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Berita</h1>
            <p class="text-muted-soft mb-0">
                Draft dan berita dengan tanggal publikasi di masa depan tidak tampil di website.
            </p>
        </div>

        <a class="btn btn-tk-primary" href="{{ route('admin.news.create') }}">
            <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>Tulis berita
        </a>
    </div>

    <div class="tk-card p-3 p-md-4 mb-3">
        <x-admin.search-input :value="$search" placeholder="Cari judul atau isi berita…" label="Cari berita" />

        <div class="d-flex flex-wrap gap-2 mt-3">
            <a class="btn btn-sm {{ $status === '' ? 'btn-tk-primary' : 'btn-tk-outline' }}" href="{{ $filterUrl('') }}">
                Semua ({{ $totalCount }})
            </a>
            <a class="btn btn-sm {{ $status === 'published' ? 'btn-tk-primary' : 'btn-tk-outline' }}" href="{{ $filterUrl('published') }}">
                Terbit ({{ $publishedCount }})
            </a>
            <a class="btn btn-sm {{ $status === 'draft' ? 'btn-tk-primary' : 'btn-tk-outline' }}" href="{{ $filterUrl('draft') }}">
                Draft ({{ $draftCount }})
            </a>
        </div>
    </div>

    <div class="tk-card">
        <x-admin.data-table :columns="['Judul', 'Tanggal publikasi', 'Status', 'Aksi']">
            @forelse ($newsItems as $item)
                <tr>
                    <td>
                        <span class="fw-semibold d-block">{{ $item->title }}</span>
                        <span class="text-muted-soft small">{{ $item->slug }}</span>
                    </td>
                    <td>
                        {{ $item->published_at ? \App\Support\IndonesianDate::longWithTime($item->published_at) : '—' }}
                    </td>
                    <td>
                        <x-admin.status-badge :state="$item->displayStatus()" />
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            @if ($item->displayStatus() === 'published')
                                <a class="btn btn-sm btn-tk-outline" href="{{ route('news.show', $item->slug) }}" target="_blank" rel="noopener">
                                    <i class="bi bi-eye me-1" aria-hidden="true"></i>Lihat
                                </a>
                            @endif
                            <a class="btn btn-sm btn-tk-outline" href="{{ route('admin.news.edit', $item) }}">
                                <i class="bi bi-pencil me-1" aria-hidden="true"></i>Ubah
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal" data-bs-target="#confirm-delete"
                                    data-delete-url="{{ route('admin.news.destroy', $item) }}"
                                    data-delete-label="{{ $item->title }}">
                                <i class="bi bi-trash me-1" aria-hidden="true"></i>Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="tk-empty-cell">
                        {{ $search !== '' || $status !== '' ? 'Tidak ada berita yang cocok dengan filter ini.' : 'Belum ada berita.' }}
                    </td>
                </tr>
            @endforelse
        </x-admin.data-table>

        @if ($newsItems->hasPages())
            <div class="p-3">
                {{ $newsItems->links() }}
            </div>
        @endif
    </div>

    <x-admin.confirm-dialog
        title="Hapus berita ini?"
        message="Berita dan gambarnya akan dihapus permanen."
    />
@endsection
