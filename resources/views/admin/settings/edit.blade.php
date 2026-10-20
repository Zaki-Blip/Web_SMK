@extends('layouts.admin')

@section('title', 'Pengaturan Situs')
@section('heading', 'Pengaturan Situs')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Pengaturan situs</h1>
            <p class="text-muted-soft mb-0">
                Data ini dipakai navbar, footer, halaman kontak, dan meta SEO di semua halaman publik.
            </p>
        </div>
    </div>

    <form method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-lg-7">
                <div class="tk-card p-3 mb-3">
                    <h2 class="h5 mb-3">Identitas sekolah</h2>

                    <x-admin.form-field name="school_name" label="Nama tampilan" :value="$settings->school_name" required maxlength="150" />

                    <x-admin.form-field name="address" label="Alamat" :value="$settings->address" maxlength="255" />

                    <x-admin.form-field name="phone" label="Telepon" :value="$settings->phone" maxlength="30"
                                        help="Tampilkan hanya nomor resmi sekolah." />

                    <x-admin.form-field name="email" type="email" label="Email" :value="$settings->email" maxlength="150" />

                    <x-admin.form-field name="opening_hours" label="Jam operasional" :value="$settings->opening_hours"
                                        placeholder="Senin-Jumat, 07.00-14.00 WIB" maxlength="150" />

                    <x-admin.form-field name="whatsapp_number" label="Nomor WhatsApp" :value="$settings->whatsapp_number"
                                        placeholder="0812xxxxxxx atau 62812xxxxxxx"
                                        help="Disimpan dalam format internasional tanpa tanda plus (62812…). Tautan wa.me dibuat otomatis." />

                    <x-admin.form-field name="maps_url" type="url" label="URL Google Maps" :value="$settings->maps_url"
                                        placeholder="https://maps.app.goo.gl/…" maxlength="500"
                                        help="Tempel tautan lokasi sekolah. Boleh dikosongkan bila belum dikonfirmasi." />
                </div>

                <div class="tk-card p-3">
                    <h2 class="h5 mb-3">SEO dasar</h2>

                    <x-admin.form-field name="meta_title" label="Judul meta" :value="$settings->meta_title" maxlength="150"
                                        help="Dipakai pada halaman beranda. Maksimal 150 karakter." />

                    <x-admin.form-field name="meta_description" type="textarea" label="Deskripsi meta"
                                        :value="$settings->meta_description" :rows="4" maxlength="300"
                                        help="Maksimal 300 karakter. Jangan menjanjikan peringkat di mesin pencari." />
                </div>
            </div>

            <div class="col-lg-5">
                <div class="tk-card p-3 mb-3">
                    <h2 class="h5 mb-3">Logo sekolah</h2>

                    <x-admin.image-uploader name="logo" label="Berkas logo" :current-url="$settings->logo_path ? \Illuminate\Support\Facades\Storage::disk(config('filesystems.uploads_disk', 'public'))->url($settings->logo_path) : null"
                                            help="JPG, PNG, atau WebP maksimal 2 MB. Lebar diperkecil otomatis ke 400 px." />
                </div>

                <div class="tk-card p-3">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-tk-primary">
                            <i class="bi bi-save me-1" aria-hidden="true"></i>Simpan pengaturan
                        </button>
                        <a class="btn btn-tk-outline" href="{{ route('admin.dashboard') }}">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

