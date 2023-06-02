{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

<div class="card-body">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                    name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
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
@section('title', 'Login')

@section('content')

<div class="">
    <div class="mx-0 lg:mx-24 mb-8 lg:mb-10 py-16 px-15 shadow-2xl rounded-md">
        <div class="text-center mb-4 text-2xl">YOUR ACCOUNT</div>
        <div>
            <div class="flex flex-wrap">
                <div class="w-full lg:w-1/2 text-center md:border-r">
                    <div>
                        <div class="mb-5 lg:mb-20 text-2xl">
                            NEW ACCOUNT
                        </div>
                        <p class="mb-5 lg:mb-36 px-6 lg:px-4 xl:px-12 text-base leading-6">Create an account to track
                            and manage your orders and view all your personal information.</p>
                        <div class="text-center pt-3 tracking-widest">
                            <a href="{{ route('register') }}"
class="border border-gray-600 shadow-xl font-medium py-1.5 px-20 tracking-widest">
Register
</a>
</div>
</div>
</div>
<div class="w-full pt-10 lg:pt-0 lg:w-1/2">
    <div class="text-center text-2xl">
        LOGIN IN TO YOUR
    </div>
    <div class="text-center text-2xl mb-5">
        GAPOKTAN ACCOUNT
    </div>
    <div class="flex flex-col justify-center md:justify-start my-auto pt-0 md:pt-0 px-8 md:px-16 xl:px-28">
        <form class="flex flex-col" method="POST" action="{{ route('login') }}">
            @csrf

            @if (session()->has('loginError'))
            <div id="alert" class="flex bg-red-100 rounded-lg p-4 text-sm text-red-700" role="alert">
                <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                <div>
                    <span class="font-medium">{{ session('loginError') }}</span>
                </div>
            </div>
            @endif

            @if (session()->has('loginError'))
            <div class="flex flex-col pt-4">
                <label for="email" class="text-base">Email</label>
                <input type="email" id="email" placeholder="your@email.com"
                    class="shadow appearance-none border border-red-600 rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="text-xs pt-1" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="flex flex-col pt-4">
                <label for="password" class="text-base">Password</label>
                <div class="relative">
                    <input type="password" id="password" placeholder="Password"
                        class="shadow appearance-none border border border-red-600 rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
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

            @else
            <div class="flex flex-col pt-4">
                <label for="email" class="text-base">Email</label>
                <input type="email" id="email" placeholder="your@email.com"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="text-xs pt-1" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="flex flex-col pt-4">
                <label for="password" class="text-base">Password</label>
                <div class="relative">
                    <input type="password" id="password" placeholder="Password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
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
            @endif
            <div class="flex justify-between pt-4">
                <div class="inline-flex items-center form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label ml-2 text-base" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
                <a class="btn btn-link text-base hover:underline" href="">
                    {{ __('Forgot Password?') }}
                </a>
            </div>
            <div class="text-center pt-6 tracking-widest">
                <button name="signin" id="signin"
                    class="border border-gray-600 shadow-xl font-medium px-11 py-1 w-60 tracking-widest" type="submit">
                    Login
                </button>
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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/assets/css/components.css') }}">
</head>

<body style="background-color: white">
    <div id="app">
        <section class="section">
            <div class="container mt-5">
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
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Masuk</h4>
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
                                            <div class="float-right">
                                                <a href="{{ route('password.request') }}" class="text-small">
                                                    Lupa Password?
                                                </a>
                                            </div>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password"
                                            tabindex="2" required>
                                        <div class="invalid-feedback">
                                            Password yang ada masukkan salah!
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Masuk
                                        </button>
                                    </div>
                                </form>
                                <div class="mt-3 text-muted text-center">
                                    Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
                                </div>
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
