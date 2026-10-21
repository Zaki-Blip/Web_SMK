@php
    $isEdit = $news->exists;
    $action = $isEdit ? route('admin.berita.update', $news) : route('admin.berita.store');
    $publishedAtValue = old('published_at', $news->published_at?->format('Y-m-d\TH:i'));
@endphp

<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="tk-card p-3">
                <h2 class="h5 mb-3">Isi berita</h2>

                <x-admin.form-field name="title" label="Judul berita" :value="$news->title" required maxlength="200" />

                <x-admin.form-field name="slug" label="Slug" :value="$news->slug"
                                    help="Dipakai pada alamat berita. Kosongkan untuk dibuat otomatis dari judul." maxlength="200" />

                <x-admin.form-field name="excerpt" type="textarea" label="Ringkasan" :value="$news->excerpt" :rows="2"
                                    help="Tampil pada daftar berita dan deskripsi mesin pencari. Maksimal 300 karakter." maxlength="300" />

                <x-admin.form-field name="kategori" label="Kategori" :value="$news->kategori" maxlength="50"
                                    help="Contoh: berita, pengumuman, prestasi, atau kegiatan." />

                <x-admin.form-field name="body" type="textarea" label="Isi berita" :value="$news->body" :rows="10"
                                    help="Teks biasa tanpa HTML. Baris baru akan tampil apa adanya." required />
            </div>
        </div>

        <div class="col-lg-4">
            <div class="tk-card p-3 mb-3">
                <h2 class="h5 mb-3">Publikasi</h2>

                <x-admin.form-field name="status" type="select" label="Status" :value="$news->status"
                                    :options="['draft' => 'Draft (belum tampil)', 'published' => 'Terbit']" required />

                <label class="form-label" for="field-published_at">Tanggal publikasi</label>
                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                       id="field-published_at" name="published_at" value="{{ $publishedAtValue }}">
                @error('published_at')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <p class="form-text">
                    Berita terbit hanya bila tanggalnya sudah lewat. Tanggal di masa depan membuat berita terjadwal.
                </p>
            </div>

            <div class="tk-card p-3 mb-3">
                <h2 class="h5 mb-3">Gambar</h2>

                <x-admin.image-uploader name="image" label="Gambar berita" :current-url="$news->imageUrl()"
                                        help="JPG, PNG, atau WebP maksimal 2 MB. Lebar diperkecil otomatis ke 1600 px." />
            </div>

            <div class="tk-card p-3">
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-tk-primary">
                        <i class="bi bi-save me-1" aria-hidden="true"></i>{{ $isEdit ? 'Simpan perubahan' : 'Simpan berita' }}
                    </button>
                    <a class="btn btn-tk-outline" href="{{ route('admin.berita.index') }}">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>

