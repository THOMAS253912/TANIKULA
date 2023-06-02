@extends('costumer.template')
@section('title','Daftar Alamat')

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
        /* 4.3 Page */
    .page-error {
        height: 100%;
        width: 100%;
        padding-top: 60px;
        padding-bottom: 60px;
        text-align: center;
        display: table;
    }

    .page-error .page-inner {
        display: table-cell;
        width: 100%;
        vertical-align: middle;
    }

    .page-error .page-description {
        padding-top: 30px;
        font-size: 18px;
        font-weight: 400;
        color: color: var(--primary);;
    }

    @media (max-width: 575.98px) {
        .page-error {
            padding-top: 0px;
        }
    }
    </style>
@endsection

@section('content')
<div class="container-fluid px-2 px-md-4 mb-5">
    <div class="page-header min-height-300 border-radius-xl mt-4"
        style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <span class="mask bg-primary opacity-6"></span>
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
            <input type="hidden" name="id" id="id" value="{{ $userInfo->id }}">
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
        <div class="row">
            <div class="d-flex flex-column-reverse flex-md-row justify-content-between align-items-md-center mt-4">
                <div>
                    <div class="pt-2 input-group items-align-center justify-content-center">
                        <div class="form-outline">
                            <input class="typeahead form-control px-3 border" name="search_data" id="search_data"
                                placeholder="Cari alamat ..." style="font-size: 15px; border-color: #16A085;"
                                type="search" autocomplete="off">
                        </div>
                        <button type="button" name="search" id="search" class="btn" style="background-color: #16A085; color: white">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-light border" data-bs-toggle="modal"
                        data-bs-target="#TambahAlamat" data-bs-dismiss="modal">
                        Tambah Alamat Baru
                    </button>
                </div>
            </div>
            <div class="col-12" id="show_all_employees">
                <div id="app">
                    <section class="section">
                        <div class="container">
                            <div class="page-error">
                                <div class="page-inner">
                                    <div class="page-description">
                                        Silahkan tunggu ..
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Alamat -->
<div class="modal fade" id="EditAlamat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <style>
        #style-1::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px #16A085;
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        #style-1::-webkit-scrollbar
        {
            width: 12px;
            background-color: #F5F5F5;
        }

        #style-1::-webkit-scrollbar-thumb
        {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px #16A085;
            background-color: #16A085;
        }
    </style>
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Alamat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="style-1">
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <input type="hidden" name="emp_id" id="emp_id">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nama
                                Penerima:</label>
                            <input type="text" name="recipients_name" id="recipients_name" class="form-control border px-3">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">No. Hp:</label>
                            <input type="tel" name="telp" id="telp" class="form-control border px-3">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="row mb-3 ">
                            <div class="col-6">
                                <label for="recipient-name" class="col-form-label">Label Alamat:</label>
                                <input type="text" name="address_label" id="address_label" class="form-control border px-3">
                                <small class="d-flex text-danger pb-1">*Contoh: Rumah, Kantor</small>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label class="col-form-label" for="provinsi">Provinsi</label>
                                @php
                                    $provinces = new App\Http\Controllers\Pages\DependantDropdownController;
                                    $provinces = $provinces->provinces();
                                @endphp
                                <select class="form-control border px-3" name="province_id" id="provinsi" required>
                                    <option selected disabled>==Pilih Salah Satu==</option>
                                    @foreach ($provinces as $item)
                                    <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 ">
                            <div class="form-group col-6">
                                <label class="col-form-label" for="kota">Kabupaten / Kota</label>
                                <select class="form-control border px-3" name="city_id" id="kota" required>
                                    <option selected disabled>==Pilih Salah Satu==</option>
                                </select>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label class="col-form-label" for="kecamatan">Kecamatan</label>
                                <select class="form-control border px-3" name="district_id" id="kecamatan" required>
                                    <option selected disabled>==Pilih Salah Satu==</option>
                                </select>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group col-8">
                                <label class="col-form-label" for="desa">Desa</label>
                                <select class="form-control border px-3" name="village_id" id="desa" required>
                                    <option selected disabled>==Pilih Salah Satu==</option>
                                </select>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="recipient-name" class="col-form-label">Kode Pos:</label>
                                <input type="text" name="postal_code" id="postal_code" class="form-control border px-3">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Alamat Lengkap:</label>
                            <textarea class="form-control border px-3" name="complete_address" id="complete_address" rows="3"
                                id="message-text"></textarea>
                            <div class="invalid-feedback">
                                </div>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Catatan untuk
                                kurir:</label>
                            <small class="d-flex text-danger pb-1">*Warna rumah, patokan, pesan khusus, dll.</small>
                            <input type="text" name="note_for_courier" id="note_for_courier" class="form-control border px-3">
                            <div class="invalid-feedback">
                                </div>
                        </div>
                        <div class="mb-3">
                            <div class="px-3 input-group-text bg-white" id="main_address">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" id="edit_employee_btn" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Alamat -->
<div class="modal fade" id="TambahAlamat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Alamat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="style-2">
                <form action="#" method="POST" id="add_employee_form" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div>
                        <div class="mb-3">
                            <label for="recipients_name" class="col-form-label">Nama Penerima:</label>
                            <input type="text" name="recipients_name" class="form-control border px-3" id="add_recipients_name">
                            <div class="invalid-feedback">
                                </div>
                        </div>
                        <div class="mb-3">
                            <label for="telp" class="col-form-label">No. Hp:</label>
                            <input type="tel" name="telp" id="add_telp" class="form-control border px-3">
                            <div class="invalid-feedback">
                                </div>
                        </div>
                        <div class="row mb-3 ">
                            <div class="col-6">
                                <label for="recipient-name" class="col-form-label">Label Alamat:</label>
                                <input type="text" id="add_address_label" name="address_label" class="form-control border px-3">
                                <small class="d-flex text-danger pb-1">*Contoh: Rumah, Kantor</small>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label class="col-form-label" for="provinsi">Provinsi</label>
                                @php
                                    $provinces = new App\Http\Controllers\Pages\DependantDropdownController;
                                    $provinces = $provinces->provinces();
                                @endphp
                                <select class="form-control border px-3" name="province_id" id="province_id" required>
                                    <option selected disabled>==Pilih Salah Satu==</option>
                                    @foreach ($provinces as $item)
                                    <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 ">
                            <div class="form-group col-6">
                                <label class="col-form-label" for="kota">Kabupaten / Kota</label>
                                <select class="form-control border px-3" name="city_id" id="city_id" required>
                                    <option selected disabled>==Pilih Salah Satu==</option>
                                </select>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label class="col-form-label" for="kecamatan">Kecamatan</label>
                                <select class="form-control border px-3" name="district_id" id="district_id" required>
                                    <option selected disabled>==Pilih Salah Satu==</option>
                                </select>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group col-8">
                                <label class="col-form-label" for="desa">Desa</label>
                                <select class="form-control border px-3" name="village_id" id="village_id" required>
                                    <option selected disabled>==Pilih Salah Satu==</option>
                                </select>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="recipient-name" class="col-form-label">Kode Pos:</label>
                                <input type="text" id="add_postal_code" name="postal_code" class="form-control border px-3">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="complete_address" class="col-form-label">Alamat Lengkap:</label>
                            <textarea class="form-control border px-3" id="add_complete_address" name="complete_address" rows="3"
                                id="message-text"></textarea>
                            <div class="invalid-feedback">
                                </div>
                        </div>
                        <div class="mb-3">
                            <label for="note_for_courier" class="col-form-label">Catatan untuk kurir:</label>
                            <small class="d-flex text-danger pb-1">*Warna rumah, patokan, pesan khusus, dll.</small>
                            <input type="text" name="note_for_courier" class="form-control border px-3">
                            <div class="invalid-feedback">
                                </div>
                        </div>
                        <div class="mb-3">
                            <div class="px-3 input-group-text bg-white">
                                <input class="form-check-input mt-0" type="checkbox" name="main_address">
                                <span class="px-3">Jadikan Alamat Utama</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" id="add_employee_btn" class="btn btn-primary">Simpan</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <!-- AKHIR LIBARARY JS -->

    <!-- JAVASCRIPT -->
    <script>
        var path = "{{ route('alamat.autocomplete')  }}";
        $('input.typeahead').typeahead({
            source: function (query, process) {
                return $.get(path, {
                    term: query
                }, function (data) {
                    return process(data);
                });
            }
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

        $(function () {
            $('#province_id').on('change', function () {
                onChangeSelect('{{ route("cities") }}', $(this).val(), 'city_id');
            });
            $('#city_id').on('change', function () {
                onChangeSelect('{{ route("districts") }}', $(this).val(), 'district_id');
            })
            $('#district_id').on('change', function () {
                onChangeSelect('{{ route("villages") }}', $(this).val(), 'village_id');
            })
        });

    //CSRF TOKEN PADA HEADER
    //Script ini wajib krn kita butuh csrf token setiap kali mengirim request post, patch, put dan delete ke server
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
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

        // add new employee ajax request
        $("#add_employee_form").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $("#add_employee_btn").text('Tunggu..');
                $("#add_employee_btn").prop('disabled', true);
                $.ajax({
                url: '{{ route('add.pembeli.alamat') }}',
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('add_recipients_name', response.messages.recipients_name);
                        showError('add_telp', response.messages.telp);
                        showError('add_address_label', response.messages.address_label);
                        showError('province_id', response.messages.province_id);
                        showError('city_id', response.messages.city_id);
                        showError('district_id', response.messages.district_id);
                        showError('village_id', response.messages.village_id);
                        showError('add_postal_code', response.messages.postal_code);
                        showError('add_complete_address', response.messages.complete_address);
                        // showError('note_for_courier', response.messages.note_for_courier);
                        $("#add_employee_btn").text('Simpan');
                        $("#add_employee_btn").prop('disabled', false);
                    } else if (response.status == 200){
                        Swal.fire(
                            'Menambahkan!',
                            'Alamat Berhasil Ditambahkan!',
                            'success'
                        )
                        fetchAllEmployees();
                        $("#TambahAlamat").modal('hide');
                        $("#add_employee_form")[0].reset();
                        $("#add_employee_btn").text('Simpan');
                        $("#add_employee_btn").prop('disabled', false);
                    }
                }
            });
        });

        // edit employee ajax request
        $(document).on('click', '.editAlamat', function (e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ route('edit.pembeli.alamat') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    $("#recipients_name").val(response.recipients_name);
                    $("#telp").val(response.telp);
                    $("#address_label").val(response.address_label);
                    $("#city").val(response.city);
                    $("#postal_code").val(response.postal_code);
                    $("#complete_address").val(response.complete_address);
                    $("#note_for_courier").val(response.note_for_courier);
                    $("#main_address").html(`
                        <input class="form-check-input mt-0" type="checkbox" ${response.main_address ? 'checked' : ''} name="main_address">
                        <span class="px-3">Jadikan Alamat Utama</span>
                    `);
                    $("#emp_id").val(response.id);
                }
            });
        });

        // update employee ajax request
        $("#edit_employee_form").submit(function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            $("#edit_employee_btn").text('Tunggu..');
            $("#edit_employee_btn").prop('disabled', true);
            $.ajax({
                url: '{{ route('update.pembeli.alamat') }}',
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 400) {
                        showError('recipients_name', response.messages.recipients_name);
                        showError('telp', response.messages.telp);
                        showError('address_label', response.messages.address_label);
                        showError('postal_code', response.messages.postal_code);
                        showError('complete_address', response.messages.complete_address);
                        // showError('note_for_courier', response.messages.note_for_courier);
                        $("#edit_employee_btn").text('Simpan');
                        $("#edit_employee_btn").prop('disabled', false);
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Memperbarui!',
                            'Alamat Berhasil diperbarui!',
                            'success'
                        )
                        fetchAllEmployees();
                        $("#EditAlamat").modal('hide');
                        $("#edit_employee_form")[0].reset();
                        $("#edit_employee_btn").text('Simpan');
                        $("#edit_employee_btn").prop('disabled', false);
                    }
                }
            });
        });

         // delete employee ajax request
        $(document).on('click', '.updateMainAddress', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Ingin menjadikan alamat utama!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Jadikan alamat utama!',
            cancelButtonText: 'Kembali!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url: '{{ route('updateMainAddress.pembeli.alamat') }}',
                method: 'POST',
                data: {
                    id: id,
                    _token: csrf
                },
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire(
                            'Berhasil!',
                            'Berhasil menjadikan alamat utama!',
                            'success'
                        )
                        window.setTimeout(function(){location.reload()},1000)
                    }
                }
                });
            }
            })
        });

        // fetch all employees ajax request
        fetchAllEmployees();

        function fetchAllEmployees(search_data = '') {
            $.ajax({
                url: '{{ route('pembeli.alamat.fetchAll') }}',
                data:{search_data:search_data},
                method: 'get',
                success: function(response) {
                    $("#show_all_employees").html(response);
                }
            });
        }

        $('#search').click(function(){
            var search_data = $('#search_data').val();
            if(search_data != '')
            {
                $('table').DataTable().destroy();
                fetchAllEmployees(search_data);
            }
            else
            {
                fetchAllEmployees();
            }
        });
    });
    </script>
@endsection
