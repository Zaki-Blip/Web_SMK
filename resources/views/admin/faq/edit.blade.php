@extends('layouts.admin')
@section('title', 'Ubah FAQ')
@section('heading', 'Ubah FAQ')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.faq.update', $item) }}">
            @csrf
            @method('PUT')
            @include('admin.faq.form', ['item' => $item])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.faq.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection