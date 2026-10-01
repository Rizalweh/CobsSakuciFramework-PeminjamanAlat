@extends('layouts.app')

@section('title', config('app.name') . ' -- Proses Pengembalian')

@section('content')
<h1>Proses Pengembalian — {{ $peminjaman->kode_peminjaman }}</h1>

<div class="mb-3">
    <p><strong>Peminjam:</strong> {{ $peminjaman->peminjam->username }}</p>
    <p><strong>Alat:</strong> {{ $peminjaman->alat->nama_alat }} ({{ $peminjaman->jumlah_pinjam }} unit)</p>
    <p><strong>Rencana Kembali:</strong> {{ $peminjaman->tanggal_kembali_rencana }}</p>
</div>

<form action="{{ route('petugas.pengembalian.store', ['id' => $peminjaman->id_peminjaman]) }}" method="post">
    @csrf

    <div class="mb-3">
        <label for="tanggal_kembali_aktual" class="form-label">Tanggal Kembali (Aktual)</label>
        <input type="date" id="tanggal_kembali_aktual" name="tanggal_kembali_aktual" required class="form-control">
    </div>

    <div class="mb-3">
        <label for="kondisi_alat" class="form-label">Kondisi Alat</label>
        <select id="kondisi_alat" name="kondisi_alat" required class="form-select">
            <option value="baik">Baik</option>
            <option value="rusak_ringan">Rusak Ringan</option>
            <option value="rusak_berat">Rusak Berat</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="catatan" class="form-label">Catatan (opsional)</label>
        <input type="text" id="catatan" name="catatan" class="form-control" placeholder="Kondisi fisik alat, dst">
    </div>

    <button type="submit" class="btn btn-success">Simpan Pengembalian</button>
</form>
@endsection