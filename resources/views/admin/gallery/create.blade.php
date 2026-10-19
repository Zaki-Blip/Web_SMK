@extends('layouts.admin')

@section('title', 'Unggah foto')
@section('heading', 'Unggah foto')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Unggah foto</h1>
            <p class="text-muted-soft mb-0">
                Hanya unggah foto yang sudah mendapat izin publikasi dari orang tua/wali.
            </p>
        </div>
    </div>

    @include('admin.gallery.form', ['item' => $item])
@endsection
