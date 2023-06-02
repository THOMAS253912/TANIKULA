@extends('components.auth.template')
@section('title', 'Lupa Password')

@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- MULAI STYLE CSS -->

<!-- AKHIR STYLE CSS -->
@endsection

@section('content')
<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="login-brand">
                    <a href="{{ url('home') }}">
                        <h4>TaniKula</h4>
                    </a>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Lupa Password</h4>
                    </div>

                    <div class="card-body">
                        <p class="text-muted">We will send a link to reset your password</p>
                        <form method="POST" action="#" id="forgot_form">
                        @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" placeholder="E-mail" tabindex="1" required
                                    autofocus>
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Lupa Password" id="forgot_btn" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            </div>
                        </form>
                        <div class="mt-3 text-muted text-center">
                            Kembali ke <a href="{{ route('login-pembeli') }}" class="text-decoration-none">Halaman Masuk</a>
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


</script>
@endsection
