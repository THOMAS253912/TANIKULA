@extends('components.auth.template')
@section('title', 'Masuk')

@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- MULAI STYLE CSS -->

<!-- AKHIR STYLE CSS -->
@endsection

@section('content')

<section class="section">
    <div class="container mt-5">
        <div class="login-brand mb-5">
            <a href="{{ url('home') }}">
                <h4>TaniKula</h4>
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
                        <h4>Reset Password</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="#" id="reset_form">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" placeholder="E-mail"
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
                                <input type="submit" value="Perbarui Password" id="reset_btn"
                                    class="btn btn-primary btn-lg btn-block" tabindex="4">
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


</script>
@endsection
