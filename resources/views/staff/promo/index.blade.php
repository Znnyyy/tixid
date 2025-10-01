@extends('templates.app')

@section('content')
@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
<div class="container my-5">
    <div class="d-flex justify-content-end">
        <a href="{{ route('staff.promos.export') }}" class="btn btn-info me-2">Export Data</a>
        <a href="{{ route('staff.promos.create') }}" class="btn btn-success">Tambah Data</a>
    </div>
    <h5 class="mb-3">Data Film</h5>
    <table class="table table-bordered">
        <tr>
            <th>No.</th>
            <th>Kode Promos</th>
            <th>Total Potongan</th>
            <th>Aksi</th>
        </tr>
        @foreach ($promos as $index => $item)
        <tr class="align-middle">
            <th>{{ $index+1 }}</th>
            <th>{{ $item['promo_code'] }}</th>
            <th>
                @if ($item['type'] == 'percent')
                <span>{{ $item['discount'] }}%</span>
                @else
                <span>Rp.{{ number_format($item['discount'], 0, ',', '.') }}</span>
                @endif
            </th>
            <th>
                <div class="d-flex">
                    <a href="{{ route('staff.promos.edit', ['id' => $item['id']]) }}" class="btn btn-primary me-2">Edit</a>
                    <form action="{{ route('staff.promos.delete', ['id' => $item['id']]) }}" method="POST">
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