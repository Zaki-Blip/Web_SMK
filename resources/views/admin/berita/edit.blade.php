@extends('layouts.admin')

@section('title', 'Ubah berita')
@section('heading', 'Ubah berita')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Ubah berita</h1>
            <p class="text-muted-soft mb-0">{{ $news->title }}</p>
        </div>

        <a class="btn btn-tk-outline" href="{{ route('admin.berita.index') }}">
            <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Kembali ke daftar
        </a>
    </div>

    @include('admin.berita.form', ['news' => $news])
@endsection

