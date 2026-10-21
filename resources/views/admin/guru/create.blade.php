@extends('layouts.admin')
@section('title', 'Tambah Guru/Staf')
@section('heading', 'Tambah Guru/Staf')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.guru.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.guru.form', ['guru' => new \App\Models\Guru(['is_active'=>true,'tipe'=>'guru','urutan'=>0])])
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-tk-primary">Simpan</button>
                <a href="{{ route('admin.guru.index') }}" class="btn btn-tk-outline">Batal</a>
            </div>
        </form>
    </div>
@endsection