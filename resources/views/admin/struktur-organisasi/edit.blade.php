@extends('layouts.admin')
@section('title', 'Ubah Struktur Organisasi')
@section('heading', 'Ubah Struktur Organisasi')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.struktur-organisasi.update', $item) }}">
            @csrf
            @method('PUT')
            @include('admin.struktur-organisasi.form', ['item' => $item, 'parents' => $parents])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.struktur-organisasi.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection
