@extends('templates.app')

@section('content')
<div class="w-75 d-block mx-auto my-5 p-4">
    <h5 class="text-center mb-3">Tambah Data Film</h5>
    <form method="POST" action="{{ route('admin.movies.store')}}" enctype="multipart/form-data">
        <!-- enctype="multipart/form-data" => mengambil file yang diupload secara utuh bukan hanya nama filenya -->
        @csrf
        <div class="row mb-4 ">
            <div class="col">
                <label for="title" class="form-label">Judul</label>
                <input type="text" class="form-control @error('title')
                is-invalid
            @enderror" id="title" name="title">
                @error('title')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col">
                <label for="duration" class="form-label">Durasi</label>
                <input type="time" class="form-control @error('duration')
                is-invalid
            @enderror" id="title" name="duration">
                @error('duration')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control @error('genre')
                is-invalid
            @enderror" id="genre" name="genre">
                @error('genre')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="col">
                <label for="director" class="form-label">Sutradara</label>
                <input type="text" class="form-control @error('director')
                is-invalid
            @enderror" id="director" name="director">
                @error('director')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="age_rating" class="form-label">Usia minimal</label>
                <input type="number" class="form-control @error('age_rating')
                is-invalid
            @enderror" id="age_rating" name="age_rating">
                @error('age_rating')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="col">
                <label for="poster" class="form-label">Poster Film</label>
                <input type="file" class="form-control @error('poster')
                is-invalid
            @enderror" id="poster" name="poster">
                @error('poster')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Sinopsis</label>
            <textarea rows="5" class="form-control @error('location')
                is-invalid
            @enderror" id="description" name="description"></textarea>
            @error('description')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <button type="submit" class="btn btn-primary">Kirim</button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-primary">Kembali</a>
    </form>
</div>
@endsection