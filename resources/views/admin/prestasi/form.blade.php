<div class="mb-3">
    <label class="form-label" for="judul">Judul</label>
    <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $prestasi->judul ?? '') }}" required>
    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label" for="tingkat">Tingkat</label>
        <select name="tingkat" id="tingkat" class="form-select" required>
            @foreach (['sekolah','kota','provinsi','nasional','internasional'] as $t)
                <option value="{{ $t }}" @selected(old('tingkat', $prestasi->tingkat ?? 'sekolah')===$t)>{{ ucfirst($t) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="tahun">Tahun</label>
        <input type="number" name="tahun" id="tahun" class="form-control" value="{{ old('tahun', $prestasi->tahun ?? now()->year) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label" for="peraih">Peraih</label>
        <input type="text" name="peraih" id="peraih" class="form-control" value="{{ old('peraih', $prestasi->peraih ?? '') }}">
    </div>
</div>
<div class="mb-3 mt-3">
    <label class="form-label" for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $prestasi->deskripsi ?? '') }}</textarea>
</div>
<div class="mb-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $prestasi->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Aktif</label>
    </div>
</div>
<div class="mb-3">
    <x-admin.image-uploader name="gambar" label="Gambar" :current-url="$prestasi->imageUrl() ?? null" help="JPG, PNG, atau WebP maksimal 2 MB." />
</div>