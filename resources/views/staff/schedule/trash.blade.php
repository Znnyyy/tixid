@extends('templates.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-end">
        <a href="{{ route('staff.schedules.index') }}" class="btn btn-primary">Kembali</a>
    </div>
    <h3 class="my-3">Data Sampah Tayangan</h3>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Bioskop</th>
            <th>Judul Film</th>
            <th>Aksi</th>
        </tr>
        @foreach ($scheduleTrash as $key => $schedule)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $schedule['cinema']['name'] }}</td>
            <td>{{ $schedule['movie']['title'] }}</td>
            <td>
                <div class="d-flex">
                    <form action="{{ route('staff.schedules.restore', ['id' => $schedule['id']]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success me-2">Pulihkan</button>
                    </form>
                    <form action="{{ route('staff.schedules.delete_permanent', ['id' => $schedule['id']]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger me-2">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </table>
</div>

@endsection