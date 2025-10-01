@extends('templates.app')

@section('content')
<div class="container pt-5">
    <div class="w-75 d-block m-auto">
        <div class="d-flex">
            <div style="width: 150px; height: 200px;">
                <img src="{{ asset('storage/' . $movies->poster) }}" alt="" class="w-100">
            </div>
            <div class="ms-5 mt-4">
                <h5 class="fw-bold">{{ $movies->title }}</h5>
                <table>
                    <tr>
                        <td><b class="text-secondary">Genre</b></td>
                        <td class="px-3"></td>
                        <td>{{ $movies->genre }}</td>
                    </tr>
                    <tr>
                        <td><b class="text-secondary">Durasi</b></td>
                        <td class="px-3"></td>
                        <td>{{ $movies->duration }}</td>
                    </tr>
                    <tr>
                        <td><b class="text-secondary">Sutradara</b></td>
                        <td class="px-3"></td>
                        <td>{{ $movies->director }}</td>
                    </tr>
                    <tr>
                        <td><b class="text-secondary">Rating usia</b></td>
                        <td class="px-3"></td>
                        <td><span class="badge badge-danger">{{ $movies->age_rating }}+</span></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="w-100 mt-5 d-flex justify-content-center">
            <div class="col-6 pe-5 d-flex flex-column align-items-end">
                <div class="d-flex flex-coloumn justify-content-end align-items-end">
                    <h3 class="text-warning me-2">7.3</h3>
                    <i class="fas fa-star text-warning mb-3"></i>
                    <i class="fas fa-star text-warning mb-3"></i>
                    <i class="fas fa-star text-warning mb-3"></i>
                    <i class="fas fa-star text-secondary mb-3"></i>
                    <i class="fas fa-star text-secondary mb-3"></i>
                </div>
                <small>5.515 Vote</small>
            </div>
            <div class="col-6 ps-5 d-flex flex-column align-items-start" style="border-left: 1px solid #ccc;">
                <div class="d-flex align-items-center">
                    <div class="fas fa-heart text-danger me-2 "></div>
                    <b>Masukan watchlist</b>
                </div>
                <small class="mt-3">10.000 Orang</small>
            </div>
        </div>
        <div class="d-flex w-100 bg-light mt-3">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-mdb-dropdown-init data-mdb-ripple-init aria-expanded="false">
                    Bioskop
                </button>

                <ul class="dropdown-menu">
                    <li class="dropdown-item">Bogor</li>
                    <li class="dropdown-item">Jakarta Selatan</li>
                    <li class="dropdown-item">Jakarta Timur</li>
                    <li class="dropdown-item">Depok</li>
                </ul>
            </div>

            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-mdb-dropdown-init data-mdb-ripple-init aria-expanded="false">
                    Sortir
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li class="dropdown-item">Alpabet</li>
                    <li class="dropdown-item">Harga</li>
                </ul>
            </div>
        </div>

        <div class="mb-5">
            <div class="w-100 my-3">
                <i class="fa-solid fa-building"></i><b class="ms-2">Lippo Plaza ekalokasari</b>
                <br>
                <small class="ms-3">Jl.Siliwangi no.123, Sukasari, Bogor timur, Bogor, Jawa Barat 16134. Lippo Plaza ekalokasari Bogor</small>
                <div class="d-flex gap-3 ps-3 my-2">
                    <div class="btn btn-outline-secondary">11.00</div>
                    <div class="btn btn-outline-secondary">12.00</div>
                    <div class="btn btn-outline-secondary">13.00</div>
                    <div class="btn btn-outline-secondary">14.00</div>
                    <div class="btn btn-outline-secondary">15.00</div>
                </div>
            </div>
            <hr>
            <div class="w-100 my-3">
                <i class="fa-solid fa-building"></i><b class="ms-2">Ramayana Tajur</b>
                <br>
                <small class="ms-3">Jl. Raya Tajur, Pakuan, RT04/04, RT.04/RW.04, Muarasari, Kec. Bogor Sel., Kota Bogor, Jawa Barat 16134</small>
                <div class="d-flex gap-3 ps-3 my-2">
                    <div class="btn btn-outline-secondary">11.00</div>
                    <div class="btn btn-outline-secondary">12.00</div>
                    <div class="btn btn-outline-secondary">13.00</div>
                    <div class="btn btn-outline-secondary">14.00</div>
                    <div class="btn btn-outline-secondary">15.00</div>
                </div>
            </div>
            <div class="w-100 p-2 bg-light text-center fixed-bottom">
                <a href="/">
                    <i class="fa-solid fa-ticket m-2"> BELI TIKET</i>
                </a>
            </div>
        </div>
    </div>
</div>


@endsection