@extends('templates.app')

@section('content')
<div class="w-75 d-block mx-auto my-5 p-4">
    <h5 class="text-center mb-3">Edit Data Staff</h5>
    <form method="POST" action="{{ route('admin.staffs.update', ['id' => $staffs['id']]) }}">
        @csrf
        <!-- timpa method html post menjadi put -->
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control @error('name')
                is-invalid
            @enderror" id="name" name="name" value="{{ $staffs['name'] }}">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            {{-- $cinema mengambil data cinema yang akan di edit dari conttroller edit bagian compact
                dimunculkan di input dengan value="" dan textarea di tengah2 penutup </textarea>  --}}
            <input type="text" rows="5" class="form-control @error('email')
                is-invalid
            @enderror" id="email" name="email" value="{{ $staffs['email'] }}">
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Edit</button>
        <a href="{{ route('admin.staffs.index') }}" class="btn btn-outline-primary">Kembali</a>
    </form>
</div>
@endsection