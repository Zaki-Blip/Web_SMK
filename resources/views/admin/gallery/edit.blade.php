@extends('layouts.admin')

@section('title', 'Ubah foto')
@section('heading', 'Ubah foto')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Ubah foto</h1>
            <p class="text-muted-soft mb-0">{{ $item->title }}</p>
        </div>

        <a class="btn btn-tk-outline" href="{{ route('admin.gallery.index') }}">
            <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Kembali ke galeri
        </a>
    </div>

    @include('admin.gallery.form', ['item' => $item])
@endsection

