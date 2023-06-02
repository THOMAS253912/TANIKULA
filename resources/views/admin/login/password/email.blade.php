{{-- @extends('components.auth.template')
@section('title', 'Tanikula | Password Reset')

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
                <div class="card card-primary">
                    <div class="card-header">
                        <h1>Reset password Anda</h1>
                    </div>

                    <div class="card-body">
                        <p class="text-muted">Klik tautan di bawah ini untuk mengatur ulang kata sandi Anda: </p>
                        <div class="form-group">
                            <a href="{{ $details['body'] }}" class="btn btn-primary btn-lg btn-block">Reset Password</a>
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
@endsection --}}

@component('mail::message')
# Reset password Anda!

Klik tautan di bawah ini untuk mengatur ulang kata sandi Anda:

@component('mail::button', ['url' => url($details['body'])])
Reset Password
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
