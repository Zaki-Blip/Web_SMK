@extends('layouts.admin')

@section('title', 'Jurusan')
@section('heading', 'Jurusan')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Kompetensi Keahlian (Jurusan)</h1>
            <p class="text-muted-soft mb-0">Hanya jurusan aktif yang tampil di website.</p>
        </div>

        <a class="btn btn-tk-primary" href="{{ route('admin.jurusan.create') }}">
            <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>Tambah jurusan
        </a>
    </div>

    <div class="tk-card p-3 mb-3">
        <x-admin.search-input :value="$search" placeholder="Cari nama atau ringkasan jurusan…" label="Cari jurusan" />
    </div>

    <div class="tk-card">
        <x-admin.data-table :columns="['Gambar', 'Nama', 'Singkatan', 'Urutan', 'Status', 'Aksi']">
            @forelse ($jurusans as $jurusan)
                <tr>
                    <td>
                        <x-public.media :url="$jurusan->imageUrl()" :alt="'Gambar jurusan '.$jurusan->nama"
                                        icon="bi-mortarboard" imgClass="tk-thumb" placeholderClass="tk-placeholder"
                                        :width="160" :height="90" />
                    </td>
                    <td>
                        <span class="fw-semibold d-block">{{ $jurusan->nama }}</span>
                        <span class="text-muted-soft small">{{ $jurusan->slug }}</span>
                    </td>
                    <td>{{ $jurusan->singkatan }}</td>
                    <td>{{ $jurusan->urutan }}</td>
                    <td>
                        <x-admin.status-badge :state="$jurusan->is_active ? 'published' : 'draft'" />
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-sm btn-tk-outline" href="{{ route('admin.jurusan.edit', $jurusan) }}">
                                <i class="bi bi-pencil me-1" aria-hidden="true"></i>Ubah
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal" data-bs-target="#confirm-delete"
                                    data-delete-url="{{ route('admin.jurusan.destroy', $jurusan) }}"
                                    data-delete-label="{{ $jurusan->nama }}">
                                <i class="bi bi-trash me-1" aria-hidden="true"></i>Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="tk-empty-cell">
                        {{ $search !== '' ? 'Tidak ada jurusan yang cocok dengan pencarian.' : 'Belum ada jurusan. Tambahkan jurusan pertama.' }}
                    </td>
                </tr>
            @endforelse
        </x-admin.data-table>

        @if ($jurusans->hasPages())
            <div class="p-3">
                {{ $jurusans->links() }}
            </div>
        @endif
    </div>

    <x-admin.confirm-dialog
        title="Hapus jurusan ini?"
        message="Jurusan dan gambarnya akan dihapus permanen."
    />
@endsection