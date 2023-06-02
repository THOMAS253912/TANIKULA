@extends('pages.template3')
@section('title', 'Hubungi Kami')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* CSS */
    </style>
@endsection

@section('content')
<section class="item-details section bg-white overflow-hidden">
    <div class="container">
        <div class="row justify-content-center rounded" style="border: 1px solid #16A085;">
            <div class="col-md-12 p-5">
                <div class="wrapper">
                    <div class="row no-gutters">
                        <div class="col-12">
                            <div class="contact-wrap w-100 p-md-5 p-4">
                                <h3 class="mb-5 fw-bold" style="color:#16A085;">Hubungi Kami</h3>
                                <form method="POST" action="#" id="contactForm" name="contactForm" class="contactForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label class="label pb-2" for="name">{{ __('Nama Lengkap') }}</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="fullname" id="fullname"
                                                    placeholder="Nama">
                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label class="label pb-2" for="email">{{ __('Email') }}</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                                                    placeholder="Email">
                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group mb-4">
                                                <label class="label pb-2" for="subject">{{ __('Subjek') }}</label>
                                                <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" id="subject"
                                                    placeholder="Subjek">
                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-4">
                                                <label class="label pb-2" for="subject">{{ __('Telp') }}</label>
                                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" id="phone_number"
                                                    placeholder="Telp">
                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="label pb-2" for="#">{{ __('Pesan') }}</label>
                                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="message" cols="30"
                                                    rows="4" placeholder="Pesan"></textarea>
                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-4">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Upload Foto') }}</label>
                                                <div class="pb-2">
                                                    <img id="addPreview" class="img-fluid img-thumbnail image"
                                                        src="{{ asset('stisla/assets/img/example-image.jpg') }}" alt="edukasi"
                                                        style="width: 20rem; height: 10rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                                </div>
                                                <input type="file" accept="image/*" class="form-control @error('screenshot') is-invalid @enderror" id="screenshot" name="screenshot" autofocus>
                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="submit" id="send_contact_us" style="background: #16A085;" value="Kirim Pesan" class="btn border border-light text-white">
                                                <div class="submitting"></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 pb-md-5 pb-4">
                            <div class="dbox w-100 text-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="fa fa-map-marker"></span>
                                </div>
                                <div class="text">
                                    <p><span>Alamat:</span> Desa Krasak, Kecamatan Jatibarang, Kabupaten Indramayu.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pb-md-5 pb-4">
                            <div class="dbox w-100 text-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="fa fa-phone"></span>
                                </div>
                                <div class="text">
                                    <p><span>Telp:</span> <a style="color:#16A085;" href="tel://1234567920">(+62) 33 169 7720</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pb-md-5 pb-4">
                            <div class="dbox w-100 text-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="fa fa-paper-plane"></span>
                                </div>
                                <div class="text">
                                    <p><span>Email:</span> <a style="color:#16A085;" href="mailto:info@yoursite.com">tanikula.app@gmail.com</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pb-md-5 pb-4">
                            <div class="dbox w-100 text-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <span class="lni lni-instagram"></span>
                                </div>
                                <div class="text">
                                    <p><span>Instagram:</span><a style="color:#16A085;" href="#">Tanikula</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <button onclick="startFCM()"
                    class="btn btn-danger btn-flat">Allow notification
                </button>
            <div class="card mt-3">
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form action="{{ route('send.web-notification') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Message Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Message Body</label>
                            <textarea class="form-control" name="body"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Send Notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(function() {
            $('#screenshot').on('change', function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = viewer.load;
                reader.readAsDataURL(file);
            });

            var viewer = {
                load : function(e) {
                    $('#addPreview').attr('src', e.target.result)
                }
            }
        });

        $(function () {
            $("#contactForm").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#send_contact_us").text('Silahkan Tunggu..');
                $("#send_contact_us").prop('disabled', true);
                $.ajax({
                url: '{{ route('addContactUs') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400)
                    {
                        showError('fullname', response.messages.fullname);
                        showError('email', response.messages.email);
                        showError('subject', response.messages.subject);
                        showError('message', response.messages.message);
                        showError('phone_number', response.messages.phone_number);
                        showError('screenshot', response.messages.screenshot);
                        $("#send_contact_us").val('Kirim Pesan');
                        $("#send_contact_us").prop('disabled', false);
                    }
                        else if (response.status == 200)
                    {
                        iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                            title: 'Berhasil',
                            message: response.messages,
                            position: 'topRight'
                        });
                        $("#send_contact_us").val('Kirim Pesan');
                        $("#send_contact_us").prop('disabled', false);
                        window.setTimeout(function(){location.reload()},1000);
                    }
                }
                });
            });
        });

        const current = document.getElementById("current");
        const opacity = 0.6;
        const imgs = document.querySelectorAll(".img");
        imgs.forEach(img => {
            img.addEventListener("click", (e) => {
                //reset opacity
                imgs.forEach(img => {
                    img.style.opacity = 1;
                });
                current.src = e.target.src;
                //adding class
                //current.classList.add("fade-in");
                //opacity
                e.target.style.opacity = opacity;
            });
        });

        // const messaging = firebase.messaging();
        // function startFCM() {
        //     messaging
        //         .requestPermission()
        //         .then(function () {
        //             return messaging.getToken()
        //         })
        //         .then(function (response) {
        //             $.ajaxSetup({
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 }
        //             });
        //             $.ajax({
        //                 url: '{{ route("store.token") }}',
        //                 type: 'POST',
        //                 data: {
        //                     token: response
        //                 },
        //                 dataType: 'JSON',
        //                 success: function (response) {
        //                     alert('Token stored.');
        //                 },
        //                 error: function (error) {
        //                     alert(error);
        //                 },
        //             });
        //         }).catch(function (error) {
        //             alert(error);
        //         });
        // }

        // messaging.onMessage(function (payload) {
        //     const title = payload.notification.title;
        //     const options = {
        //         body: payload.notification.body,
        //         icon: payload.notification.icon,
        //     };
        //     new Notification(title, options);
        // });
    </script>
@endsection
