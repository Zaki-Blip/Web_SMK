@extends('layouts.admin')

@section('title', 'Profil Sekolah')
@section('heading', 'Profil Sekolah')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Profil sekolah</h1>
            <p class="text-muted-soft mb-0">Sejarah, visi, misi, dan deskripsi. Hanya ada satu profil sekolah.</p>
        </div>

        <a class="btn btn-tk-outline" href="{{ route('admin.settings.edit') }}">
            <i class="bi bi-gear me-1" aria-hidden="true"></i>Identitas &amp; kontak ada di Pengaturan
        </a>
    </div>

    <form method="post" action="{{ route('admin.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-lg-7">
                <div class="tk-card p-3 mb-3">
                    <h2 class="h5 mb-3">Identitas</h2>
                    <x-admin.form-field name="school_name" label="Nama sekolah" :value="$profile->school_name" maxlength="150" />
                    <x-admin.form-field name="description" type="textarea" label="Deskripsi singkat" :value="$profile->description"
                                        :rows="5" help="Tampil pada halaman beranda dan profil." />
                </div>

                <div class="tk-card p-3">
                    <h2 class="h5 mb-3">Sejarah</h2>
                    <x-admin.form-field name="history" type="textarea" label="Sejarah sekolah" :value="$profile->history"
                                        :rows="10" help="Tulis hanya informasi yang sudah dikonfirmasi pihak sekolah." />
                </div>
            </div>

            <div class="col-lg-5">
                <div class="tk-card p-3 mb-3">
                    <h2 class="h5 mb-3">Visi</h2>
                    <x-admin.form-field name="vision" type="textarea" label="Visi sekolah" :value="$profile->vision" :rows="5" />
                </div>

                <div class="tk-card p-3 mb-3">
                    <h2 class="h5 mb-3">Misi</h2>
                    <x-admin.form-field name="mission" type="textarea" label="Misi sekolah" :value="$profile->mission"
                                        :rows="8" help="Tulis satu misi per baris." />
                </div>

                <div class="tk-card p-3">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-tk-primary">
                            <i class="bi bi-save me-1" aria-hidden="true"></i>Simpan profil
                        </button>
                        <a class="btn btn-tk-outline" href="{{ route('admin.dashboard') }}">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="tk-card p-3 mt-3">
        <h2 class="h5 mb-2">Identitas pada halaman publik</h2>
        <dl class="row mb-0">
            <dt class="col-sm-3">Alamat</dt>
            <dd class="col-sm-9">{{ $site->address ?: 'Belum diisi' }}</dd>

            <dt class="col-sm-3">Telepon</dt>
            <dd class="col-sm-9">{{ $site->phone ?: 'Belum diisi' }}</dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9 mb-0">{{ $site->email ?: 'Belum diisi' }}</dd>
        </dl>
    </div>
@endsection

