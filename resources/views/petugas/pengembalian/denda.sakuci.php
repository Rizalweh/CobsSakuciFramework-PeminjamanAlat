@extends('layouts.app')
@section('title', config('app.name') . ' -- Denda Belum Lunas')
@section('content')
<h1>Denda Belum Lunas</h1>
<table class="table table-sm align-middle table-hover table-bordered table-striped">
<tr><th>No</th><th>Kode</th><th>Peminjam</th><th>Alat</th><th>Kondisi</th>
    <th>Denda Telat</th><th>Denda Kerusakan</th><th>Total</th><th>Aksi</th></tr>
@php $no = 1; @endphp
@forelse ($data as $d)
<tr>
    <td>{{ $no++ }}</td>
    <td>{{ $d->peminjaman->kode_peminjaman }}</td>
    <td>{{ $d->peminjaman->peminjam->username }}</td>
    <td>{{ $d->peminjaman->alat->nama_alat }}</td>
    <td>{{ $d->kondisi_alat }}</td>
    <td>Rp{{ number_format($d->denda_telat, 0, ',', '.') }}</td>
    <td>Rp{{ number_format($d->denda_kerusakan, 0, ',', '.') }}</td>
    <td><strong>Rp{{ number_format($d->denda, 0, ',', '.') }}</strong></td>
    <td>
        <form action="{{ route('petugas.denda.bayar', ['id' => $d->id_pengembalian]) }}" method="post"
              onsubmit="return confirm('Konfirmasi: uang denda sudah diterima?')">
            @csrf
            @method('put')
            <button class="btn btn-success btn-sm" type="submit">Tandai Lunas</button>
        </form>
    </td>
</tr>
@empty
<tr><td colspan="9" class="text-center text-secondary">Tidak ada denda tertunggak.</td></tr>
@endforelse
</table>
{!! $data->links() !!}
@endsection