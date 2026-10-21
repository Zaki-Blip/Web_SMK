@extends('layouts.admin')
@section('title', 'FAQ')
@section('heading', 'FAQ')
@section('content')
    <div class="tk-admin-page-head">
        <div><h1 class="h5 mb-1">FAQ</h1></div>
        <a class="btn btn-tk-primary" href="{{ route('admin.faq.create') }}"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
    </div>
    <div class="tk-card">
        <x-admin.data-table :columns="['Pertanyaan', 'Kategori', 'Urutan', 'Status', 'Aksi']">
            @forelse ($items as $item)
                <tr>
                    <td class="fw-semibold">{{ $item->pertanyaan }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->urutan }}</td>
                    <td><x-admin.status-badge :state="$item->is_active ? 'published' : 'draft'" /></td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-sm btn-tk-outline" href="{{ route('admin.faq.edit', $item) }}">Ubah</a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-delete-url="{{ route('admin.faq.destroy', $item) }}" data-delete-label="{{ $item->pertanyaan }}">Hapus</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="tk-empty-cell">Belum ada data.</td></tr>
            @endforelse
        </x-admin.data-table>
        @if ($items->hasPages()) <div class="p-3">{{ $items->links() }}</div> @endif
    </div>
    <x-admin.confirm-dialog title="Hapus data ini?" message="Data akan dihapus permanen." />
@endsection