@extends('layouts.app')

@section('title', 'Data Peminjam')

@section('content')
<h1>Data Peminjam</h1>

<table class="table table-sm align-middle table-hover table-bordered table-striped">
<tr>
    <th>No</th>
    <th>Username</th>
    <th>Nama Lengkap</th>
    <th>NIS</th>
    <th>No. HP</th>
    <th>Alamat</th>
    <th>Aksi</th>
</tr>
@php $no = 1; @endphp
@foreach ($data as $u)
<tr>
    <td class="text-center">{{ $no++ }}</td>
    <td>{{ $u->username }}</td>
    <td>{{ $u->profil->nama_lengkap ?? '-' }}</td>
    <td>{{ $u->profil->nis ?? '-' }}</td>
    <td>{{ $u->profil->no_hp ?? '-' }}</td>
    <td>{{ $u->profil->alamat ?? '-' }}</td>
    <td>
        <a href="{{ route('admin.peminjam.edit', ['user' => $u->id]) }}" class="btn btn-primary btn-sm">Edit</a>
        <form action="{{ route('admin.peminjam.destroy', ['user' => $u->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data?')">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
</table>

<div class="mt-3 mb-3 d-flex justify-content-end">
    <a href="{{ route('admin.peminjam.create') }}" class="btn btn-success">Tambah Peminjam</a>
</div>
{!! $data->links() !!}
@endsection