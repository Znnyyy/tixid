@extends('templates.app')

@section('content')
<div class="w-75 d-block mx-auto my-5 p-4">
    <h5 class="text-center mb-3">Tambah Data Bioskop</h5>
    <form method="POST" action="{{ route('admin.cinemas.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Bioskop</label>
            <input type="text" class="form-control @error('name')
                is-invalid
            @enderror" id="name" name="name">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="location" class="form-label">Lokasi Bioskop</label>
            <textarea type="text" rows="5" class="form-control @error('location')
                is-invalid
            @enderror" id="location" name="location"></textarea>
            @error('location')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">kirim</button>
        <a href="{{ route('admin.cinemas.index') }}" class="btn btn-outline-primary">Kembali</a>
    </form>
</div>
@endsection