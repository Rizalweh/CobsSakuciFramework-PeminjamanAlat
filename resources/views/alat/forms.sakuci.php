<div class="mb-3">
    <label for="kode_alat" class="form-label">Kode Alat</label>
    <input type="text" id="kode_alat" name="kode_alat" class="form-control
@error('kode_alat') is-invalid @enderror" value="{{ old('kode_alat', $alat->kode_alat ??
'') }}" required>
    @error('kode_alat') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="nama_alat" class="form-label">Nama Alat</label>
    <input type="text" id="nama_alat" name="nama_alat" class="form-control
@error('nama_alat') is-invalid @enderror" value="{{ old('nama_alat', $alat->nama_alat ??
'') }}" required>
    @error('nama_alat') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="merk" class="form-label">Merk</label>
    <input type="text" id="merk" name="merk" class="form-control @error('merk') is-invalid
@enderror" value="{{ old('merk', $alat->merk ?? '') }}">
    @error('merk') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="stok" class="form-label">Stok</label>
    <input type="number" id="stok" name="stok" min="0" class="form-control @error('stok')
is-invalid @enderror" value="{{ old('stok', $alat->stok ?? 0) }}" required>
    @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="kondisi" class="form-label">Kondisi</label>
    <select id="kondisi" name="kondisi" class="form-select @error('kondisi') is-invalid
@enderror" required>
        <option value="baik" @selected(old('kondisi', $alat->kondisi ?? 'baik') ===
            'baik')>Baik</option>
        <option value="rusak_ringan" @selected(old('kondisi', $alat->kondisi ?? '') ===
            'rusak_ringan')>Rusak Ringan</option>
        <option value="rusak_berat" @selected(old('kondisi', $alat->kondisi ?? '') ===
            'rusak_berat')>Rusak Berat</option>
    </select>
    @error('kondisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="keterangan" class="form-label">Keterangan</label>
    <textarea id="keterangan" name="keterangan" rows="4" class="form-control
@error('keterangan') is-invalid @enderror">{{ old('keterangan', $alat->keterangan ??
'') }}</textarea>
    @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('alat.index') }}" class="btn btn-secondary">Kembali</a>