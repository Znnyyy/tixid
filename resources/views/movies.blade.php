@extends('templates.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-end">
        <a href="{{ route('home') }}" class="btn btn-warning rounded-pill mb-4">Kembali</a>
    </div>
    <h5>Seluluh Film Sedang Tayang</h5>
    <form class="row my-4" method="GET" action="">
        @csrf
        <div class="col-11">
            <input type="text" name="search_movie" placeholder="Cari judul film.." class="form-control">
        </div>
        <div class="col-1">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <div class="container d-flex flex-wrap gap-3 mt-5">
        @foreach ($movies as $key => $item)

        <div class="card" style="width: 18rem;">
            <img src="{{ asset('storage/' . $item['poster']) }}" class="card-img-top" alt="{{ $item['title'] }}"
                style="height: 420px; object-fit: cover;" />
            <div class="card-body bg-primary text-warning" style="padding: 0 !important; text-align: center;">
                <p class="card-text">
                    <a href="{{ route('schedules.detail', $item->id) }}">BELI TIKET</a>
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection