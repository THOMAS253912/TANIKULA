{{-- @extends('components.auth.template')
@section('title', 'Verifikasi Email')

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
                        <h1>Verifikasi Email</h1>
                    </div>

                    <div class="card-body">
                        <p class="text-muted">Silakan verifikasi email Anda dengan tautan di bawah ini: </p>
                        <div class="form-group">
                            <a href="{{ route('user.verify', $token) }}" class="btn btn-primary btn-lg btn-block">Verifikasi Email</a>
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
# Verifikasi Email!

Silakan verifikasi email Anda dengan tautan di bawah ini:

@component('mail::button', ['url' => url('/account/verify/' . $token)])
Verifikasi Email
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
