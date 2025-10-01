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

    <h2 class="text-center mt-5 mb-4">Login</h2>
    <p class="text-center">Silahkan Login Untuk Lanjut</p>
    <form class="w-50 d-block mx-auto my-5" method="POST" action="{{ route('auth') }}">
        @if (Session::get('success'))
        <div class="alert alert-success my-3">
            {{ Session::get('success') }}
        </div>
        @endif
        @if ( Session::get('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        @csrf
        <!-- Email input -->
        @error('email')
        <small class="text-danger">{{ $message }}</small>
        @enderror
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" id="form1Example1" class="form-control @error('email') is-invalid
            @enderror" name="email" />
            <label class="form-label" for="form1Example1">Email address</label>
        </div>

        <!-- Password input -->
        @error('password')
        <small class="text-danger">{{ $message }}</small>
        @enderror
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" id="form1Example2" class="form-control @error('password') is-invalid
            @enderror" name="password" />
            <label class="form-label" for="form1Example2">Password</label>
        </div>

        <!-- Submit button -->
        <button data-mdb-ripple-init type="submit" class="btn-sign btn btn-primary btn-block">Sign In</button>
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-block" data-mdb-ripple-init>Kembali</a>
    </form>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
</body>

</html>