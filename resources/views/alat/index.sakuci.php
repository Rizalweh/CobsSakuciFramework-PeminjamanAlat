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
                        <th>Merk</th>
                        <th>Stok</th>
                        <th>Kondisi</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $a)
                    <tr>
                        <td>{{ $loop->iteration + $alat->firstItem() - 1 }}</td>
                        <td>{{ $data->kode_alat }}</td>
                        <td>{{ $data->nama_alat }}</td>
                        <td>{{ $data->merk ?? '-' }}</td>
                        <td>{{ $data->stok }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $a->kondisi)) }}</td>
                        <td>
                            <a href="{{ route('alat.edit', $alat) }}" class="btn btnwarning btn-sm">Edit</a>
                            <form action="{{ route('alat.destroy', $alat) }}"
                                method="POST" class="d-inline" onsubmit="return confirm('Hapus data alat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btnsm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data alat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $data->links() }}
        </div>
    </div>
</div>
@endsection