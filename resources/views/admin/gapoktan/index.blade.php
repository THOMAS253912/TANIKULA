@extends('admin.template')
@section('title', 'Daftar Gapoktan')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- MULAI STYLE CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
        integrity="sha256-pODNVtK3uOhL8FUNWWvFQK0QoQoV3YA9wGGng6mbZ0E=" crossorigin="anonymous" />
    <!-- AKHIR STYLE CSS -->
    <style>
        .preview-image img {
            padding: 10px;
            width: 7rem;
            height: 7rem;
            -o-object-fit: cover;
            object-fit: cover;
            -o-object-position: center;
            object-position: center;
        }

        .preview-image-edit img {
            padding: 10px;
            width: 7rem;
            height: 7rem;
            -o-object-fit: cover;
            object-fit: cover;
            -o-object-position: center;
            object-position: center;
        }
    </style>
@endsection

@section('content')
    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="submit" class="btn btn-primary"  data-toggle="modal"
                                    data-target="#addEmployeeModal">Tambah @yield('title')</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="show_all_employees">
                                <h1 class="text-center text-secondary my-5">Memuat..</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Daftar Poktan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="add_employee_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="form-group my-2">
                            <label for="name">Nama Gapoktan</label>
                            <input type="text" name="name" id="add_name" class="form-control" placeholder="Nama Gapoktan">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label for="chairman">Ketua Gapoktan</label>
                            <input type="text" name="chairman" id="add_chairman" class="form-control" placeholder="Ketua Gapoktan">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="add_email" class="form-control" placeholder="Email">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="add_password" class="form-control" placeholder="Password">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="password">Konfirmasi Password</label>
                            <input type="password" id="cpassword" name="cpassword" class="form-control" placeholder="Konfirmasi Password" required>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="images">Unggah Bukti</label>
                            <small class="d-flex text-danger pb-1">*Unggah berupa bukti Gapoktan</small>
                            <div>
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade show active" id="home3" role="tabpanel"
                                        aria-labelledby="home-tab3">
                                        <div class="preview-image-edit"> </div>
                                    </div>
                                </div>
                            </div>
                            <input type="file" id="imagesEdit" name="images[]" multiple class="imagesEdit form-control" required>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        {{-- <div class="my-2 form-group">
                            <label for="is_active">Status Akun</label>
                            <div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="is_active" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" id="add_employee_btn" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Daftar Poktan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="modal-body p-4">
                        <div class="form-group my-2">
                            <label for="name">Nama Gapoktan</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nama Gapoktan">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label for="chairman">Ketua Gapoktan</label>
                            <input type="text" name="chairman" id="chairman" class="form-control" placeholder="Ketua Gapoktan">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="password">Password</label>
                            <div id="password_edit">

                            </div>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="password">Konfirmasi Password</label>
                            <div id="cpassword_edit">

                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="is_verified">Status Gapoktan</label>
                            <div id="is_verified">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" id="edit_employee_btn" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPhotoProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Unggah Bukti Gapoktan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="addPhotoProductForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="photoProduct" id="photoProduct">
                    <div class="modal-body p-4">
                        <input type="hidden" name="chairman" id="namaProduct" class="form-control" placeholder="Nama">
                        <div class="form-group">
                            <label for="image">Unggah Bukti</label>
                            <small class="d-flex text-danger pb-1">*Unggah berupa bukti Gapoktan</small>
                            <div>
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade show active" id="home3" role="tabpanel"
                                        aria-labelledby="home-tab3">
                                        <div class="preview-image"> </div>
                                        {{-- <img id="preview" class="img-fluid img-thumbnail image"
                                        src="{{ asset('stisla/assets/img/example-image.jpg') }}" alt="edukasi"
                                        style="width: 20rem; height: 10rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"> --}}
                                    </div>
                                </div>
                            </div>
                            <input type="file" id="images" name="images[]" multiple class="form-control" accept="image/*">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" id="addPhotoProductBtn" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewPhotoProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kelola Bukti Gapoktan</h5>
                    <button type="button" id="closeBtnPhoto" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group">
                        <div class="tab-content" id="myTabContent2">
                            <div class="tab-pane fade show active" id="home3" role="tabpanel"
                                aria-labelledby="home-tab3">
                                <div class="editFile"> </div>
                                {{-- <img id="preview" class="img-fluid img-thumbnail image"
                                        src="{{ asset('stisla/assets/img/example-image.jpg') }}" alt="edukasi"
                                style="width: 20rem; height: 10rem; -o-object-fit: cover; object-fit: cover;
                                -o-object-position: center; object-position: center;"> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- LIBARARY JS -->
    {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script> --}}
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
        $(function() {
            // Multiple images preview with JavaScript
            var multiImgPreview = function(input, imgPreviewPlaceholder) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder)
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#images').on('change', function() {
                multiImgPreview(this, 'div.preview-image');
            });

            // Multiple images preview with JavaScript
            var multiImgPreviewEdit = function(input, imgPreviewPlaceholder) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function(event) {
                        $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#imagesEdit').on('change', function() {
                multiImgPreviewEdit(this, 'div.preview-image-edit');
            });
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

            $("#viewPhotoProduct").on("hidden.bs.modal", function (e) {
                console.log("Modal hidden");
                $(".editFile").html("");
            });

            // add new employee ajax request
            $("#add_employee_form").submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                let TotalImages = $('#imagesEdit')[0].files.length; //Total Images
                let images = $('#imagesEdit')[0];
                for (let i = 0; i < TotalImages; i++) {
                    formData.append('images' + i, images.files[i]);
                }
                formData.append('TotalImages', TotalImages);

                $("#add_employee_btn").text('Tunggu..');
                $("#add_employee_btn").prop('disabled', true);
                $.ajax({
                url: '{{ route('admin-gapoktan-store') }}',
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('add_name', response.messages.name);
                        showError('add_chairman', response.messages.chairman);
                        showError('add_email', response.messages.email);
                        showError('add_password', response.messages.password);
                        showError('cpassword', response.messages.cpassword);
                        $("#add_employee_btn").text('Simpan');
                        $("#add_employee_btn").prop('disabled', false);
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Menambahkan!',
                            'Gapoktan Berhasil Ditambahkan!',
                            'success'
                        )
                        fetchAllEmployees();
                        $("#add_employee_btn").text('Simpan');
                        $("#add_employee_btn").prop('disabled', false);
                        $("#add_employee_form")[0].reset();
                        $("#addEmployeeModal").modal('hide');
                        window.setTimeout(function(){location.reload()},1000)
                    }
                }
                });
            });

            // edit employee ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                url: '{{ route('admin-gapoktan-edit') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#name").val(response.user.name);
                    $("#chairman").val(response.chairman);
                    $("#email").val(response.user.email);
                    $("#password_edit").html(
                        `<small class="d-flex text-danger pb-1">*Catatan:
                            <br>1. Jika tidak ingin ubah password biarkan kosong,
                            <br>2. Dan jika ingin ubah password, silahkan masukkan password.
                        </small>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="invalid-feedback">
                            </div>`);
                    $("#cpassword_edit").html(
                        `<input type="password" id="editcpassword" name="cpassword" class="form-control" placeholder="Konfirmasi Password">
                        <div class="invalid-feedback">
                            </div>`);
                    $("#is_verified").html(
                        `<label class="custom-switch">
                            <input type="checkbox" name="is_verified" ${response.is_verified ? 'checked' : ''} class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                        </label>`);
                    // $("#is_active").html(
                    //     `<label class="custom-switch">
                    //         <input type="checkbox" name="is_active" ${response.is_active ? 'checked' : ''} class="custom-switch-input">
                    //         <span class="custom-switch-indicator"></span>
                    //     </label>`);
                    $("#emp_id").val(response.id);
                    $("#user_id").val(response.user.id);
                }
                });
            });

            // update employee ajax request
            $("#edit_employee_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#edit_employee_btn").text('Tunggu..');
                $("#edit_employee_btn").prop('disabled', true);
                $.ajax({
                url: '{{ route('admin-gapoktan-update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('name', response.messages.name);
                        showError('chairman', response.messages.chairman);
                        showError('email', response.messages.email);
                        showError('password', response.messages.password);
                        showError('editcpassword', response.messages.cpassword);
                        $("#edit_employee_btn").text('Simpan');
                        $("#edit_employee_btn").prop('disabled', false);
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Memperbarui!',
                            'Gapoktan Berhasil Diperbarui!',
                            'success'
                        )
                        fetchAllEmployees();
                        $("#edit_employee_btn").text('Simpan');
                        $("#edit_employee_btn").prop('disabled', false);
                        $("#edit_employee_form")[0].reset();
                        $("#editEmployeeModal").modal('hide');
                    }
                }
                });
            });

            // delete employee ajax request
            $(document).on('click', '.deleteIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Cancel!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    url: '{{ route('admin-gapoktan-delete') }}',
                    method: 'delete',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire(
                        'Dihapus!',
                        'File Anda telah dihapus.',
                        'success'
                        )
                        fetchAllEmployees();
                    }
                    });
                }
                })
            });

            // edit employee ajax request
            $(document).on('click', '.viewPhotoProductIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                url: '{{ route('admin-certificate-viewPhoto') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var customHtml = '';
                    // if(response.success){
                    //     var response = response.success;
                    //     for (var i in response) {
                    //         customHtml = customHtml + '<div class="my-2 tab-pane fade show active" id="home2" role="tabpanel"aria-labelledby="home-tab2"><img id="preview" class="img-fluid img-thumbnail image" src="../storage/produk/'+ response[i].name +'" alt="edukasi" style="width: 22rem; height: 10rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"><a href="#" id="'+ response[i].id +'" class="text-danger mx-1 deletePhotoProduct">Hapus</a></div>';
                    //     }
                    //     $('.editFile').html(customHtml)
                    // }
                    $.each(response, function (i, item) {
                        customHtml = customHtml + '<div class="my-2 tab-pane fade show active" id="home2" role="tabpanel"aria-labelledby="home-tab2"><img id="preview" class="img-fluid img-thumbnail image" src="../storage/sertifikat/'+ response[i].evidence +'" alt="'+response[i].evidence+'" style="width: 22rem; height: 10rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"><a href="#" id="'+ response[i].id +'" class="text-danger mx-1 deletePhotoProduct">Hapus</a></div>';
                        })
                    $('.editFile').append(customHtml);
                }
                });
            });

            // delete employee ajax request
            $(document).on('click', '.deletePhotoProduct', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Cancel!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    url: '{{ route('admin-certificate-deletePhoto') }}',
                    method: 'delete',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire(
                        'Dihapus!',
                        'File Anda telah dihapus.',
                        'success'
                        )
                        $("#viewPhotoProduct").modal('hide');
                        window.location.reload();
                    }
                    });
                }
                })
            });

            // edit employee ajax request
            $(document).on('click', '.addPhotoProductIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                url: '{{ route('admin-certificate-addPhoto') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#namaProduct").val(response.chairman);
                    $("#id").val(response.id);
                }
                });
            });

            // update employee ajax request
            $("#addPhotoProductForm").submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                let TotalImages = $('#images')[0].files.length; //Total Images
                let images = $('#images')[0];
                for (let i = 0; i < TotalImages; i++) {
                    formData.append('images' + i, images.files[i]);
                }
                formData.append('TotalImages', TotalImages);

                $("#addPhotoProductBtn").text('Tunggu..');
                $("#addPhotoProductBtn").prop('disabled', true);
                $.ajax({
                url: '{{ route('admin-certificate-addPhotoProduct') }}',
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('images', response.messages.images);
                        $("#addPhotoProductForm")[0].reset();
                        $('.preview-image-edit').html("");
                        $("#addPhotoProductBtn").text('Simpan');
                        $("#addPhotoProductBtn").prop('disabled', false);
                    } else if (response.status == 200){
                        Swal.fire(
                            'Menambahkan!',
                            'Foto Produk Berhasil ditambahkan!',
                            'success'
                        )
                        fetchAllEmployees();
                        $("#addPhotoProduct").modal('hide');
                        $("#addPhotoProductForm")[0].reset();
                        $('.preview-image-edit').html("");
                        $("#addPhotoProductBtn").text('Simpan');
                        $("#addPhotoProductBtn").prop('disabled', false);
                        window.setTimeout(function(){location.reload()},1000)
                    } else if (response.status == 401) {
                        Swal.fire(
                            'Gagal!',
                            'Silahkan coba lagi!',
                            'warning'
                        )
                        fetchAllEmployees();
                        $("#addPhotoProduct").modal('hide');
                        $("#addPhotoProductForm")[0].reset();
                        $('.preview-image-edit').html("");
                        $("#addPhotoProductBtn").text('Simpan');
                        $("#addPhotoProductBtn").prop('disabled', false);
                        window.setTimeout(function(){location.reload()},1000)
                    }
                }
                });
            });

            // fetch all employees ajax request
            fetchAllEmployees();

            function fetchAllEmployees() {
                $.ajax({
                url: '{{ route('admin-gapoktan-fetchAll') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_employees").html(response);
                    $("table").DataTable({
                        order: [0, 'asc']
                    });
                }
                });
            }
        });

    </script>
@endsection
