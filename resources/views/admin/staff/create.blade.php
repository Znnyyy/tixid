@extends('templates.app')

@section('content')
<div class="w-75 d-block mx-auto my-5 p-4">
<h5 class="text-center mb-3">Tambah Promo Bioskop</h5>
    <form method="POST" action="{{ route('staffs.promos.store')}}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control @error('name')
                is-invalid
            @enderror" id="name" name="name">
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control @error('email')
                is-invalid
            @enderror" id="email" name="email">
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-4 ">
            <div class="col">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role">
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div class="col">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password')
                is-invalid
            @enderror" id="password" name="password">
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
        <a href="{{ route('admin.staffs.index') }}" class="btn btn-outline-primary">Kembali</a>
    </form>
</div>
@endsection