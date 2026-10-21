<div class="mb-3">
    <label class="form-label" for="nama">Nama</label>
    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $item->nama ?? '') }}" required>
    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="slug">Slug</label>
    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $item->slug ?? '') }}" placeholder="otomatis dari nama">
</div>
<div class="mb-3">
    <label class="form-label" for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
</div>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="pembina">Pembina</label>
        <input type="text" name="pembina" id="pembina" class="form-control" value="{{ old('pembina', $item->pembina ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="jadwal">Jadwal</label>
        <input type="text" name="jadwal" id="jadwal" class="form-control" value="{{ old('jadwal', $item->jadwal ?? '') }}">
    </div>
</div>
<div class="row g-3 mt-1">
    <div class="col-md-4">
        <label class="form-label" for="urutan">Urutan</label>
        <input type="number" name="urutan" id="urutan" class="form-control" min="0" max="9999" value="{{ old('urutan', $item->urutan ?? 0) }}" required>
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Aktif</label>
        </div>
    </div>
</div>
<div class="mb-3 mt-3">
    <x-admin.image-uploader name="gambar" label="Gambar" :current-url="$item->imageUrl() ?? null" help="JPG, PNG, atau WebP maksimal 2 MB." />
</div>