{{-- @extends('components.auth.template')
@section('title', 'Hubungi Kami')

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
                <div class="m-5 card card-primary">
                    <div class="card-header">
                        <h1>{{$subject}}</h1>
                    </div>

                    <div class="row">
                        <h3>{{$message}}</h3>

                        <h4>You can reach me via mail or telephone : {{$email}} or {{$phone_number}}<br/>
                        Thanks
                        </h4>
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
# {{$subject}}!

{{$message}}

## Informasi Lainnya:
Anda dapat menghubungi saya melalui email atau telepon : {{$email}} or {{$phone_number}}.<br/>

Salam Hormat,<br>
{{$fullname}}
@endcomponent
