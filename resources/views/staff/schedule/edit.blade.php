@extends('templates.app')

@section('content')
<div class="container my-5">
    <form method="POST" action="{{ route('staff.schedules.update', ['id' => $schedule['id']]) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="cinema_id" class="col-form-label">Bioskop:</label>
            <input type="text" name="cinema_id" id="cinema_id" value="{{ $schedule['cinema']['name'] }}" class="form-control" disabled>
        </div>
        <div class="mb-3">
            <label for="movie_id" class="col-form-label">Film:</label>
            <input type="text" name="movie_id" id="movie_id" value="{{ $schedule['movie']['title'] }}" class="form-control" disabled>
        </div>
        <div class="mb-3">
            <label for="price" class="col-form-label">Harga:</label>
            <input type="number" class="form-control @error('price') is-invalid 
            @enderror" id="price" name="price" value="{{ $schedule['price'] }}">
        </div>
        <div class="mb-3">
            <label for="hour" class="col-form-label">Jam Tayang:</label>
            @foreach ( $schedule['hour'] as $index => $hour )
            <div class="d-flex align-items-center hour-item">
                <input type="time" class="form-control my-2" id="hour" name="hour[]" value="{{ $hour }}">
                @if ($index > 0)
                <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 1.5rem; cursor: pointer;" onclick="this.closest('.hour-item').remove()"></i>
                @endif
            </div>
            @endforeach
            <div id="aditionalInput"></div>
            <!-- menambahkan button untuk inputan baru -->
            <span class="text-primary mt-2" type="button" style="cursor: pointer;" onclick="addInput()">+ Tambahkan jam</span>
            <!-- <button class="btn btn-outline-danger mt-2 justify-content-end" type="button" onclick="resetInput()">reset</button> -->
            @if ($errors->has('hour.*'))
            <br>
            <small class="text-danger">{{ $errors->first('hour.*') }}</small>
            @endif
            <!-- sediakan tempat untuk penambahan input baru dari js, gunakan id untuk panggilan js -->
        </div>
        <button type="submit" class="btn btn-primary">Kirim</button>
        <a href="{{ route('staff.schedules.index') }}" type="button" class="btn btn-secondary">Kembali</a>
    </form>
</div>

@endsection

@push('script')
<script>
    function addInput() {
        let content = `<div class="d-flex align-items-center hour-aditional">
                    <input type="time" class="form-control my-2" id="hour" name="hour[]" >
                    <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 1.5rem; cursor: pointer;" onclick="this.closest('.hour-aditional').remove()"></i>
                    </div>`;
        // ambil tempat input akan disimpan
        document.querySelector('#aditionalInput').innerHTML += content;
        // karena input akan terus bertambah maka gunakan innerHTML +=
    }
</script>
@endpush