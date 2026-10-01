@extends('layouts.app')

@section('title', 'Daftar')

@section('content')

    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h4 mb-1">Daftar Akun</h1>
                    <p class="text-secondary small mb-4">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>.</p>

                    <form method="POST" action="{{ route('register.attempt') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-control {{ errors()->has('username') ? 'is-invalid' : '' }}" autofocus>
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control {{ errors()->has('password') ? 'is-invalid' : '' }}">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        </div>

                        @if (count($roles) > 1)
                            <div class="mb-3">
                                <label class="form-label" for="role">Daftar sebagai</label>
                                <select id="role" name="role" class="form-select {{ errors()->has('role') ? 'is-invalid' : '' }}">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        @else
                            <input type="hidden" name="role" value="{{ $roles[0]->name }}">
                        @endif

                        <p class="text-secondary small">Data di bawah ini diisi jika mendaftar sebagai peminjam.</p>

<div class="mb-3">
    <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label" for="nik">NIS</label>
    <input type="text" id="nik" name="nik" value="{{ old('nis') }}" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label" for="no_hp">No. HP</label>
    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label" for="alamat">Alamat</label>
    <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" class="form-control">
</div>
                        <button class="btn btn-brand w-100" type="submit">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
