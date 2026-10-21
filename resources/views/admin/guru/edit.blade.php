@extends('layouts.admin')
@section('title', 'Ubah Guru/Staf')
@section('heading', 'Ubah Guru/Staf')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.guru.update', $guru) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.guru.form', ['guru' => $guru])
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-tk-primary">Simpan</button>
                <a href="{{ route('admin.guru.index') }}" class="btn btn-tk-outline">Batal</a>
            </div>
        </form>
    </div>
@endsection