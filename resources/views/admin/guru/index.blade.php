@extends('layouts.admin')
@section('title', 'Guru & Staf')
@section('heading', 'Guru & Staf')
@section('content')
    <div class="tk-admin-page-head">
        <div><h1 class="h5 mb-1">Guru & Staf</h1><p class="text-muted-soft mb-0">Pengelolaan guru dan tenaga kependidikan.</p></div>
        <a class="btn btn-tk-primary" href="{{ route('admin.guru.create') }}"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
    </div>
    <div class="tk-card p-3 mb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-4"><input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Cari nama..."></div>
            <div class="col-md-3">
                <select name="tipe" class="form-select">
                    <option value="">Semua tipe</option>
                    <option value="guru" @selected($tipe==='guru')>Guru</option>
                    <option value="staf" @selected($tipe==='staf')>Staf</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="jurusan_id" class="form-select">
                    <option value="">Semua jurusan</option>
                    @foreach ($jurusans as $j)
                        <option value="{{ $j->id }}" @selected($jurusanId==$j->id)>{{ $j->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-tk-outline w-100">Cari</button></div>
        </form>
    </div>
    <div class="tk-card">
        <x-admin.data-table :columns="['Foto', 'Nama', 'Jabatan', 'Tipe', 'Status', 'Aksi']">
            @forelse ($gurus as $guru)
                <tr>
                    <td><x-public.media :url="$guru->imageUrl()" :alt="$guru->nama" icon="bi-person" imgClass="tk-thumb" placeholderClass="tk-placeholder" :width="80" :height="80" /></td>
                    <td><span class="fw-semibold d-block">{{ $guru->nama }}</span><span class="text-muted-soft small">{{ $guru->mata_pelajaran }}</span></td>
                    <td>{{ $guru->jabatan }}</td>
                    <td>{{ ucfirst($guru->tipe) }}</td>
                    <td><x-admin.status-badge :state="$guru->is_active ? 'published' : 'draft'" /></td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-sm btn-tk-outline" href="{{ route('admin.guru.edit', $guru) }}">Ubah</a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-delete-url="{{ route('admin.guru.destroy', $guru) }}" data-delete-label="{{ $guru->nama }}">Hapus</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="tk-empty-cell">Belum ada data.</td></tr>
            @endforelse
        </x-admin.data-table>
        @if ($gurus->hasPages()) <div class="p-3">{{ $gurus->links() }}</div> @endif
    </div>
    <x-admin.confirm-dialog title="Hapus data ini?" message="Data akan dihapus permanen." />
@endsection