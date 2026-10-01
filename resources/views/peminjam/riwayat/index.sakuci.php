@extends('layouts.app')

@section('title', config('app.name') . ' -- Riwayat Peminjaman')

@section('content')
<h1>Riwayat Peminjaman Saya</h1>

@php
    $warna = [
        'pending'               => 'warning',
        'disetujui'             => 'primary',
        'ditolak'               => 'danger',
        'menunggu_pengembalian' => 'info',
        'dikembalikan'          => 'success',
    ];
@endphp

<table class="table table-sm align-middle table-hover table-bordered table-striped">
<tr>
    <th>No</th>
    <th>Kode</th>
    <th>Alat</th>
    <th>Jumlah</th>
    <th>Tgl Pinjam</th>
    <th>Rencana Kembali</th>
    <th>Status</th>
    <th>Kembali (Aktual)</th>
    <th>Hari Telat</th>
    <th>Denda</th>
</tr>
@php $no = 1; @endphp
@forelse ($data as $p)
<tr>
    <td class="text-center">{{ $no++ }}</td>
    <td>{{ $p->kode_peminjaman }}</td>
    <td>{{ $p->alat->nama_alat }}</td>
    <td>{{ $p->jumlah_pinjam }}</td>
    <td>{{ $p->tanggal_pinjam }}</td>
    <td>{{ $p->tanggal_kembali_rencana }}</td>
    <td><span class="badge bg-{{ $warna[$p->status_peminjaman] ?? 'secondary' }}">{{ $p->status_peminjaman }}</span></td>
    <td>{{ $p->pengembalian->tanggal_kembali_aktual ?? '-' }}</td>
    <td>{{ $p->pengembalian->hari_telat ?? '-' }}</td>
    <td>
        @if ($p->pengembalian)
            Rp{{ number_format($p->pengembalian->denda, 0, ',', '.') }}
        @else
            -
        @endif
    </td>
</tr>
@empty
<tr><td colspan="10" class="text-center text-secondary">Belum ada riwayat peminjaman.</td></tr>
@endforelse
</table>
{!! $data->links() !!}
@endsection