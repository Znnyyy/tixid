@extends('templates.app')

@section('content')
<div class="w-75 d-block mx-auto my-5 p-4">
    <h5 class="text-center mb-3">Edit Data Bioskop</h5>
    <form method="POST" action="{{ route('admin.cinemas.update', ['id' => $cinema['id']]) }}">
        @csrf
        <!-- timpa method html post menjadi put -->
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Bioskop</label>
            <input type="text" class="form-control @error('name')
                is-invalid
            @enderror" id="name" name="name" value="{{ $cinema['name'] }}">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="location" class="form-label">Lokasi Bioskop</label>
            {{-- $cinema mengambil data cinema yang akan di edit dari conttroller edit bagian compact
                dimunculkan di input dengan value="" dan textarea di tengah2 penutup </textarea>  --}}
            <textarea type="text" rows="5" class="form-control @error('location')
                is-invalid
            @enderror" id="location" name="location">{{ $cinema['location'] }}</textarea>
            @error('location')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Edit</button>
        <a href="{{ route('admin.cinemas.index') }}" class="btn btn-outline-primary">Kembali</a>
    </form>
</div>
@endsection