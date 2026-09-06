@extends('layouts.app')

@section('title', config('app.name') . ' -- Kerangka PHP Ringan')

@section('content')
<table class = "table table-sm align-middle"> 
<tr>
    <th>No</th>
    <th>nama kategori</th>
    <th>kode kategori</th>
    <th>Keterangan</th>
    <th>Aksi</th>
</tr>
@php $no = 1; @endphp
@foreach ($data as $kategoris)
<tr>
    <td> {{ $no++ }} </td>
    <td> {{ $kategoris->nama_kategori }} </td>
    <td> {{ $kategoris->kode_kategori }} </td>
    <td> {{ $kategoris->keterangan }} </td>
    <td>
         <a href="" class="btn btn-primary btn-sm">Edit</a>
         <a href="" class="btn btn-danger btn-sm">Hapus</a>
    </td>
</tr>
@endforeach
</table>
{!! $data->links() !!}
@endsection