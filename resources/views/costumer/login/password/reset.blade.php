@extends('components.auth.template')
@section('title', 'TaniKula | Reset Password')

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
            <a onclick="home('{{ url('home') }}')" href="#">
                <h4>TaniKula</h4>
            </a>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6 col-12">
                <div class="text-center">
                    <div class="card-body">
                        <img src="{{ asset('img/Banner Tanikula.svg') }}" alt="#" class="img-fluid">
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
                    <div class="card-header">
                        <h4>Reset Password</h4>
                    </div>

                    <div class="card-body">
                        <div id="reset_alert"></div>
                        <form method="POST" action="#" id="reset_form">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" disabled value="{{ $email }}" placeholder="E-mail"
                                    required autofocus>
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="control-label">Password Baru</label>
                                <input id="npass" type="password" class="form-control" name="npass"
                                    placeholder="Password Baru" required>
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="control-label">Konfirmasi Password Baru</label>
                                <input id="cnpass" type="password" class="form-control" name="cnpass"
                                    placeholder="Konfirmasi Password Baru" required>
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Perbarui Password" style="background: #16A085" id="reset_btn"
                                    class="btn text-white btn-lg btn-block" tabindex="4">
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
    $(function() {
        $("#reset_form").submit(function(e) {
            e.preventDefault();
            $("#reset_btn").val('Silahkan Tunggu..');
            $("#reset_btn").prop('disabled', true);
            $.ajax({
                url: '{{ route('resetPassword') }}',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res){
                    if (res.status == 400) {
                        showError('npass', res.messages.npass);
                        showError('cnpass', res.messages.cnpass);
                        $("#reset_btn").val("Perbarui Password");
                        $("#reset_btn").prop('disabled', false);
                    } else if (res.status == 401){
                        // $("#forgot_alert").html(showMessage('danger', res.messages));
                        iziToast.warning({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                            title: 'Peringatan',
                            message: res.messages,
                            position: 'topRight'
                        });
                        $("#reset_btn").val("Perbarui Password");
                        $("#reset_btn").prop('disabled', false);
                        removeValidationClasses("#reset_form");
                    } else {
                        $("#reset_form")[0].reset();
                        $("#reset_alert").html(showMessage('success', res.success));
                        iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                            title: 'Berhasil',
                            message: res.messages,
                            position: 'topRight'
                        });
                        $("#reset_btn").val("Perbarui Password");
                        $("#reset_btn").prop('disabled', false);
                    }
                }
            });
        });
    });

</script>
@endsection
