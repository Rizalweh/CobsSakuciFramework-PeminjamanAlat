@extends('layouts.app')

@section('title', 'Tambah Peminjam')

@section('content')
<h1>Tambah Peminjam</h1>
<form action="{{ route('admin.peminjam.store') }}" method="post" class="d-flex flex-column">
    @csrf

    <label>Username</label>
    <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>

    <label>Password</label>
    <input type="password" name="password" class="form-control" required>

    <label>Nama Lengkap</label>
    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>

    <label>NIS</label>
    <input type="text" name="nis" class="form-control" value="{{ old('nis') }}" required>

    <label>No. HP</label>
    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>

    <label>Alamat</label>
    <input type="text" name="alamat" class="form-control mb-3" value="{{ old('alamat') }}">

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection