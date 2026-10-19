@extends('layouts.admin')

@section('title', 'Galeri')
@section('heading', 'Galeri')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Galeri</h1>
            <p class="text-muted-soft mb-0">
                Unggah foto kegiatan. Pastikan sudah ada izin sebelum mempublikasikan foto anak.
            </p>
        </div>

        <a class="btn btn-tk-primary" href="{{ route('admin.gallery.create') }}">
            <i class="bi bi-upload me-1" aria-hidden="true"></i>Unggah foto
        </a>
    </div>

    <div class="tk-card p-3 p-md-4 mb-3">
        <x-admin.search-input :value="$search" placeholder="Cari judul, keterangan, atau kategori…" label="Cari foto" />
    </div>

    <div class="tk-card">
        <x-admin.data-table :columns="['Foto', 'Judul', 'Kategori', 'Urutan', 'Status', 'Aksi']">
            @forelse ($items as $item)
                <tr>
                    <td>
                        <x-public.media :url="$item->imageUrl()" :alt="'Foto '.$item->title" icon="bi-images"
                                        imgClass="tk-thumb" placeholderClass="tk-placeholder" :width="160" :height="90" />
                    </td>
                    <td>
                        <span class="fw-semibold d-block">{{ $item->title }}</span>
                        <span class="text-muted-soft small">{{ \Illuminate\Support\Str::limit($item->caption, 60) }}</span>
                    </td>
                    <td>{{ $item->category ?: '—' }}</td>
                    <td>{{ $item->sort_order }}</td>
                    <td>
                        <x-admin.status-badge :state="$item->is_published ? 'published' : 'draft'" />
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-sm btn-tk-outline" href="{{ route('admin.gallery.edit', $item) }}">
                                <i class="bi bi-pencil me-1" aria-hidden="true"></i>Ubah
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal" data-bs-target="#confirm-delete"
                                    data-delete-url="{{ route('admin.gallery.destroy', $item) }}"
                                    data-delete-label="{{ $item->title }}">
                                <i class="bi bi-trash me-1" aria-hidden="true"></i>Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="tk-empty-cell">
                        {{ $search !== '' ? 'Tidak ada foto yang cocok dengan pencarian.' : 'Belum ada foto di galeri.' }}
                    </td>
                </tr>
            @endforelse
        </x-admin.data-table>

        @if ($items->hasPages())
            <div class="p-3">
                {{ $items->links() }}
            </div>
        @endif
    </div>

    <x-admin.confirm-dialog
        title="Hapus foto ini?"
        message="File gambar akan dihapus permanen dari penyimpanan."
    />
@endsection
