@extends('layouts.admin')

@section('title', 'Program')
@section('heading', 'Program')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Program</h1>
            <p class="text-muted-soft mb-0">Hanya program berstatus terbit yang tampil di website.</p>
        </div>

        <a class="btn btn-tk-primary" href="{{ route('admin.programs.create') }}">
            <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>Tambah program
        </a>
    </div>

    <div class="tk-card p-3 p-md-4 mb-3">
        <x-admin.search-input :value="$search" placeholder="Cari nama atau ringkasan program…" label="Cari program" />
    </div>

    <div class="tk-card">
        <x-admin.data-table :columns="['Gambar', 'Nama', 'Urutan', 'Status', 'Aksi']">
            @forelse ($programs as $program)
                <tr>
                    <td>
                        <x-public.media :url="$program->imageUrl()" :alt="'Gambar program '.$program->name"
                                        icon="bi-journal-bookmark" imgClass="tk-thumb" placeholderClass="tk-placeholder"
                                        :width="160" :height="90" />
                    </td>
                    <td>
                        <span class="fw-semibold d-block">{{ $program->name }}</span>
                        <span class="text-muted-soft small">{{ $program->slug }}</span>
                    </td>
                    <td>{{ $program->sort_order }}</td>
                    <td>
                        <x-admin.status-badge :state="$program->is_published ? 'published' : 'draft'" />
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-sm btn-tk-outline" href="{{ route('admin.programs.edit', $program) }}">
                                <i class="bi bi-pencil me-1" aria-hidden="true"></i>Ubah
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal" data-bs-target="#confirm-delete"
                                    data-delete-url="{{ route('admin.programs.destroy', $program) }}"
                                    data-delete-label="{{ $program->name }}">
                                <i class="bi bi-trash me-1" aria-hidden="true"></i>Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="tk-empty-cell">
                        {{ $search !== '' ? 'Tidak ada program yang cocok dengan pencarian.' : 'Belum ada program. Tambahkan program pertama.' }}
                    </td>
                </tr>
            @endforelse
        </x-admin.data-table>

        @if ($programs->hasPages())
            <div class="p-3">
                {{ $programs->links() }}
            </div>
        @endif
    </div>

    <x-admin.confirm-dialog
        title="Hapus program ini?"
        message="Program dan gambarnya akan dihapus permanen."
    />
@endsection
