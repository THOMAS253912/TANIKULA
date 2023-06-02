{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

<div class="card-body">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="password-confirm"
                class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                    autocomplete="new-password">
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
            </div>
        </div>
    </form>
</div>
</div>
</div>
</div>
</div>
@endsection --}}

{{-- @extends('components.pages.landing')
@section('title', 'Register')

@section('content')

<!--Main-->
<div class="mx-auto">
    <div class="mx-0 lg:mx-24 mb-8 lg:mb-10 py-16 px-15 shadow-2xl rounded-md">
        <div class="text-center text-gray-600 mb-4 text-2xl">YOUR ACCOUNT</div>
        <div>
            <div class="">
                <div class="w-full">
                    <div class="text-center text-gray-600 text-2xl">
                        REGISTER IN TO YOUR
                    </div>
                    <div class="text-center text-gray-600 text-2xl mb-5">
                        NORDISC ACCOUNT
                    </div>
                    <div class="flex flex-col justify-center items-center md:justify-start my-auto px-12">
                        <form class="flex flex-col" method="POST" action="{{ route('register') }}">
@csrf
<div class="grid lg:grid-cols-2 gap-x-10">
    <div class="w-80 flex flex-col pt-4">
        <label for="name" class="text-base text-gray-600">Username</label>
        <input type="text" id="username" placeholder="Username"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline form-control @error('username') is-invalid @enderror"
            name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

        @error('username')
        <span class="text-xs pt-1" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="w-80 flex flex-col pt-4">
        <label for="email" class="text-base text-gray-600">Email</label>
        <input type="email" id="email" placeholder="your@email.com"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline form-control @error('email') is-invalid @enderror"
            name="email" value="{{ old('email') }}" required autocomplete="email">

        @error('email')
        <span class="text-xs pt-1" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="w-80 flex flex-col pt-4">
        <label for="password" class="text-base text-gray-600">Password</label>
        <div class="relative">
            <input type="password" id="password" placeholder="Password"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password">
            <div class="absolute inset-y-0 right-0 top-3">
                <span class="cursor-pointer fa fa-eye-slash form-control-feedback view_password px-3"></span>
            </div>

            @error('password')
            <span class="text-xs pt-1" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="w-80 flex flex-col pt-4">
        <label for="password-confirm"" class=" text-base text-gray-600">Confirm
            Password</label>
        <div class="relative">
            <input type="password" id="password-confirm" placeholder="Confirm Password"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline form-control"
                name="password_confirmation" required autocomplete="new-password">
            <div class="absolute inset-y-0 right-0 top-3">
                <span class="cursor-pointer fa fa-eye-slash form-control-feedback confirm_password px-3"></span>
            </div>

            @error('confirm_password')
            <span class="text-xs pt-1" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
<div class="text-center pt-8 lg:pt-12 tracking-widest">
    <button type="submit"
        class="border text-gray-600 border-gray-600 shadow-xl font-medium px-11 py-1 w-60 tracking-widest">Register</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>

@endsection --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('stisla/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/assets/css/components.css') }}">
</head>

<body style="background-color: white">
    <div id="app">
        <section class="section">
            <div class="container mt-5 mb-5">
                <div class="login-brand mb-5">
                    <a href="{{ url('home') }}">
                        <h4>Sri Makmur</h4>
                    </a>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-6 col-12">
                        <div class="">
                            <div class="card-body">
                                <img src="{{ asset('img/image-login.jpg') }}" alt="#" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-lg-4 col-md-6 col-12">
                        <div class="card card-primary">
                            <div class="d-flex card-header">
                                <div class="">
                                    <h4>Daftar</h4>
                                    <div class="">
                                        Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}" class="needs-validation"
                                    novalidate="">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email" tabindex="1"
                                            required autofocus>
                                        <div class="invalid-feedback">
                                            Email yang ada masukkan salah!
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password"
                                            tabindex="2" required>
                                        <div class="invalid-feedback">
                                            Password yang ada masukkan salah!
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Konfirmasi Password</label>
                                        </div>
                                        <input id="password" type="password" class="form-control"
                                            name="confirm-password" tabindex="2" required>
                                        <div class="invalid-feedback">
                                            Password yang ada masukkan salah!
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Daftar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('stisla/assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="{{ asset('stisla/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('stisla/assets/js/custom.js') }}"></script>

    <!-- Page Specific JS File -->
</body>

</html>
