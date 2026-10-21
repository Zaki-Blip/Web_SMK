@php
    $isEdit = isset($jurusan) && $jurusan->exists;
@endphp

<div class="mb-3">
    <label class="form-label" for="nama">Nama jurusan</label>
    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
           value="{{ old('nama', $jurusan->nama ?? '') }}" required>
    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label" for="singkatan">Singkatan</label>
        <input type="text" name="singkatan" id="singkatan" class="form-control @error('singkatan') is-invalid @enderror"
               value="{{ old('singkatan', $jurusan->singkatan ?? '') }}">
        @error('singkatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label" for="slug">Slug</label>
        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
               value="{{ old('slug', $jurusan->slug ?? '') }}" placeholder="otomatis dari nama">
        @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label" for="lama_belajar">Lama belajar</label>
        <input type="text" name="lama_belajar" id="lama_belajar" class="form-control"
               value="{{ old('lama_belajar', $jurusan->lama_belajar ?? '3 tahun') }}">
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label" for="ringkasan">Ringkasan (maks. 255)</label>
    <input type="text" name="ringkasan" id="ringkasan" class="form-control @error('ringkasan') is-invalid @enderror"
           value="{{ old('ringkasan', $jurusan->ringkasan ?? '') }}">
    @error('ringkasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi" rows="6" class="form-control">{{ old('deskripsi', $jurusan->deskripsi ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label" for="kompetensi">Kompetensi (satu per baris)</label>
    <textarea name="kompetensi" id="kompetensi" rows="6" class="form-control">{{ old('kompetensi', is_array($jurusan->kompetensi ?? null) ? implode("\n", $jurusan->kompetensi) : ($jurusan->kompetensi ?? '')) }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label" for="prospek_karier">Prospek karier</label>
    <textarea name="prospek_karier" id="prospek_karier" rows="3" class="form-control">{{ old('prospek_karier', $jurusan->prospek_karier ?? '') }}</textarea>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label" for="urutan">Urutan</label>
        <input type="number" name="urutan" id="urutan" class="form-control" min="0" max="9999"
               value="{{ old('urutan', $jurusan->urutan ?? 0) }}" required>
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $jurusan->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Aktif (tampil di website)</label>
        </div>
    </div>
</div>

<div class="mb-3 mt-3">
    <x-admin.image-uploader name="gambar" label="Gambar jurusan" :current-url="$jurusan->imageUrl() ?? null" help="JPG, PNG, atau WebP maksimal 2 MB." />
</div>