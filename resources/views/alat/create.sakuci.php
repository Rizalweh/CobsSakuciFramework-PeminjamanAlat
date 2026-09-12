@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Tambah Alat</h3>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('alat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label>Nama Alat</label>
                <input type="text" name="nama_alat" id="nama_alat" class="form-control" value="{{ old('nama_alat') }}" required>
                <label>Kode Alat</label>
                <input type="text" name="kode_alat" id="kode_alat" class="form-control" value="{{ old('kode_alat') }}" required>
                <label>Stok</label>
                <input type="number" name="stok" id="stok" class="form-control" value="{{ old('stok') }}" required>
                <label>Kondisi</label>
                <select name="kondisi" id="kondisi" class="form-control" required>
                    <option value="">Pilih kondisi alat</option>
                    <option value="Baik" {{ old('kondisi') === 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ old('kondisi') === 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ old('kondisi') === 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
                <label>Foto Alat</label>
                <input type="file" name="foto_alat" id="foto_alat" class="form-control">
                <button type="submit" class="btn btn-primary mt-2">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection