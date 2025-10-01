<!-- import -->
@extends('templates.app')

@section('content')
@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }} <b>Selamat ''Datang, {{ Auth::user()->name }}</b></div>
@endif
@if (Session::get('logout'))
<div class="alert alert-warning">{{ Session::get('logout') }}</div>
@endif
<div class="dropdown">
    <button
        class="btn btn-light w-100 text-start dropdown-toggle"
        type="button"
        id="dropdownMenuButton"
        data-mdb-dropdown-init
        data-mdb-ripple-init
        aria-expanded="false">
        <i class="fa-solid fa-map-location"></i> Pilih Lokasi
    </button>

    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
        <button class="dropdown-item" href="#" disabled>Pilih Lokasi</button>
        <li><a class="dropdown-item" href="#">Bogor</a></li>
        <li><a class="dropdown-item" href="#">Jakarta Timur</a></li>
        <li><a class="dropdown-item" href="#">Jakarta Barat</a></li>
        <li><a class="dropdown-item" href="#">Depok</a></li>
    </ul>
</div>

<!-- Carousel wrapper -->
<div id="carouselBasicExample" class="carousel slide carousel-fade" data-mdb-ride="carousel" data-mdb-carousel-init>
    <!-- Indicators -->
    <div class="carousel-indicators">
        <button
            type="button"
            data-mdb-target="#carouselBasicExample"
            data-mdb-slide-to="0"
            class="active"
            aria-current="true"
            aria-label="Slide 1"></button>
        <button
            type="button"
            data-mdb-target="#carouselBasicExample"
            data-mdb-slide-to="1"
            aria-label="Slide 2"></button>
        <button
            type="button"
            data-mdb-target="#carouselBasicExample"
            data-mdb-slide-to="2"
            aria-label="Slide 3"></button>
    </div>

    <!-- Inner -->
    <div class="carousel-inner">
        <!-- Single item -->
        <div class="carousel-item active">
            <img style="height: 600px;" src="https://i.redd.it/3ncbg0g4tz2f1.jpeg" class="d-block w-100" alt="Sunset Over the City" />
            <div class="carousel-caption d-none d-md-block">
                <h5>Superman</h5>
                <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
            </div>
        </div>

        <!-- Single item -->
        <div class="carousel-item">
            <img style="height: 600px;" src="https://preview.redd.it/new-banner-for-the-fantastic-four-first-steps-v0-d7bt1i5elsaf1.jpeg?auto=webp&s=3d2ba94c9aa018ed61fca336f8bd23761d137762" class="d-block w-100" alt="Canyon at Nigh" />
            <div class="carousel-caption d-none d-md-block">
                <h5>Avatar</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </div>

        <!-- Single item -->
        <div class="carousel-item">
            <img style="height: 600px;" src="https://cdn.europosters.eu/image/hp/66923.jpg" class="d-block w-100" alt="Cliff Above a Stormy Sea" />
            <div class="carousel-caption d-none d-md-block">
                <h5>Batman</h5>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
            </div>
        </div>
    </div>
    <!-- Inner -->

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- Carousel wrapper -->

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center">
        <!-- kiri -->
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-clapperboard"></i>
            <h5 class="ms-2 mt-2">Sedang Tayang</h5>
        </div>

        <!-- kanan -->
        <div>
            <a href="{{ route('home.movies.all') }}" class="btn btn-warning rounded-pill">Semua</a>
        </div>
    </div>
</div>

<div class="container d-flex gap-2">
    <button class="btn btn-outline-primary rounded-pill">Semua Film</button>
    <button class="btn btn-outline-secondary rounded-pill">XXI</button>
    <button class="btn btn-outline-secondary rounded-pill">Cinepolis</button>
    <button class="btn btn-outline-secondary rounded-pill">IMAX</button>
</div>

<div class="container d-flex gap-3 mt-4 justify-content-center">
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

<footer class="bg-body-tertiary text-center text-lg-start mt-5">
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2020 Copyright:
        <a class="text-body" href="/">TIXID.com</a>
    </div>
    <!-- Copyright -->
</footer>
@endsection
