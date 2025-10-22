@extends('templates.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.movies.index') }}" class="btn btn-success">Kembali</a>
    </div>
    <h5 class="mb-3">Data Film</h5>
    @if (Session::get('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No.</th>
            <th>Poster</th>
            <th>Judul Film</th>
            <th>Aksi</th>
        </tr>
        @foreach ($movieTrash as $index => $item)
        <tr class="align-middle">
            <th>{{ $index+1 }}</th>
            <th><img class="poster" src="{{ asset('storage/' . $item['poster']) }}" alt="" class="w-100"></th>
            <th>{{ $item['title'] }}</th>
            <th>
                <div class="d-flex">
                    <form action="{{ route('admin.movies.restore', ['id' => $item['id']]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success me-2">Pulihkan</button>
                    </form>
                    <form action="{{ route('admin.movies.delete_permanent', ['id' => $item['id']]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger me-2">Hapus</button>
                    </form>
                </div>
            </th>
        </tr>
        @endforeach
    </table>
@endsection