@extends('layouts.admin')

@section('title', 'Ubah Jurusan')
@section('heading', 'Ubah Jurusan')

@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.jurusan.update', $jurusan) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.jurusan.form', ['jurusan' => $jurusan])
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-tk-primary">Simpan</button>
                <a href="{{ route('admin.jurusan.index') }}" class="btn btn-tk-outline">Batal</a>
            </div>
        </form>
    </div>
@endsection