@extends('support.template2')
@section('title', 'Biodata Support')

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
@endsection

@section('content')

    <!-- Modal -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="editPasswordForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="form-group my-2">
                            <label for="password">Password</label>
                            <small class="d-flex text-danger pb-1">*Catatan:
                                <br>1. Jika tidak ingin ubah password biarkan kosong,
                                <br>2. Dan jika ingin ubah password, silahkan masukkan password.
                            </small>
                            <input type="password"  id="password" name="password" class="form-control" placeholder="Password">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" id="password_btn" class="btn btn-primary">Ubah Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Biodata Support</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="profile_form">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="form-group my-2">
                            <label for="name">Nama Support</label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ $userInfo->user->name }}">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label class="m-0" for="email">Email</label>
                            <p class="m-1 small text-danger">*gunakan email aktif</p>
                            <input type="text" class="form-control" name="email" id="email"
                                value="{{ $userInfo->user->email }}">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label for="phone">No Handphone</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span>+62</span>
                                    </div>
                                </div>
                                <input type="number" name="phone" id="phone" value="{{ $userInfo->phone}}"
                                    class="form-control phone-number">
                            </div>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label class="col-form-label" for="provinsi">Provinsi</label>
                            @php
                            $provinces = new App\Http\Controllers\Pages\DependantDropdownController;
                            $provinces = $provinces->provinces();
                            @endphp
                            <select class="form-control" name="province_id" id="provinsi">
                                <option disabled selected>==Pilih Salah Satu==</option>
                                @foreach ($provinces as $item)
                                <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group my-2">
                            <label class="col-form-label" for="kota">Kabupaten / Kota</label>
                            <select class="form-control" name="city_id" id="kota">
                                <option disabled selected>==Pilih Salah Satu==</option>
                            </select>
                        </div>
                        <div class="form-group my-2">
                            <label class="col-form-label" for="kecamatan">Kecamatan</label>
                            <select class="form-control" name="district_id" id="kecamatan">
                                <option disabled selected>==Pilih Salah Satu==</option>
                            </select>
                        </div>
                        <div class="form-group my-2">
                            <label class="col-form-label" for="desa">Desa</label>
                            <select class="form-control" name="village_id" id="desa">
                                <option disabled selected>==Pilih Salah Satu==</option>
                            </select>
                        </div>
                        <div class="form-group my-2">
                            <label for="street">Jalan / Gang</label>
                            <input type="text" class="form-control" name="street" id="street"
                                value="{{ $userInfo->street }}">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label for="number">Nomor</label>
                            <input type="number" class="form-control" name="number" id="number"
                                value="{{ $userInfo->number }}">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" id="profile_btn" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="section">
                <div class="section-body">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="card">
                                <div class="mt-4 card-body row">
                                    <div class="col-12 col-md-12 col-lg-5">
                                        <div id="profile_alert"></div>
                                        <div class="card align-items-center justify-content-center">
                                            <div class="card-body">
                                                <div class="chocolat-parent">
                                                    <a href="" class="chocolat-image" title="{{ $userInfo->user->name }}">
                                                        <div>
                                                            @if ($userInfo->image)
                                                            <img alt="image" id="image_preview"
                                                                src="../storage/profile/{{ $userInfo->image }}"
                                                                class="img-fluid img-thumbnail">
                                                            @else
                                                            <img alt="image" id="image_preview"
                                                                src="{{ asset('stisla/assets/img/example-image.jpg') }}"
                                                                class="img-fluid img-thumbnail">
                                                            @endif

                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="pt-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" accept="image/*"
                                                            id="image" name="image">
                                                        <label class="custom-file-label" style="font-size: 14px"
                                                            for="image">Ubah Profile</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_id" id="user_id" value="{{ $userInfo->id }}">
                                    <div class="col-12 col-md-12 col-lg-7">
                                        <div>
                                            <div class="pb-2">
                                                <h4 class="text-center">Biodata Support</h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-3">Nama</th>
                                                            <th>{{ $userInfo->user->name }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>Email</th>
                                                            <td>
                                                                {{ $userInfo->user->email }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>No Hp</th>
                                                            <td>
                                                                @if ($userInfo->phone)
                                                                    (+62) {{ $userInfo->phone }}
                                                                @else
                                                                    <span class="text-danger">Belum diisi</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Alamat</th>
                                                            <td class="text-capitalize">
                                                                @if ($userInfo->street && $userInfo->number)
                                                                    {{ $userInfo->street }}, No {{ $userInfo->number }}.
                                                                    @if ($userInfo->village_id &&
                                                                        $userInfo->district_id && $userInfo->city_id &&
                                                                        $userInfo->province_id != null)
                                                                        {{ $userInfo->village->name }}, Kecamatan
                                                                        {{ $userInfo->district->name }},
                                                                        {{ $userInfo->city->name }}, Provinsi
                                                                        {{ $userInfo->province->name }}.
                                                                    @endif
                                                                @else
                                                                    <span class="text-danger">Belum diisi</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="card-footer bg-white row align-items-center justify-content-end mb-3">
                                                <input type="button" value="Ubah Password"
                                                    class="btn btn-light shadow-none m-1" data-toggle="modal" data-target="#editEmployeeModal">
                                                <input type="button" value="Ubah Biodata"
                                                    class="btn btn-primary shadow-none m-1" data-toggle="modal" data-target="#exampleModal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                dateFormat: 'yy-mm-dd'
            });
        });

        function onChangeSelect(url, id, name) {
            // send ajax request to get the cities of the selected province and append to the select tag
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id
                },
                success: function (data) {
                    $('#' + name).empty();
                    $('#' + name).append('<option>==Pilih Salah Satu==</option>');

                    $.each(data, function (key, value) {
                        $('#' + name).append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }

        $(function () {
            $('#provinsi').on('change', function () {
                onChangeSelect('{{ route("cities") }}', $(this).val(), 'kota');
            });
            $('#kota').on('change', function () {
                onChangeSelect('{{ route("districts") }}', $(this).val(), 'kecamatan');
            })
            $('#kecamatan').on('change', function () {
                onChangeSelect('{{ route("villages") }}', $(this).val(), 'desa');
            })
        });

        $(function() {
            $("#image").change(function(e) {
                const file = e.target.files[0];
                let url = window.URL.createObjectURL(file);
                $("#image_preview").attr('src', url);
                let fd = new FormData();
                fd.append('image', file);
                fd.append('user_id', $("#user_id").val());
                fd.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: '{{ route('support.pengaturan.image') }}',
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
                let id = $("#user_id").val();
                $("#profile_btn").val('Silahkan tunggu..');
                $("#profile_btn").prop('disabled', true);
                $.ajax({
                    url: '{{ route('support.pengaturan.update') }}',
                    method: 'POST',
                    data: $(this).serialize()+ `&id=${id}`,
                    dataType: 'json',
                    success: function(res){
                        if (res.status == 400) {
                            showError('name', res.messages.name);
                            showError('email', res.messages.email);
                            showError('chairman', res.messages.chairman);
                            showError('phone', res.messages.phone);
                            showError('provinsi', res.messages.province_id);
                            showError('kota', res.messages.city_id);
                            showError('kecamatan', res.messages.district_id);
                            showError('desa', res.messages.village_id);
                            showError('street', res.messages.street);
                            showError('number', res.messages.number);
                            $("#profile_btn").val('Perbarui Biodata');
                            $("#profile_btn").prop('disabled', false);
                        } else if (res.status == 200) {
                            // $("#profile_alert").html(showMessage('success', res.messages));
                            iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                title: 'Berhasil',
                                message: res.messages,
                                position: 'topRight'
                            });
                            $("#profile_btn").val('Update Biodata Diri');
                            $("#profile_btn").prop('disabled', false);
                            window.location.reload();
                        }
                    }
                });
            });

            $("#editPasswordForm").submit(function(e) {
                e.preventDefault();
                let id = $("#user_id").val();
                $("#password_btn").val('Silahkan tunggu..');
                $("#password_btn").prop('disabled', true);
                $.ajax({
                    url: '{{ route('support.pengaturan.updatePassword') }}',
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
                            $("#profile_btn").val('Ubah Password');
                            $("#profile_btn").prop('disabled', false);
                            window.location.reload();
                        }
                    }
                });
            });
        });
    </script>
@endsection
