@extends('templates.app')

@section('content')
@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
<div class="container my-5">
    <div class="d-flex justify-content-end">
        <a href="{{ route('admin.movies.export') }}" class="btn btn-info me-2">Export Data</a>
        <a href="{{ route('admin.movies.create') }}" class="btn btn-success">Tambah Data</a>
    </div>
    <h5 class="mb-3">Data Film</h5>
    <table class="table table-bordered">
        <tr>
            <th>No.</th>
            <th>Poster</th>
            <th>Judul Film</th>
            <th>Status Aktif</th>
            <th>Aksi</th>
        </tr>
        @foreach ($movies as $index => $item)
        <tr class="align-middle">
            <th>{{ $index+1 }}</th>
            <th><img class="poster" src="{{ asset('storage/' . $item['poster']) }}" alt="" class="w-100"></th>
            <th>{{ $item['title'] }}</th>
            <th>
                @if ($item['actived'] == 1)
                <span class="badge badge-success">Aktif</span>
                @else
                <span class="badge badge-danger">Tidak Aktif</span>
                @endif
            </th>
            <th>
                <div class="d-flex">
                    <button type="button" class="btn btn-secondary me-2" onclick="showModal({{ $item }})">Detail</button>
                    <a href="{{ route('admin.movies.edit', ['id' => $item['id']]) }}" class="btn btn-primary me-2">Edit</a>
                    <form action="{{ route('admin.movies.delete', ['id' => $item['id']]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger me-2">Hapus</button>
                    </form>
                    @if ($item['actived'] == 1)
                    <form action="{{ route('admin.movies.deactivate', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning me-2">Nonaktif</button>
                    </form>
                    @else
                    <form action="{{ route('admin.movies.activate', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success me-2">Aktifkan</button>
                    </form>

                    @endif
                </div>
            </th>
        </tr>
        @endforeach
    </table>
    <!-- Modal -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalDetailBody">
                    ...
                </div>
                <div class="modal-footer" id="modalDetailFooter">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- mengisi stack --}}
@push('script')
<script>
    function showModal(item) {
        // console.log(item)
        // pengambilan gambar di public
        let image = "{{ asset('storage/') }}" + "/" + item.poster;
        // membuat konten yang akan ditambahkan
        // backlip (diatas tab) : menulis string lebih dari 1 baris
        let content = `
                <img src="${image}" width="120" class="d-block mx-auto my-3">
                <ul style="list-style-type: none; ">
                    <li><b>Judul Film</b> : ${item.title}</li>
                    <li><b>Durasi</b> : ${item.duration}</li>
                    <li><b>Genre</b> : ${item.genre}</li>
                    <li><b>Sutradara</b> : ${item.director}</li>
                    <li><b>Usia Minial</b> : <span class="badge badge-danger">${item.age_rating}+</span></li>
                    <li><b>Sinopsis</b> : ${item.description}</li>
                </ul>
            `;
        let modalDetailBody = document.querySelector("#modalDetailBody");
        modalDetailBody.innerHTML = content;
        let modalDetail = document.querySelector("#modalDetail");
        new bootstrap.Modal(modalDetail).show();
    }
</script>
@endpush