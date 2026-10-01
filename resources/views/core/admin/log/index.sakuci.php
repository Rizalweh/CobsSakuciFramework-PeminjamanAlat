@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <span class="badge rounded-pill badge-brand px-3 py-2 mb-2">Area Admin</span>
            <h1 class="h4 mb-0">Log Aktivitas</h1>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">&larr; Kembali</a>
    </div>
    <div class="alert alert-info d-flex align-items-start gap-2 small" role="alert">
        <i class="bi bi-info-circle-fill mt-1"></i>
        <div>Log aktivitas akan dihapus apabila melebihi 90 hari</div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if ($jumlahLama > 0)
            <div class="alert alert-info d-flex align-items-center justify-content-between">
                <span> Ada {{ $jumlahLama }} log yang lebih lama dari 90 hari </span>
                <form action="{{ route('admin.log.hapusLama') }}" method="post" onsubmit="return confirm('ingin dibersihkan?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('yakin ingin dibersihkan')">Bersihkan</button>
                </form>
            </div>
                    @endif
            <table class="table table-sm align-middle mb-0">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $log)
                    <tr>
                        <td>{{ $log->waktu }}</td>
                        <td>{{ $log->user->profil->nama_lengkap ?? $log->user->username ?? '(user dihapus)' }}</td>
                        <td>{{ $log->aktivitas }}</td>
                        <td>
                    <form action="{{ route('admin.log.destroy', ['id' => $log->id_log]) }}" method="post">
                        @csrf
                        @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('yakin ingin Hapus aktivitas ini?')">Hapus</button>
                    </form>
                        </td>
                    </form>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-secondary">Belum ada aktivitas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {!! $data->links() !!}
@endsection