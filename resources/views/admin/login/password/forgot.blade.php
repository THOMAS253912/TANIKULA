@extends('components.auth.template')
@section('title', 'Tanikula | Lupa Password')

@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
<!-- MULAI STYLE CSS -->
<style>
/* Importing fonts from Google */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

/* Reseting */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    color: #16A085;
    /* background: linear-gradient(135deg, #00c3ff, #16A085f1c);
    background: linear-gradient(135deg, #fc00ff, #00dbde);
    background-image: linear-gradient(135deg, #ff00ba 0%, #fae713 100%);
    background-image: linear-gradient(150deg, #5a00ff 0%, #ff1ff7 100%, #ff1ff7 100%);
    min-height: 93vh; */
}

.wrapper {
    max-width: 500px;
    margin: 50px auto;
}

.wrapper .card {
    max-width: 400px;
    min-height: 450px;
    margin: 30px;
    background: rgba(255, 255, 255, 0.1);
    overflow: hidden;
    /* backdrop-filter: blur(10px); */
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 15px;
    cursor: pointer;
    padding-top: 3rem;
    padding-bottom: 3rem;
    padding-left: 3rem;
    padding-right: 3rem;
}

.wrapper .card a {
    text-decoration: none;
    color: #16A085;
}

.wrapper .card a:hover {
    color: #16A085;
}

.wrapper .card .input-field {
    border: 1px solid #16A085;
    border-radius: 5px;
    color: #16A085;
    padding: 0.3rem;
}

.wrapper .card .input-field input {
    background-color: inherit;
}

.wrapper .card .input-field input.form-control,
.wrapper .card .input-field input.form-control:focus {
    border: none;
    outline: none;
    box-shadow: none;
    color: #16A085;
}

.wrapper .card .input-field button.btn {
    color: #16A085;
    padding: 0rem;
    padding-right: 0.5rem;
}

.wrapper .card .input-field button.btn:hover {
    color: #16A085;
}

.wrapper .card .input-field button.btn:focus {
    border: none;
    outline: none;
    box-shadow: none;
}

.wrapper .card .input-field input::placeholder {
    color: #16A085;
}

.wrapper .card .option {
    display: block;
    position: relative;
    padding-left: 25px;
    cursor: pointer;
    user-select: none
}

.wrapper .card .option span.text-light-white:hover {
    color: #16A085;

}

.wrapper .card .option input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0
}

.wrapper .card .btn.btn-primary {
    border-radius: 20px;
    width: 100%;
    padding: 0.7rem;
    background-color: #16A085;
    color: #ffffff;
    border: none;
}

.wrapper .card .btn.btn-primary:hover {
    color: #ffffff;
    background: #333;
}

.wrapper .card .btn.btn-primary:focus {
    border: none;
    box-shadow: none;
}

.wrapper .card .text-light-white {
    color: #16A085;
}

.wrapper .card .line span.connect {
    position: absolute;
    top: -12px;
    left: 33%;
    color: #000;
    padding: 0 0.3rem;
    z-index: 100;
    border-radius: 2px;
    background-color: #16A085;
}

.wrapper .card .connections a img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;

}

@media (max-width: 767px) {
    .wrapper .card {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

@media(max-width: 370px) {
    .wrapper .card .line:after {
        left: 27%;
    }
}

@media(max-width: 350px) {
    .wrapper {
        margin: 10px auto;
    }

    .wrapper .card {
        margin: 10px;
    }
}
</style>
<!-- AKHIR STYLE CSS -->
@endsection

@section('content')
    <div class="wrapper">
        <div class="card border shadow">
            <form method="POST" action="#" id="forgot_form" class="d-flex flex-column">
            @csrf
                <div class="h3 text-center mt-3" style="color: #16A085"><a href="{{ url('home') }}">ADMIN</a></div>
                <div class="d-block mt-4">
                    <p class="text-muted">Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda</p>
                    <label for="email" class="control-label">Email</label>
                </div>
                <div class="d-flex align-items-center input-field mb-4">
                    <span class="far fa-user p-2"></span>
                    <input type="email" name="email" id="email" placeholder="Email" required class="form-control">
                </div>
                <div class="invalid-feedback"></div>
                <div class="my-3">
                    <input type="submit" value="Lupa Password" id="forgot_btn" class="btn btn-primary">
                </div>
            </form>
            <div class="mt-3 text-muted text-center">
                Kembali ke <a href="{{ route('login-admin') }}" class="text-decoration-none" style="font-weight: bold">Halaman Masuk</a>
            </div>
        </div>
    </div>
    <div class="simple-footer">
        Copyright &copy; TaniKula @if(date('Y') == '2022') {{ date('Y') }} @else 2022 - {{ date('Y') }} @endif
    </div>
@endsection

@section('script')
<!-- LIBARARY JS -->



<!-- AKHIR LIBARARY JS -->

<!-- JAVASCRIPT -->
<script>
    $(function() {
        $("#forgot_form").submit(function(e) {
            e.preventDefault();
            $("#forgot_btn").val('Silahkan Tunggu..');
            $("#forgot_btn").prop('disabled', true);
            $.ajax({
                url: '{{ route('forgotPasswordEmail-admin') }}',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res){
                    if (res.status == 400) {
                        showError('email', res.messages.email);
                        $("#forgot_btn").val("Reset Password");
                        $("#forgot_btn").prop('disabled', false);
                    } else if (res.status == 200){
                        // $("#forgot_alert").html(showMessage('success', res.messages));
                        iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                            title: 'Berhasil',
                            message: res.messages,
                            position: 'topRight'
                        });
                        $("#forgot_btn").val("Reset Password");
                        $("#forgot_btn").prop('disabled', false);
                        removeValidationClasses("#forgot_form");
                        $("#forgot_form")[0].reset();
                    } else {
                        $("#forgot_btn").val("Reset Password");
                        $("#forgot_btn").prop('disabled', false);
                        // $("#forgot_alert").html(showMessage('danger', res.messages));
                        iziToast.warning({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                            title: 'Peringatan',
                            message: res.messages,
                            position: 'topRight'
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
