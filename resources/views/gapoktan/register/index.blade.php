@extends('components.auth.template')
@section('title', 'TaniKula | Daftar Gapoktan')

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

    .preview-image-edit img
    {
        padding: 10px;
        max-width: 100px;
    }
</style>
<!-- AKHIR STYLE CSS -->
@endsection

@section('content')
<section class="section">
    <div class="card register container" style="margin-top: 80px; margin-bottom: 70px;">
        <div class="login-brand d-block d-md-none">
            <a href="{{ url('home') }}">
                <h4>Tanikula</h4>
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
                    <a href="{{ url('home') }}">
                        <h4>TaniKula</h4>
                    </a>
                </div>
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
                        <div id="show_success_alert"></div>
                        <form method="POST" action="#" id="register_form" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Gapoktan</label>
                                <input id="name" type="name" class="form-control" name="name" placeholder="Nama Gapoktan" autofocus>
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
                                <label for="images">Unggah Bukti</label>
                                <small class="d-flex text-danger pb-1">*Unggah berupa bukti Gapoktan</small>
                                <div>
                                    <div class="tab-content" id="myTabContent2">
                                        <div class="tab-pane fade show active" id="home3" role="tabpanel"
                                            aria-labelledby="home-tab3">
                                            <div class="preview-image-edit"> </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="file" id="imagesEdit" name="images[]" multiple class="form-control">
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" style="background: #16A085" value="Daftar" id="register_btn"
                                    class="btn text-white btn-lg btn-block">
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
        // Multiple images preview with JavaScript
        var multiImgPreview = function(input, imgPreviewPlaceholder) {
            if (input.files) {
                var filesAmount = input.files.length;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder)
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };
        $('#images').on('change', function() {
            multiImgPreview(this, 'div.preview-image');
        });

        // Multiple images preview with JavaScript
        var multiImgPreviewEdit = function(input, imgPreviewPlaceholder) {
            if (input.files) {
                var filesAmount = input.files.length;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };
        $('#imagesEdit').on('change', function() {
            multiImgPreviewEdit(this, 'div.preview-image-edit');
        });
    });

    $(function () {
            // add new employee ajax request
            $("#register_form").submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                let TotalImages = $('#imagesEdit')[0].files.length; //Total Images
                let images = $('#imagesEdit')[0];
                for (let i = 0; i < TotalImages; i++) {
                    formData.append('images' + i, images.files[i]);
                }
                formData.append('TotalImages', TotalImages);

                $("#register_btn").text('Tunggu..');
                $("#register_btn").prop('disabled', true);
                $.ajax({
                url: '{{ route('registerGapoktan-gapoktan') }}',
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (res) {
                    if (res.status == 400) {
                        showError('name', res.messages.name);
                        showError('email', res.messages.email);
                        showError('imagesEdit', res.messages.images);
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
                        window.setTimeout(function(){location.reload()},1000);
                    }
                }
            });
        });
    });
</script>
@endsection



{{-- ===================================== Login Lama ========================================== --}}


{{-- @extends('components.auth.template')
@section('title', 'Gapoktan | Daftar')

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
                                Sudah punya akun? <a href="{{ route('login-gapoktan') }}">Masuk</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="show_success_alert"></div>
                        <form method="POST" action="#" id="register_form">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Gapoktan</label>
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
                url: '{{ route('registerGapoktan-gapoktan') }}',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.status == 400) {
                        showError('name', res.messages.name);
                        showError('email', res.messages.email);
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
@endsection --}}
