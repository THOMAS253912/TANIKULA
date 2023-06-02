@extends('components.auth.template')
@section('title', 'Poktan | Daftar')

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
                <h4>Sri Makmur</h4>
            </a>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6 col-12">
                <div class="">
                    <div class="card-body">
                        <img src="{{ asset('img/undraw_my_password_re_ydq7.svg') }}" alt="#" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 registerInput col-md-6 col-12">
                <div class="login-brand d-none d-md-block">
                    <a href="{{ url('home') }}">
                        <h4>Sri Makmur</h4>
                    </a>
                </div>
                <div class="card card-primary">
                    <div class="d-flex card-header">
                        <div class="">
                            <h4>Daftar</h4>
                            <div class="">
                                Sudah punya akun? <a href="{{ route('login-poktan') }}">Masuk</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="show_success_alert"></div>
                        <form method="POST" action="#" id="register_form">
                            @csrf
                            <div class="form-group">
                                <label for="gapoktan_id">Nama Gapoktan</label>
                                <select class="form-control select2" id="gapoktan_id" name="gapoktan_id" autofocus>
                                    <option selected disabled>Pilih Gapoktan</option>
                                    @foreach ($gapoktan as $item)
                                        @if ( old('gapoktan_id') == $item->id )
                                            <option value="{{ $item->id }}" selected>{{ $item->user->name }}</option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Nama Poktan</label>
                                <input id="name" type="text" class="form-control" name="name" placeholder="Nama" autofocus>
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="chairman">Nama Ketua</label>
                                <input id="chairman" type="text" class="form-control" name="chairman" placeholder="Nama Ketua" autofocus>
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" placeholder="E-mail" autofocus>
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Password</label>
                                </div>
                                <input id="password" type="password" class="form-control" name="password"
                                    placeholder="Password">
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Konfirmasi Password</label>
                                </div>
                                <input type="password" class="form-control" name="cpassword"
                                    id="cpassword" placeholder="Konfirmasi Password">
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Daftar" id="register_btn"
                                    class="btn btn-primary btn-lg btn-block">
                            </div>
                        </form>
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
    $(function () {
        $("#register_form").submit(function (e) {
            e.preventDefault();
            $("#register_btn").val('Silahkan Tunggu...');
            $("#register_btn").prop('disabled', true);
            $.ajax({
                url: '{{ route('registerPoktan-poktan') }}',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.status == 400) {
                        showError('name', res.messages.name);
                        showError('email', res.messages.email);
                        showError('gapoktan_id', res.messages.gapoktan_id);
                        showError('chairman', res.messages.chairman);
                        showError('password', res.messages.password);
                        showError('cpassword', res.messages.cpassword);
                        $("#register_btn").val('Daftar');
                        $("#register_btn").prop('disabled', false);
                    } else if (res.status == 200) {
                        // $("#show_success_alert").html(showMessage('success', res.messages));
                        iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                            title: 'Berhasil',
                            message: res.messages,
                            position: 'topRight'
                        });
                        $("#register_form")[0].reset();
                        removeValidationClasses("#register_form");
                        $("#register_btn").val('Daftar');
                        $("#register_btn").prop('disabled', false);
                    }
                }
            });
        });
    });
</script>
@endsection
