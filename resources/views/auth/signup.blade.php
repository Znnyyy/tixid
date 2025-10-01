<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://play-lh.googleusercontent.com/FcRZx_UEXN2uc7uKM5EKGn7Jmb65c8VVELlmligxdfUcjKKIpzFX0SHXFePllD2g4ik">
    <title>TIX ID</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
        rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css"
        rel="stylesheet" />
</head>

<body>

    <h2 class="text-center mt-5 mb-4">Sign Up</h2>
    <p class="text-center">Silahkan Daftar Untuk Lanjut</p>
    <!-- 2 column grid layout with text inputs for the first and last names -->
    <form class="w-50 d-block mx-auto my-5" method="POST" action="{{ route('signup.send_data') }}">
        @if (Session::get('failed'))
        <div class="alert alert-danger my-3">
            {{ Session::get('failed') }}
        </div>
        @endif
        @csrf
        <div class="row mb-4 ">
            <div class="col">
                @error('first_name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
                <div data-mdb-input-init class="form-outline">
                    <input type="text" id="form3Example1" class="form-control @error('first_name') is-invalid @enderror" name="first_name" />
                    <label class="form-label" for="form3Example1">First name</label>
                </div>
            </div>
            <div class="col">
                @error('last_name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
                <div data-mdb-input-init class="form-outline">
                    <input type="text" id="form3Example2" class="form-control @error('last_name') is-invalid @enderror" name="last_name" />
                    <label class="form-label" for="form3Example2">Last name</label>
                </div>
            </div>
        </div>

        @error('email')
        <small class="text-danger">{{ $message }}</small>
        @enderror
        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" id="form3Example3" class="form-control @error('email') is-invalid @enderror" name="email" />
            <label class="form-label" for="form3Example3">Email address</label>
        </div>

        @error('password')
        <small class="text-danger">{{ $message }}</small>
        @enderror
        <!-- Password input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" id="form3Example4" class="form-control @error('password') is-invalid @enderror" name="password" />
            <label class="form-label" for="form3Example4">Password</label>
        </div>

        <!-- Submit button -->
        <button data-mdb-ripple-init type="submit" class="btn-sign btn btn-primary btn-block">Sign Up</button>
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-block" data-mdb-ripple-init>Kembali</a>

    </form>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
</body>

</html>