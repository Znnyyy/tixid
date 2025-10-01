@extends('templates.app')

@section('content')
@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
<div class="container mt-5">
    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.staffs.export') }}" class="btn btn-info me-2">Export Data</a>
        <a href="{{ route('admin.staffs.create') }}" class="btn btn-success">Tambah Data</a>
    </div>
    <h5 class="mt-3">Data User</h5>
    <table class="table table-bordered">
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
        @foreach ($staffs as $index => $item)
        <tr>
            <th>{{ $index+1 }}</th>
            <!-- name, location dari fillable model Cinema -->
            <th>{{ $item['name'] }}</th>
            <th>{{ $item['email'] }}</th>
            <th>
                @if ($item['role'] == 'admin')
                <span class="badge badge-success">{{ $item['role'] }}</span>
                @elseif ($item['role'] == 'user')
                <span class="badge badge-primary">{{ $item['role'] }}</span>
                @else ($item['role'] == 'staff')
                <span class="badge badge-danger">{{ $item['role'] }}</span>
                @endif
            </th>
            <th>
                <div class="d-flex">
                    <a href="{{ route('admin.staffs.edit', ['id' => $item['id']]) }}" class="btn btn-secondary me-2">Edit</a>
                    <form action="{{ route('admin.staffs.delete', ['id' => $item['id']]) }}" method="POST">
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