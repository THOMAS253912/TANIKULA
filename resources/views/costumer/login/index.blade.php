@extends('components.auth.template')
@section('title', 'TaniKula | Masuk')

@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<!-- MULAI STYLE CSS -->
<style>
    .register {
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }

    .registerInput {
        margin-top: 55px;
        margin-bottom: 55px;
    }

    @media (max-width: 767px) {
        .register {
            box-shadow: none;
        }

        .registerInput {
            margin-top: 0;
            margin-bottom: 0;
        }
    }
</style>
<!-- AKHIR STYLE CSS -->
@endsection

@section('content')
<section class="section">
    <div class="card register container" style="margin-top: 80px; margin-bottom: 70px;">
        <div class="login-brand d-block d-md-none">
            <a onclick="home('{{ url('home') }}')" href="#">
                <h4>TaniKula</h4>
            </a>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6 col-12">
                <div class="text-center">
                    <div class="card-body">
                        <img src="{{ asset('img/Banner Tanikula.svg') }}" alt="#" class="img-fluid text-center">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 registerInput col-md-6 col-12">
                <div class="login-brand d-none d-md-block">
                    <a onclick="home('{{ url('home') }}')" href="#">
                        <h4>TaniKula</h4>
                    </a>
                </div>
                <div class="card card-primary">
                    <div class="d-flex card-header">
                        <div class="">
                            <h4>Masuk</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="login_alert"></div>
                        <form method="POST" action="#" id="login_form">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" placeholder="E-mail"
                                    autofocus>
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Password</label>
                                    <div class="float-right">
                                        <a onclick="forgotPassword('{{ route('forgotPassword-pembeli') }}')" href="#" class="text-small">
                                            Lupa Password?
                                        </a>
                                    </div>
                                </div>
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                                <div class="invalid-feedback">
                                </div>
                                <div class="custom-control custom-checkbox view_password">
                                    <input type="checkbox" class="custom-control-input" tabindex="3">
                                    <label class="custom-control-label" style="font-size: 12px" for="remember-me">Lihat Password</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Masuk" id="login_btn" style="background: #16A085" class="btn py-2 text-white btn-block" tabindex="4">
                                <a class="btn col-12 mt-3 text-white py-2" style="background: #007bff" href="{{ url('auth/google') }}"><i class="bi bi-google text-white"></i> Google Sign In</a>
                            </div>
                        </form>
                        <div class="mt-3 text-center">
                            <div class="dropdown">
                                Belum punya akun? <a style="cursor: pointer" data-toggle="dropdown" aria-expanded="false">Daftar</a>
                                <div class="dropdown-menu shadow border border-secondary">
                                    <a class="dropdown-item" onclick="register('{{ url('/register') }}')" href="#">Sebagai Pembeli</a>
                                    <a class="dropdown-item" onclick="registerGapoktan('{{ url('/gapoktan/register') }}')" href="#">Sebagai Gapoktan</a>
                                </div>
                            </div>
                        </div>
                        <!-- tambahkan script di bawah ini untuk membuat tombol signin google -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<!-- LIBARARY JS -->
<!-- AKHIR LIBARARY JS -->
<!-- JAVASCRIPT -->
<script>
        $('.view_password').on('click', function () {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
                $(this).html(`<input type="checkbox" checked class="custom-control-input" tabindex="3">
                                    <label class="custom-control-label" style="font-size: 12px" for="remember-me">Tutup Password</label>`);
            } else {
                x.type = "password";
                $(this).html(`<input type="checkbox" class="custom-control-input" tabindex="3">
                                    <label class="custom-control-label" style="font-size: 12px" for="remember-me">Lihat Password</label>`);
            }
        });

    $(function() {
        $("#login_form").submit(function(e) {
            e.preventDefault();
            $("#login_btn").val('Silahkan Tunggu...');
            $("#login_btn").prop('disabled', true);
            $.ajax({
                url: '{{ route('loginPembeli-pembeli') }}',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res){
                    if (res.status == 400) {
                        showError('email', res.messages.email);
                        showError('password', res.messages.password);
                        $("#login_btn").val('Masuk');
                        $("#login_btn").prop('disabled', false);
                    } else if (res.status == 401) {
                        // $("#login_alert").html(showMessage('danger', res.messages));
                        iziToast.warning({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                            title: 'Peringatan',
                            message: res.messages,
                            position: 'topRight'
                        });
                        $("#login_btn").val('Masuk');
                        $("#login_btn").prop('disabled', false);
                    } else if (res.status == 200){
                        window.location = '{{ route('pembeli') }}';
                    } else if (res.status == 201){
                        window.location = '{{ route('gapoktan') }}';
                    } else if (res.status == 202){
                        window.location = '{{ route('poktan') }}';
                    } else if (res.status == 203){
                        window.location = '{{ route('petani') }}';
                    }
                }
            });
        });
    });
</script>
@endsection
