@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Edit Alat</h3>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('alat.update', $alat) }}" method="POST">
                @csrf
                @method('PUT')
                @include('alat.forms')
            </form>
        </div>
    </div>
</div>
@endsection