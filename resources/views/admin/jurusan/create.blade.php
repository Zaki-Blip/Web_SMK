@extends('layouts.admin')

@section('title', 'Tambah Jurusan')
@section('heading', 'Tambah Jurusan')

@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.jurusan.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.jurusan.form', ['jurusan' => new \App\Models\Jurusan(['is_active' => true, 'urutan' => 0, 'lama_belajar' => '3 tahun'])])
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-tk-primary">Simpan</button>
                <a href="{{ route('admin.jurusan.index') }}" class="btn btn-tk-outline">Batal</a>
            </div>
        </form>
    </div>
@endsection