@extends('layouts.app')

@section('title', config('app.name') . ' -- Daftar Alat')

@section('content')
<h1>Daftar Alat Tersedia</h1>
<table>
@foreach ($data as $item)
<form id="form-ajukan-{{ $item->id_alat }}" action="{{ route('peminjam.peminjaman.ajukan') }}" method="post" class="d-none">
    @csrf
    <input type="hidden" name="id_alat" value="{{ $item->id_alat }}">
</form>
@endforeach

<table class="table table-sm align-middle table-hover table-bordered table-striped">
<tr>
    <th>No</th>
    <th>Nama Alat</th>
    <th>Kategori</th>
    <th>Stok</th>
    <th>Foto</th>
    <th>Kondisi</th>
    <th>Tanggal Pinjam</th>
    <th>Tanggal Kembali (Rencana)</th>
    <th>Ajukan Pinjam</th>
</tr>
@php $no = 1; @endphp
@foreach ($data as $item)
<tr>
    <td class="text-center">{{ $no++ }}</td>
    <td>{{ $item->nama_alat }}</td>
    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
    <td>{{ $item->stok }}</td>
    <td>
        <img src="/uploads/foto_alat/{{ $item->foto_alat }}" alt="Foto {{ $item->nama_alat }}" width="80">
    </td>
    <td>{{ $item->kondisi }}</td>
    <td>
        <label for="tgl_pinjam_{{ $item->id_alat }}" class="form-label small mb-1">Tgl Pinjam</label>
        <input type="date" id="tgl_pinjam_{{ $item->id_alat }}" name="tanggal_pinjam" required
               class="form-control form-control-sm" form="form-ajukan-{{ $item->id_alat }}">
    </td>
    <td>
        <label for="tgl_kembali_{{ $item->id_alat }}" class="form-label small mb-1">Tgl Kembali</label>
        <input type="date" id="tgl_kembali_{{ $item->id_alat }}" name="tanggal_kembali_rencana" required
               class="form-control form-control-sm" form="form-ajukan-{{ $item->id_alat }}">
    </td>
    <td>
        <label for="jumlah_{{ $item->id_alat }}" class="form-label small mb-1">Jumlah</label>
        <input type="number" id="jumlah_{{ $item->id_alat }}" name="jumlah_pinjam" min="1" max="{{ $item->stok }}" required
               class="form-control form-control-sm mb-1" style="width:80px"
               form="form-ajukan-{{ $item->id_alat }}">

        <label for="catatan_{{ $item->id_alat }}" class="form-label small mb-1">Keperluan</label>
        <input type="text" id="catatan_{{ $item->id_alat }}" name="catatan"
               class="form-control form-control-sm mb-2"
               form="form-ajukan-{{ $item->id_alat }}">

        <button type="submit" form="form-ajukan-{{ $item->id_alat }}" class="btn btn-primary btn-sm">Ajukan</button>
    </td>
</tr>
@endforeach
</table>
{!! $data->links() !!}
@endsection