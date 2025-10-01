@extends('templates.app')

@section('content')
<div class="w-75 d-block mx-auto my-5 p-4">
    <h5 class="text-center mb-3">Edit Promo Bioskop</h5>
    <form method="POST" action="{{ route('staff.promos.update', ['id' => $promos['id']]) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="promo_code" class="form-label">Kode Promo</label>
            <input type="text" class="form-control @error('promo_code')
                is-invalid
            @enderror" id="promo_code" name="promo_code" value="{{ $promos['promo_code'] }}">
            @error('promo_code')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Tipe Promo</label>
            <select class="form-select @error('type')
                is-invalid
            @enderror" id="type" name="type">
                <option value="percent" {{ $promos['type'] == 'percent' ? 'selected' : '' }}>%</option>
                <option value="rupiah" {{ $promos['type'] == 'rupiah' ? 'selected' : '' }}>Rupiah</option>
            </select>
            @error('type')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="discount" class="form-label">Jumlah Potongan</label>
            <input type="number" class="form-control @error('discount')
                is-invalid
            @enderror" id="discount" name="discount" value="{{ $promos['discount'] }}">
            @error('discount')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <button type="submit" class="btn btn-primary">Edit</button>
        <a href="{{ route('staff.promos.index') }}" class="btn btn-outline-primary">Kembali</a>
    </form>
</div>
@endsection