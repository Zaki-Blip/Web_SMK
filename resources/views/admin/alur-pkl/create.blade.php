@extends('layouts.admin')
@section('title', 'Tambah Alur PKL')
@section('heading', 'Tambah Alur PKL')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.alur-pkl.store') }}">
            @csrf
            @include('admin.alur-pkl.form', ['item' => $item])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.alur-pkl.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection
