@extends('layouts.admin')

@section('title', 'Fasilitas')
@section('heading', 'Fasilitas')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Fasilitas</h1>
            <p class="text-muted-soft mb-0">Hanya fasilitas berstatus terbit yang tampil di website.</p>
        </div>

        <a class="btn btn-tk-primary" href="{{ route('admin.facilities.create') }}">
            <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>Tambah fasilitas
        </a>
    </div>

    <div class="tk-card p-3 p-md-4 mb-3">
        <x-admin.search-input :value="$search" placeholder="Cari nama atau keterangan fasilitas…" label="Cari fasilitas" />
    </div>

    <div class="tk-card">
        <x-admin.data-table :columns="['Gambar', 'Nama', 'Urutan', 'Status', 'Aksi']">
            @forelse ($facilities as $facility)
                <tr>
                    <td>
                        <x-public.media :url="$facility->imageUrl()" :alt="'Gambar fasilitas '.$facility->name"
                                        icon="bi-building" imgClass="tk-thumb" placeholderClass="tk-placeholder"
                                        :width="160" :height="90" />
                    </td>
                    <td>
                        <span class="fw-semibold d-block">{{ $facility->name }}</span>
                        <span class="text-muted-soft small">{{ $facility->slug }}</span>
                    </td>
                    <td>{{ $facility->sort_order }}</td>
                    <td>
                        <x-admin.status-badge :state="$facility->is_published ? 'published' : 'draft'" />
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-sm btn-tk-outline" href="{{ route('admin.facilities.edit', $facility) }}">
                                <i class="bi bi-pencil me-1" aria-hidden="true"></i>Ubah
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal" data-bs-target="#confirm-delete"
                                    data-delete-url="{{ route('admin.facilities.destroy', $facility) }}"
                                    data-delete-label="{{ $facility->name }}">
                                <i class="bi bi-trash me-1" aria-hidden="true"></i>Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="tk-empty-cell">
                        {{ $search !== '' ? 'Tidak ada fasilitas yang cocok dengan pencarian.' : 'Belum ada fasilitas. Tambahkan fasilitas pertama.' }}
                    </td>
                </tr>
            @endforelse
        </x-admin.data-table>

        @if ($facilities->hasPages())
            <div class="p-3">
                {{ $facilities->links() }}
            </div>
        @endif
    </div>

    <x-admin.confirm-dialog
        title="Hapus fasilitas ini?"
        message="Fasilitas dan gambarnya akan dihapus permanen."
    />
@endsection
