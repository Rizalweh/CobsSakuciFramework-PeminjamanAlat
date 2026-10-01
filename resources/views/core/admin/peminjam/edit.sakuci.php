@extends('layouts.app')

@section('title', 'Edit Peminjam')

@section('content')
<h1>Edit Peminjam</h1>
<form action="{{ route('admin.peminjam.update', ['user' => $user->id]) }}" method="post" class="d-flex flex-column">
    @csrf
    @method('PUT')

    <label>Username</label>
    <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>

    <label>Password (kosongkan jika tidak diganti)</label>
    <input type="password" name="password" class="form-control">

    <label>Nama Lengkap</label>
    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->profil?->nama_lengkap) }}" required>

    <label>NIS</label>
    <input type="text" name="nis" class="form-control" value="{{ old('nis', $user->profil?->nis) }}" required>

    <label>No. HP</label>
    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $user->profil?->no_hp) }}" required>

    <label>Alamat</label>
    <input type="text" name="alamat" class="form-control mb-3" value="{{ old('alamat', $user->profil?->alamat) }}">

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection