@extends('templates.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.cinemas.index') }}" class="btn btn-success">Kembali</a>
    </div>
    <h5 class="mt-3">Data Bioskop</h5>
    @if (Session::get('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No.</th>
            <th>Nama Bioskop</th>
            <th>Lokasi Bioskop</th>
            <th>Aksi</th>
        </tr>
        @foreach ($cinemaTrash as $index => $item)
        <tr>
            <th>{{ $index+1 }}</th>
            <!-- name, location dari fillable model Cinema -->
            <th>{{ $item['name'] }}</th>
            <th>{{ $item['location'] }}</th>
            <th>
                <div class="d-flex">
                    <form action="{{ route('admin.cinemas.restore', ['id' => $item['id']]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success me-2">Pulihkan</button>
                    </form>
                    <form action="{{ route('admin.cinemas.delete', ['id' => $item['id']]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger me-2">Hapus</button>
                    </form>
                </div>
            </th>
        </tr>

        @endforeach
    </table>
</div>

@endsection 