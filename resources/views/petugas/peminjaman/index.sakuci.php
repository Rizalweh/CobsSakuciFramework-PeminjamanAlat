@extends('layouts.app')

@section('title', config('app.name') . ' -- Pengajuan Peminjaman')

@section('content')
<h1>Pengajuan Peminjaman (Pending)</h1>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-sm align-middle table-hover table-bordered table-striped">
<tr>
    <th>No</th>
    <th>Kode</th>
    <th>Peminjam</th>
    <th>Nama Alat</th>
    <th>Kategori</th>
    <th>Stok</th>
    <th>foto</th>
    <th>kondisi</th>
    <th>Jumlah</th>
    <th>Tanggal Pinjam</th>
    <th>Tanggal Kembali</th>
    <th>Keperluan</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
@php $no = 1; @endphp
@foreach ($data as $p)
<tr>
    <td class="text-center">{{ $no++ }}</td>
    <td>{{ $p->kode_peminjaman }}</td>
    <td>{{ $p->peminjam->username }}</td>
    <td>{{ $p->alat->nama_alat }}</td>
    <td></td>{{ $p->alat->kategori->nama_kategori ?? '-' }}</td>
    <td>{{ $p->alat->stok }}</td>
    <td><img src="/uploads/foto_alat/{{ $p->alat->foto_alat }}" alt="Foto {{ $p->alat->nama_alat }}" width="80"></td>
    <td>{{ $p->alat->kondisi }}</td>
    <td>{{ $p->jumlah_pinjam }}</td>
    <td>{{ $p->tanggal_pinjam }}</td>
    <td>{{ $p->tanggal_kembali_rencana }}</td>
    <td>{{ $p->catatan ?? '-' }}</td>
    <td><span class="badge bg-warning">{{ $p->status_peminjaman }}</span></td>
    <td>
        <form action="{{ route('petugas.peminjaman.setujui', ['id' => $p->id_peminjaman]) }}" method="post" class="d-inline">
            @csrf
            @method('put')
            <button type="submit" class="btn btn-success btn-sm">Setujui</button>
        </form>
        <form action="{{ route('petugas.peminjaman.tolak', ['id' => $p->id_peminjaman]) }}" method="post" class="d-inline" onsubmit="return confirm('Tolak pengajuan ini?')">
            @csrf
            @method('put')
            <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
        </form>
    </td>
</tr>
@endforeach
</table>
{!! $data->links() !!}
@endsection