@extends('layouts.admin')
@section('title', 'Tambah FAQ')
@section('heading', 'Tambah FAQ')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.faq.store') }}">
            @csrf
            @include('admin.faq.form', ['item' => new \App\Models\Faq(['is_active'=>true,'kategori'=>'umum','urutan'=>0])])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.faq.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection