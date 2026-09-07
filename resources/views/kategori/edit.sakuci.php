@extends('layouts.app')

@section('title', config('app.name') . ' -- Kerangka PHP Ringan')

@section('content')
<form action="{{ route('kategori.update', ['id' => $data->id_kategori]) }}" method="post" class="d-flex flex-column form-horizontal">
    @csrf
    @method('PUT')

    <label>Nama Kategori</label>
    <input type="text" name="nama_kategori" value="{{ $data->nama_kategori }}" class="form-control" required>

    <label>Kode Kategori</label>    
    <input type="text" name="kode_kategori" value="{{ $data->kode_kategori }}" class="form-control" required>

    <label>Keterangan</label>    
    <input type="text" name="keterangan" value="{{ $data->keterangan }}" class="form-control mb-3" required>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection