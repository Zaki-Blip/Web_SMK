@extends('layouts.admin')
@section('title', 'Tambah Lowongan')
@section('heading', 'Tambah Lowongan')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.lowongan-bkk.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.lowongan.form', ['item' => new \App\Models\LowonganBkk(['is_published'=>true,'tipe'=>'penuh_waktu'])])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.lowongan-bkk.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection