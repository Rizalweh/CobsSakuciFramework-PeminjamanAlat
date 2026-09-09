@extends('layouts.app')
@section('content')

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Alat</h3>
        <a href="{{ route('alat.create') }}" class="btn btn-primary">Tambah Alat</a>
    </div>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Alat</th>
                        <th>Stok</th>
                        <th>Kondisi</th>
                        <th>Foto</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no= 1; @endphp
                    @foreach ($data as $alat)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $alat->kode_alat }}</td>
                        <td>{{ $alat->nama_alat }}</td>
                        <td>{{ $alat->stok}}</td>
                        <td>{{ $alat->kondisi}}</td>
                        <td>{{ $alat->foto_alat }}</td>
                        <td>
                            <a href="{{ route('alat.edit', ['id' => $alat->id_alat]) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('alat.destroy', ['id' => $alat->id_alat]) }}"
                                method="POST" class="d-inline" onsubmit="return confirm('Hapus data alat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data alat.</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $data->links() !!}
        </div>
    </div>
</div>
@endsection