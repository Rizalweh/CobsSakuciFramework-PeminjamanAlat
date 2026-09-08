@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Tambah Alat</h3>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('alat.store') }}" method="POST">
                @csrf
                @include('alat.form')
            </form>
        </div>
    </div>
</div>
@endsection