@extends('templates.app')

@section('content')
@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
<div class="container mt-5">
    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.cinemas.export') }}" class="btn btn-info me-2">Export Data</a>
        <a href="{{ route('admin.cinemas.create') }}" class="btn btn-success">Tambah Data</a>
    </div>
    <h5 class="mt-3">Data Bioskop</h5>
    <table class="table table-bordered">
        <tr>
            <th>No.</th>
            <th>Nama Bioskop</th>
            <th>Lokasi Bioskop</th>
            <th>Aksi</th>
        </tr>
        @foreach ($cinemas as $index => $item)
        <tr>
            <th>{{ $index+1 }}</th>
            <!-- name, location dari fillable model Cinema -->
            <th>{{ $item['name'] }}</th>
            <th>{{ $item['location'] }}</th>
            <th>
                <div class="d-flex">
                    <a href="{{ route('admin.cinemas.edit', ['id' => $item['id']]) }}" class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</a>
                    <form action="{{ route('admin.cinemas.delete', ['id' => $item['id']]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger me-2">Hapus</button>
                    </form>
                </div>

        </tr>

        @endforeach
    </table>
</div>

@endsection