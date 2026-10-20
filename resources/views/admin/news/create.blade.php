@extends('layouts.admin')

@section('title', 'Tulis berita')
@section('heading', 'Tulis berita')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Tulis berita</h1>
            <p class="text-muted-soft mb-0">Simpan sebagai draft bila belum siap diterbitkan.</p>
        </div>
    </div>

    @include('admin.news.form', ['news' => $news])
@endsection

