<div class="mb-3">
    <label class="form-label" for="pertanyaan">Pertanyaan</label>
    <input type="text" name="pertanyaan" id="pertanyaan" class="form-control @error('pertanyaan') is-invalid @enderror" value="{{ old('pertanyaan', $item->pertanyaan ?? '') }}" required>
    @error('pertanyaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="jawaban">Jawaban</label>
    <textarea name="jawaban" id="jawaban" rows="4" class="form-control @error('jawaban') is-invalid @enderror" required>{{ old('jawaban', $item->jawaban ?? '') }}</textarea>
    @error('jawaban') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label" for="kategori">Kategori</label>
        <select name="kategori" id="kategori" class="form-select" required>
            <option value="umum" @selected(old('kategori', $item->kategori ?? 'umum')==='umum')>Umum</option>
            <option value="spmb" @selected(old('kategori', $item->kategori ?? 'umum')==='spmb')>SPMB</option>
        </select>
    </div>
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