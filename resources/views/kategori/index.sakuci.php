@extends('layouts.app')

@section('title', config('app.name') . ' -- Kerangka PHP Ringan')

@section('content')
<h1>Daftar Kategori</h1>
<table class = "table table-sm align-middle table-hover table-bordered table-striped"> 
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
    <td class="text-center"> {{ $no++ }} </td>
    <td> {{ $kategoris->nama_kategori }} </td>
    <td> {{ $kategoris->kode_kategori }} </td>
    <td> {{ $kategoris->keterangan }} </td>
    <td>
         <a href="{{ route('kategori.edit', ['id' => $kategoris->id_kategori]) }}" class="btn btn-primary btn-sm">Edit</a>
         <form action="{{ route('kategori.destroy', ['id' => $kategoris->id_kategori]) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data?')" >
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
    </td>
</tr>
@endforeach
</table>
<div class="mt-5 mb-3 me-2 d-flex justify-content-end">
<a href="{{ route('kategori.create') }}" class="btn btn-success">Tambah Kategori</a>
</div>
{!! $data->links() !!}
@endsection