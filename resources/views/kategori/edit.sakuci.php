@extends('layouts.app')

@section('title', config('app.name') . ' -- Kerangka PHP Ringan')

@section('content')
<form action="{{ route('admin.kategori.update', ['id' => $data->id_kategori]) }}" method="POST" class="d-flex flex-column gap-2">
    @csrf
    @method('PUT')
    
    <label>Nama Kategori</label>
    <input type="text" name="name" value="{{ $data->nama_kategori }}">
    
    <label>Kode Kategori</label>
    <input type="text" name="kode" value="{{ $data->kode_kategori }}">
    
    <label>Keterangan</label>
    <input type="text" name="keterangan" value="{{ $data->keterangan }}">
    
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>
@endsection