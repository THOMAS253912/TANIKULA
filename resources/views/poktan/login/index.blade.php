@extends('components.auth.template')
@section('title', 'Poktan | Masuk')

@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
            <a href="{{ url('home') }}">
                <h4>TaniKula</h4>
            </a>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6 col-12">
                <div class="">
                    <div class="card-body">
                        <img src="{{ asset('img/undraw_sign_in_re_o58h.svg') }}" alt="#" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 registerInput col-md-6 col-12">
                <div class="login-brand d-none d-md-block">
                    <a href="{{ url('home') }}">
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
                                </div>
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Masuk" id="login_btn" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            </div>
                        </form>
                        <div class="mt-3 text-muted text-center">
                            Belum punya akun? <a href="{{ route('register-poktan') }}">Daftar</a>
                        </div>
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
    $(function() {
        $("#login_form").submit(function(e) {
            e.preventDefault();
            $("#login_btn").val('Silahkan Tunggu...');
            $("#login_btn").prop('disabled', true);
            $.ajax({
                url: '{{ route('login-poktan') }}',
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
                    } else {
                        if(res.status == 200) {
                            window.location = '{{ route('poktan') }}';
                        }
                    }
                }
            });
        });
    });
</script>
@endsection
