@extends('templates.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-end">
        <a href="{{ route('staff.schedules.export') }}" class="btn btn-info me-2">Export Data</a>
        <a href="{{ route('staff.schedules.trash') }}" class="btn btn-secondary me-2">Recycle Bin</a>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAdd">Tambah Data</button>
    </div>
    <h3 class="my-3">Data Jadwal Tayangan</h3>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Bioskop</th>
            <th>Judul Film</th>
            <th>Harga</th>
            <th>Jadwal Tayangan</th>
            <th>Aksi</th>
        </tr>
        @foreach ($schedules as $key => $schedule)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $schedule['cinema']['name'] }}</td>
            <td>{{ $schedule['movie']['title'] }}</td>
            <td>Rp. {{ number_format($schedule['price'], 0, ',', '.') }}</td>
            <td>
                <ul>
                    @foreach ($schedule['hour'] as $hour)
                    <li>{{ $hour }}</li>
                    @endforeach
                </ul>
            </td>
            <td>
                <div class="d-flex">
                    <a href="{{ route('staff.schedules.edit', ['id' => $schedule['id']]) }}" class="btn btn-primary me-2">Edit</a>
                    <form action="{{ route('staff.schedules.delete', ['id' => $schedule['id']]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger me-2">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </table>

    <!-- modal -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('staff.schedules.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="cinema_id" class="col-form-label">Bioskop:</label>
                            @error('cinema_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <select name="cinema_id" class="form-control @error('cinema_id') is-invalid
                            @enderror" id="cinema_id">
                                <option value="" selected disabled>Pilih Bioskop</option>
                                @foreach ($cinemas as $cinema)
                                <option value="{{ $cinema['id'] }}">{{ $cinema['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="movie_id" class="col-form-label">Film:</label>
                            @error('movie_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <select name="movie_id" class="form-control @error('movie_id') is-invalid
                            @enderror" id="movie_id">
                                <option value="" selected disabled>Pilih Film</option>
                                @foreach ($movies as $movie)
                                <option value="{{ $movie['id'] }}">{{ $movie['title'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="col-form-label">Harga:</label>
                            @error('price')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <input type="number" class="form-control @error('price') is-invalid 
                            @enderror" id="price" name="price">
                        </div>
                        <div class="mb-3">
                            <label for="hour" class="col-form-label">Jam Tayang:</label>
                            @if ($errors->has('hour.*'))
                            <small class="text-danger">{{ $errors->first('hour.*') }}</small>
                            @endif
                            <input type="time" class="form-control @if ($errors->has('hour.*')) is-invalid
                            @endif" id="hour" name="hour[]">
                            <!-- sediakan tempat untuk penambahan input baru dari js, gunakan id untuk panggilan js -->
                            <div id="aditionalInput"></div>
                            <!-- menambahkan button untuk inputan baru -->
                            <button class="btn btn-outline-primary mt-2" type="button" onclick="addInput()">+</button>
                            <button class="btn btn-outline-danger mt-2" type="button" onclick="removeInput()">-</button>
                            <!-- <button class="btn btn-outline-danger mt-2 justify-content-end" type="button" onclick="resetInput()">reset</button> -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    function addInput() {
        let content = `<input type="time" name="hour[]" id="hour" class="form-control mt-2">`;
        // ambil tempat input akan disimpan
        let place = document.querySelector('#aditionalInput');
        // karena input akan terus bertambah maka gunakan innerHTML +=
        place.innerHTML += content;
    }

    function removeInput() {
        let place = document.querySelector('#aditionalInput');
        // menghapus input terakhir
        place.removeChild(place.lastElementChild);
    }

    // function resetInput() {
    //     let place = document.querySelector('#aditionalInput');
    //     // menghapus semua input
    //     place.innerHTML = '';
    // }
</script>

@if ($errors->any())
<script>
    let modalAdd = document.querySelector('#modalAdd');
    new bootstrap.Modal(modalAdd).show();
</script>
@endif
@endpush