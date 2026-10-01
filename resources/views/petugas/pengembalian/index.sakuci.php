@extends('layouts.app')

@section('title', config('app.name') . ' -- Pengembalian Alat')

@section('content')
<h1>Daftar Alat Dipinjam (Belum Dikembalikan)</h1>

<table class="table table-sm align-middle table-hover table-bordered table-striped">
<tr>
    <th>No</th>
    <th>Kode</th>
    <th>Peminjam</th>
    <th>Alat</th>
    <th>Jumlah</th>
    <th>Rencana Kembali</th>
    <th>Aksi</th>
</tr>
@php $no = 1; @endphp
@foreach ($data as $p)
<tr>
    <td class="text-center">{{ $no++ }}</td>
    <td>{{ $p->kode_peminjaman }}</td>
    <td>{{ $p->peminjam->username }}</td>
    <td>{{ $p->alat->nama_alat }}</td>
    <td>{{ $p->jumlah_pinjam }}</td>
    <td>{{ $p->tanggal_kembali_rencana }}</td>
    <td>
        <a href="{{ route('petugas.pengembalian.create', ['id' => $p->id_peminjaman]) }}" class="btn btn-primary btn-sm">Proses Pengembalian</a>
    </td>
</tr>
@endforeach
</table>
{!! $data->links() !!}
@endsection