@extends('templates.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-end">
        <a href="{{ route('home') }}" class="btn btn-warning rounded-pill mb-4">Kembali</a>
    </div>
    <h5>Seluluh Film Sedang Tayang</h5>

    <div class="container d-flex flex-wrap gap-3 mt-4">
        @foreach ($movies as $key => $item)

        <div class="card" style="width: 18rem;">
            <img src="{{ asset('storage/' . $item['poster']) }}" class="card-img-top" alt="{{ $item['title'] }}"
                style="height: 420px; object-fit: cover;" />
            <div class="card-body bg-primary text-warning" style="padding: 0 !important; text-align: center;">
                <p class="card-text">
                    <a href="{{ route('movies.show', $item->id) }}">BELI TIKET</a>
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection