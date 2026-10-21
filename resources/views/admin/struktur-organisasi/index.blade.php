@extends('layouts.admin')
@section('title', 'Struktur Organisasi')
@section('heading', 'Struktur Organisasi')
@section('content')
    <div class="tk-admin-page-head">
        <div><h1 class="h5 mb-1">Struktur Organisasi</h1></div>
        <a class="btn btn-tk-primary" href="{{ route('admin.struktur-organisasi.create') }}"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
    </div>
    <div class="tk-card p-3 mb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-6"><input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Cari nama atau jabatan..."></div>
            <div class="col-md-2"><button class="btn btn-tk-outline w-100">Cari</button></div>
        </form>
    </div>
    <div class="tk-card">
        <x-admin.data-table :columns="['Nama', 'Jabatan', 'Atasan', 'Urutan', 'Status', 'Aksi']">
            @forelse ($items as $item)
                <tr>
                    <td class="fw-semibold">{{ $item->nama }}</td>
                    <td>{{ $item->jabatan }}</td>
                    <td>{{ $item->parent?->nama ?: '-' }}</td>
                    <td>{{ $item->urutan }}</td>
                    <td><x-admin.status-badge :state="$item->is_active ? 'published' : 'draft'" /></td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-sm btn-tk-outline" href="{{ route('admin.struktur-organisasi.edit', $item) }}">Ubah</a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-delete-url="{{ route('admin.struktur-organisasi.destroy', $item) }}" data-delete-label="{{ $item->nama }}">Hapus</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="tk-empty-cell">Belum ada data.</td></tr>
            @endforelse
        </x-admin.data-table>
        @if ($items->hasPages()) <div class="p-3">{{ $items->links() }}</div> @endif
    </div>
    <x-admin.confirm-dialog title="Hapus data ini?" message="Data akan dihapus permanen." />
@endsection
