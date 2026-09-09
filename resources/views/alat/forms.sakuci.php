<div class="mb-3">
    <label for="kode_alat" class="form-label">Kode Alat</label>
    <input type="text" class="form-control" id="kode_alat" name="kode_alat"
           placeholder="Contoh: ALT-001"
           value="{{ old('kode_alat', $alat->kode_alat ?? '') }}">
    @error('kode_alat')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="nama_alat" class="form-label">Nama Alat</label>
    <input type="text" class="form-control" id="nama_alat" name="nama_alat"
           placeholder="Contoh: Bor Listrik"
           value="{{ old('nama_alat', $alat->nama_alat ?? '') }}">
    @error('nama_alat')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="stok" class="form-label">Stok</label>
    <input type="number" class="form-control" id="stok" name="stok"
           placeholder="Contoh: 10"
           value="{{ old('stok', $alat->stok ?? '') }}">
    @error('stok')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="kondisi" class="form-label">Kondisi</label>
    <select class="form-select" id="kondisi" name="kondisi">
        <option value="" disabled selected>Pilih kondisi alat</option>
        <option value="baik" {{ old('kondisi', $alat->kondisi ?? '') === 'baik' ? 'selected' : '' }}>Baik</option>
        <option value="rusak" {{ old('kondisi', $alat->kondisi ?? '') === 'rusak' ? 'selected' : '' }}>Rusak</option>
        <option value="rusak-berat" {{ old('kondisi', $alat->kondisi ?? '') === 'rusak-berat' ? 'selected' : '' }}>Rusak Berat</option>
    </select>
    @error('kondisi')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="foto_alat" class="form-label">Foto Alat</label>
    <input type="file" class="form-control" id="foto_alat" name="foto_alat">
    @if(isset($alat) && $alat->foto_alat)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $alat->foto_alat) }}" alt="Foto Alat" width="120">
        </div>
    @endif
    @error('foto_alat')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('alat.index') }}" class="btn btn-secondary">Kembali</a>