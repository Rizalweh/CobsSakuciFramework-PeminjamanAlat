@extends('layouts.app')

@section('title', config('app.name') . ' -- Daftar Alat')

@section('content')
<h1>Daftar Alat Tersedia</h1>

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
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali (Rencana)</th>
        <th>Jumlah</th>
        <th>Catatan</th>
        <th>Aksi</th>
    </tr>
    @php $no = 1; @endphp
    @foreach ($data as $item)
    <tr>
        <td class="text-center">{{ $no++ }}</td>
        <td>{{ $item->nama_alat }}</td>
        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
        <td>{{ $item->stok }}</td>
        <td><img src="/uploads/foto_alat/{{ $item->foto_alat }}" alt="Foto {{ $item->nama_alat }}" width="80"></td>
        <td>
            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" required
                class="form-control form-control-sm" form="form-ajukan-{{ $item->id_alat }}" placeholder="Tanggal Pinjam">
        </td>
        <td>
            <input type="date" id="tanggal_kembali_rencana" name="tanggal_kembali_rencana" required
                class="form-control form-control-sm" form="form-ajukan-{{ $item->id_alat }}" placeholder="Tanggal Kembali (rencana)">
        </td>
        <td>
            <input type="number" id="jumlah_{{ $item->id_alat }}" name="jumlah_pinjam" min="1" max="{{ $item->stok }}" required
                class="form-control form-control-sm" style="width:70px" form="form-ajukan-{{ $item->id_alat }}" placeholder="0">
        </td>
        <td>

            <input type="text" id="catatan_{{ $item->id_alat }}" name="catatan"
                class="form-control form-control-sm" form="form-ajukan-{{ $item->id_alat }}" placeholder="opsional">
        </td>
        <td>
            <button type="submit" form="form-ajukan-{{ $item->id_alat }}" class="btn btn-primary btn-sm">Ajukan</button>
        </td>
    </tr>
    @endforeach
</table>
{!! $data->links() !!}
@endsection