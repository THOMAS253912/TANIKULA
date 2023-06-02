@extends('costumer.template')
@section('title','Biodata Diri')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- MULAI STYLE CSS -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
        integrity="sha256-pODNVtK3uOhL8FUNWWvFQK0QoQoV3YA9wGGng6mbZ0E=" crossorigin="anonymous" />
    <!-- AKHIR STYLE CSS -->
    <style>
        input[type='file'] {
            opacity:0
        }

        .datepicker {
            z-index: 1600 !important; /* has to be larger than 1050 */
        }
    </style>
@endsection

@section('content')
<div class="container-fluid px-2 px-md-4 mb-5">
    <div class="page-header min-height-300 border-radius-xl mt-4"
        style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <span class="mask  bg-primary  opacity-6"></span>
    </div>
    <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="row gx-4 mb-2">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    @if ($userInfo->image)
                    <img id="image_preview" src="{{asset('../storage/profile/'. $userInfo->image)}}" alt="profile_image"
                        class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 80px; height: 80px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                    @else
                    <img id="image_preview" src="{{ asset('../stisla/assets/img/example-image.jpg') }}" alt="profile_image"
                        class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 80px; height: 80px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                    @endif
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        {{$userInfo->user->name}}
                    </h5>
                </div>
                <div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input hidden" style="width: 0px;" accept="image/*" id="image" name="image">
                        <label class="custom-file-label" for="image"><i class="bi bi-camera h-4"></i> Ubah foto</label>
                        <label class="custom-file-label ps-5" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" for="">
                            <i class="bi bi-three-dots h-4"></i>
                        </label>
                        <ul class="dropdown-menu" style="border: 1px solid" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item deletePhoto" id="{{ $userInfo->id }}" style="font-size: 12px; color: red;" href="#"><i class="bi bi-trash"></i> Hapus Foto Profil</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-fill p-1">
                        <li class="nav-item">
                            <a class="btn {{ Request::is('pembeli') ? 'active text-white bg-primary shadow' : 'border' }}" onclick="pembeli_dashboard('{{ url('pembeli') }}')" href="#">
                                <span class="ms-1 fw-bold">Biodata Diri</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn {{ Request::is('pembeli/alamat*') ? 'active text-white bg-primary shadow' : 'border' }}" onclick="pembeli_alamat('{{ url('pembeli/alamat') }}')" href="#">
                                <span class="ms-1 fw-bold">Daftar Alamat</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" id="id" value="{{ $userInfo->id }}">
        <div class="row">
            <div class="row">
                <div class="col-12">
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Biodata Diri</h6>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editProfile">
                                        <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip"
                                            data-bs-placement="top"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <p class="text-sm">
                                @if (!$checkUser)
                                   <span class="text-danger">Silahkan melengkapi biodata diri anda!</span>
                                @else
                                   <span class="text-success">Biodata diri anda lengkap!</span>
                                @endif
                            </p>
                            <hr class="horizontal gray-light my-4">
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                    Nama Lengkap:</strong> &nbsp; {{ $userInfo->user->name }}</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong
                                        class="text-dark">No Hp:</strong> &nbsp; (+62)
                                    @if ( $userInfo->telp )
                                        {{ $userInfo->telp }}
                                    @else
                                        <span class="text-danger">Belum diisi</span>
                                    @endif
                                </li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong
                                        class="text-dark">Email:</strong> &nbsp; {{ $userInfo->user->email }}</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong
                                        class="text-dark">Tanggal Lahir:</strong> &nbsp;
                                    @if ( $userInfo->birth )
                                        {{ date("d F Y", strtotime($userInfo->birth)) }}
                                    @else
                                        <span class="text-danger">Belum diisi</span>
                                    @endif
                                </li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong
                                        class="text-dark">Jenis Kelamin:</strong> &nbsp;
                                    @if ( $userInfo->gender )
                                        {{ $userInfo->gender }}
                                    @else
                                        <span class="text-danger">Belum diisi</span>
                                    @endif
                                </li>
                                <li class="list-group-item border-0 ps-0 pb-0">
                                    <strong class="text-dark text-sm">Social:</strong> &nbsp;
                                    <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                        <i class="fab fa-facebook fa-lg"></i>
                                    </a>
                                    <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                        <i class="fab fa-twitter fa-lg"></i>
                                    </a>
                                    <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                        <i class="fab fa-instagram fa-lg"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="text-end mt-4 mt-md-0">
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editPassword" class="btn btn-light">Edit Password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Alamat -->
<div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Biodata Diri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <style>
                #style-2::-webkit-scrollbar-track
                {
                    -webkit-box-shadow: inset 0 0 6px #16A085;
                    border-radius: 10px;
                    background-color: #F5F5F5;
                }

                #style-2::-webkit-scrollbar
                {
                    width: 12px;
                    background-color: #F5F5F5;
                }

                #style-2::-webkit-scrollbar-thumb
                {
                    border-radius: 10px;
                    -webkit-box-shadow: inset 0 0 6px #16A085;
                    background-color: #16A085;
                }
            </style>
            <div class="modal-body" id="style-2">
                <form action="#" method="POST" id="profile_form" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div>
                        <div class="mb-3">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control border px-3" name="name" id="name"
                                value="{{ $userInfo->user->name }}" required="">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control border px-3" id="email" name="email"
                                value="{{ $userInfo->user->email }}" required="">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="telp">No Handphone</label>
                            <input type="tel" name="telp" id="telp" value="{{ $userInfo->telp }}" placeholder="+62"
                                class="form-control phone-number border px-3">
                                <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="row form-group mb-3">
                            <label for="birth">Tanggal Lahir</label>
                            <div class="input-group">
                                @if ($userInfo->birth)
                                <input type="text" name="birth" id="birth" class="form-control datepicker border px-3"
                                    value="{{ date("d-F-Y", strtotime($userInfo->birth)) }}">
                                @else
                                <input type="text" name="birth" id="birth" class="form-control datepicker border px-3"
                                    placeholder="Tanggal lahir">
                                @endif
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="gender">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-control select2 border px-3">
                                <option value="" class="py-1" selected disabled>Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" class="py-1" {{ $userInfo->gender == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-Laki</option>
                                <option value="Perempuan" class="py-1" {{ $userInfo->gender == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <input type="submit" id="profile_btn" value="Ubah Biodata Diri" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Password -->
<div class="modal fade" id="editPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="editPasswordForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <small class="d-flex text-danger pb-1">*Catatan:
                                <br>1. Jika tidak ingin ubah password biarkan kosong,
                                <br>2. Dan jika ingin ubah password, silahkan masukkan password.
                            </small>
                            <input type="password" id="password" name="password" class="form-control border px-3" placeholder="Password" required>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <input type="submit" id="password_btn" class="btn btn-primary" value="Ubah Password">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <!-- LIBARARY JS -->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"
        integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js"
        integrity="sha256-siqh9650JHbYFKyZeTEAhq+3jvkFCG8Iz+MHdr9eKrw=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- AKHIR LIBARARY JS -->

    <!-- JAVASCRIPT -->
    <script>
        $( function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'dd-M-yy',
            });
        });

        $(function() {
            $("#image").change(function(e) {
                const file = e.target.files[0];
                let url = window.URL.createObjectURL(file);
                $("#image_preview").attr('src', url);
                let fd = new FormData();
                fd.append('image', file);
                fd.append('id', $("#id").val());
                fd.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: '{{ route('pembeli.pengaturan.image') }}',
                    method: 'POST',
                    data: fd,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(res){
                        if(res.status == 200) {
                            // $("#profile_alert").html(showMessage('success', res.messages));
                            iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                title: 'Berhasil',
                                message: res.messages,
                                position: 'topRight'
                            });
                            $("#image").val('');
                        }
                    }
                });
            });

            $("#profile_form").submit(function(e) {
                e.preventDefault();
                let id = $("#id").val();
                $("#profile_btn").val('Silahkan tunggu..');
                $("#profile_btn").prop('disabled', true);
                $.ajax({
                    url: '{{ route('pembeli.pengaturan.update') }}',
                    method: 'POST',
                    data: $(this).serialize()+ `&id=${id}`,
                    dataType: 'json',
                    success: function(res){
                        if (res.status == 400) {
                            showError('name', res.messages.name);
                            showError('email', res.messages.email);
                            showError('telp', res.messages.telp);
                            showError('birth', res.messages.birth);
                            showError('gender', res.messages.gender);
                            $("#profile_btn").val('Perbarui Biodata');
                            $("#profile_btn").prop('disabled', false);
                        } else if (res.status == 200) {
                            // $("#profile_alert").html(showMessage('success', res.messages));
                            iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                title: 'Berhasil',
                                message: res.messages,
                                position: 'topRight'
                            });
                            $("#editProfile").modal('hide');
                            $("#profile_btn").val('Update Biodata Diri');
                            $("#profile_btn").prop('disabled', false);
                            window.setTimeout(function(){location.reload()},1000);
                        }
                    }
                });
            });

            $("#editPasswordForm").submit(function(e) {
                e.preventDefault();
                let id = $("#id").val();
                $("#password_btn").val('Silahkan tunggu..');
                $("#password_btn").prop('disabled', true);
                $.ajax({
                    url: '{{ route('pembeli.pengaturan.updatePassword') }}',
                    method: 'POST',
                    data: $(this).serialize()+ `&id=${id}`,
                    dataType: 'json',
                    success: function(res){
                        if (res.status == 400) {
                            showError('password', res.messages.password);
                            $("#password_btn").val('Ubah Password');
                            $("#password_btn").prop('disabled', false);
                        } else if (res.status == 200) {
                            // $("#profile_alert").html(showMessage('success', res.messages));
                            iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                title: 'Berhasil',
                                message: res.messages,
                                position: 'topRight'
                            });
                            $("#editPassword").modal('hide');
                            $("#password_btn").val('Ubah Password');
                            $("#password_btn").prop('disabled', false);
                            window.setTimeout(function(){location.reload()},1000);
                        }
                    }
                });
            });
        });

    </script>
@endsection
