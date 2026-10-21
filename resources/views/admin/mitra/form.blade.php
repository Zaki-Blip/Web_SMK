<div class="mb-3">
    <label class="form-label" for="nama">Nama mitra</label>
    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $mitra->nama ?? '') }}" required>
    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="bidang">Bidang</label>
    <input type="text" name="bidang" id="bidang" class="form-control" value="{{ old('bidang', $mitra->bidang ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label" for="website">Website</label>
    <input type="url" name="website" id="website" class="form-control" value="{{ old('website', $mitra->website ?? '') }}">
</div>
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label" for="urutan">Urutan</label>
        <input type="number" name="urutan" id="urutan" class="form-control" min="0" max="9999" value="{{ old('urutan', $mitra->urutan ?? 0) }}" required>
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $mitra->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Aktif</label>
        </div>
    </div>
</div>
<div class="mb-3 mt-3">
    <x-admin.image-uploader name="logo" label="Logo" :current-url="$mitra->imageUrl() ?? null" help="JPG, PNG, atau WebP maksimal 2 MB." />
</div>