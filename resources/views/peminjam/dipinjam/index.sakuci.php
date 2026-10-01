@extends('layouts.app')

@section('title', config('app.name') . ' -- Sedang Dipinjam')

@section('content')
<h1>Alat yang Sedang Saya Pinjam</h1>


<table class="table table-sm align-middle table-hover table-bordered table-striped">
<tr>
    <th>No</th>
    <th>Kode</th>
    <th>Alat</th>
    <th>Jumlah</th>
    <th>Tgl Pinjam</th>
    <th>Rencana Kembali</th>
    <th>Aksi</th>
</tr>
@php $no = 1; @endphp
@forelse ($dipinjam as $p)
<tr>
    <td class="text-center">{{ $no++ }}</td>
    <td>{{ $p->kode_peminjaman }}</td>
    <td>{{ $p->alat->nama_alat }}</td>
    <td>{{ $p->jumlah_pinjam }}</td>
    <td>{{ $p->tanggal_pinjam }}</td>
    <td>{{ $p->tanggal_kembali_rencana }}</td>
    <td>
        <form action="{{ route('peminjam.kembali', ['id' => $p->id_peminjaman]) }}" method="post" onsubmit="return confirm('Ajukan pengembalian alat ini?')">
            @csrf
            @method('put')
            <button type="submit" class="btn btn-primary btn-sm">Ajukan Pengembalian</button>
        </form>
    </td>
</tr>
@empty
<tr><td colspan="7" class="text-center text-secondary">Tidak ada alat yang sedang dipinjam.</td></tr>
@endforelse
</table>

<h2 class="h5 mt-4">Menunggu Verifikasi Petugas</h2>
<table class="table table-sm align-middle table-hover table-bordered table-striped">
<tr>
    <th>Kode</th>
    <th>Alat</th>
    <th>Jumlah</th>
    <th>Rencana Kembali</th>
</tr>
@forelse ($menunggu as $p)
<tr>
    <td>{{ $p->kode_peminjaman }}</td>
    <td>{{ $p->alat->nama_alat }}</td>
    <td>{{ $p->jumlah_pinjam }}</td>
    <td>{{ $p->tanggal_kembali_rencana }}</td>
</tr>
@empty
<tr><td colspan="4" class="text-center text-secondary">Tidak ada pengajuan pengembalian yang menunggu.</td></tr>
@endforelse
</table>
@endsection