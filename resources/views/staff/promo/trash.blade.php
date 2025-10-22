@extends('templates.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-end">
        <a href="{{ route('staff.promos.index') }}" class="btn btn-success">Kembali</a>
    </div>
    <h5 class="mb-3">Data Promo</h5>
    @if (Session::get('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No.</th>
            <th>Kode Promos</th>
            <th>Total Potongan</th>
            <th>Aksi</th>
        </tr>
        @foreach ($promoTrash as $index => $item)
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
                    <form action="{{ route('staff.promos.restore', ['id' => $item['id']]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success me-2">Pulihkan</button>
                    </form>
                    <form action="{{ route('staff.promos.delete_permanent', ['id' => $item['id']]) }}" method="POST">
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