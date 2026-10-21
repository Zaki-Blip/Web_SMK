@extends('layouts.admin')
@section('title', 'Tambah Struktur Organisasi')
@section('heading', 'Tambah Struktur Organisasi')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.struktur-organisasi.store') }}">
            @csrf
            @include('admin.struktur-organisasi.form', ['item' => $item, 'parents' => $parents])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection
