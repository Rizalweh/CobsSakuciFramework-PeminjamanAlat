@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <span class="badge rounded-pill badge-brand px-3 py-2 mb-2">Area Admin</span>
            <h1 class="h4 mb-0">Edit User — {{ $user->username }}</h1>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">&larr; Kembali</a>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.update', ['user' => $user->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" class="form-control {{ errors()->has('username') ? 'is-invalid' : '' }}">
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password (kosongkan jika tidak diganti)</label>
                            <input type="password" id="password" name="password" class="form-control {{ errors()->has('password') ? 'is-invalid' : '' }}">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="role">Role</label>
                            <select id="role" name="role" class="form-select {{ errors()->has('role') ? 'is-invalid' : '' }}">
                                @foreach ($roles as $roleOption)
                                    <option value="{{ $roleOption->name }}" @if (old('role', $user->role) === $roleOption->name) selected @endif>{{ $roleOption->name }}</option>
                                @endforeach
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button class="btn btn-brand w-100" type="submit">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection