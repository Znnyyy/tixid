@extends('templates.app')

@section('content')
<div class="w-75 d-block mx-auto my-5 p-4">
    <h5 class="text-center mb-3">Edit Data Film</h5>
    <form method="POST" action="{{ route('admin.movies.update', ['id' => $movies['id']]) }}" enctype="multipart/form-data">
        <!-- enctype="multipart/form-data" => mengambil file yang diupload secara utuh bukan hanya nama filenya -->
        @csrf
        @method('PUT')
        <div class="row mb-4 ">
            <div class="col">
                <label for="title" class="form-label">Judul</label>
                <input type="text" class="form-control @error('title')
                is-invalid
            @enderror" id="title" name="title" value="{{ $movies['title'] }}">
                @error('title')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col">
                <label for="duration" class="form-label">Durasi</label>
                <input type="time" class="form-control @error('duration')
                is-invalid
            @enderror" id="title" name="duration" value="{{ $movies['duration'] }}">
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
            @enderror" id="genre" name="genre" value="{{ $movies['genre'] }}">
                @error('genre')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="col">
                <label for="director" class="form-label">Sutradara</label>
                <input type="text" class="form-control @error('director')
                is-invalid
            @enderror" id="director" name="director" value="{{ $movies['director'] }}">
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
            @enderror" id="age_rating" name="age_rating" value="{{ $movies['age_rating'] }}">
                @error('age_rating')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="col">
                <label for="poster" class="form-label">Poster Film</label>
                <input type="file" class="form-control @error('poster')
                is-invalid
                @enderror" id="poster" name="poster" value="#">
                @error('poster')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <img src="{{ asset('storage/' . $movies['poster']) }}" alt="" style="height: 170px; object-fit: cover;" class="d-block mx-auto mt-3">
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Sinopsis</label>
            <textarea rows="5" class="form-control @error('location')
                is-invalid
            @enderror" id="description" name="description">{{ $movies['description'] }}</textarea>
            @error('description')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <button type="submit" class="btn btn-primary">Edit</button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-primary">Kembali</a>
    </form>
</div>
@endsection