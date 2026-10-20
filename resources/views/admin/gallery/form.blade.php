@php
    $isEdit = $item->exists;
    $action = $isEdit ? route('admin.gallery.update', $item) : route('admin.gallery.store');
@endphp

<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="tk-card p-3">
                <h2 class="h5 mb-3">Metadata foto</h2>

                <x-admin.form-field name="title" label="Judul foto" :value="$item->title" required maxlength="150" />

                <x-admin.form-field name="caption" type="textarea" label="Keterangan" :value="$item->caption" :rows="4"
                                    help="Maksimal 500 karakter. Keterangan tampil di bawah foto pada galeri." maxlength="500" />

                <x-admin.form-field name="category" label="Kategori" :value="$item->category"
                                    help="Contoh: Kegiatan, Kelas, Lingkungan. Boleh dikosongkan." maxlength="50" />
            </div>
        </div>

        <div class="col-lg-5">
            <div class="tk-card p-3 mb-3">
                <h2 class="h5 mb-3">Berkas foto</h2>

                <x-admin.image-uploader name="image" label="Foto" :current-url="$item->imageUrl()" :required="! $isEdit"
                                        help="JPG, PNG, atau WebP maksimal 2 MB. Lebar diperkecil otomatis ke 1600 px." />
            </div>

            <div class="tk-card p-3">
                <h2 class="h5 mb-3">Publikasi</h2>

                <x-admin.form-field name="sort_order" type="number" label="Urutan tampil" :value="$item->sort_order"
                                    min="0" max="9999" help="Angka kecil tampil lebih dulu." required />

                <x-admin.form-field name="is_published" type="switch" label="Status" :value="$item->is_published"
                                    placeholder="Tampilkan di galeri publik" />

                <div class="d-flex flex-wrap gap-2 mt-3">
                    <button type="submit" class="btn btn-tk-primary">
                        <i class="bi bi-save me-1" aria-hidden="true"></i>{{ $isEdit ? 'Simpan perubahan' : 'Simpan foto' }}
                    </button>
                    <a class="btn btn-tk-outline" href="{{ route('admin.gallery.index') }}">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>

