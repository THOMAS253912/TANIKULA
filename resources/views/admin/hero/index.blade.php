@extends('admin.template')
@section('title', 'Hero')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- MULAI STYLE CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
        integrity="sha256-pODNVtK3uOhL8FUNWWvFQK0QoQoV3YA9wGGng6mbZ0E=" crossorigin="anonymous" />
    <!-- AKHIR STYLE CSS -->
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Hero</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="add_employee_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-lg my-2">
                                <label for="name">Nama Hero</label>
                                <input type="text" name="name" id="add_name" class="nameCheck form-control" placeholder="Nama">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="file">Unggah Foto Hero</label>
                            <small class="d-flex text-danger pb-1">*Unggah berupa foto</small>
                            <div class="">
                                <div class="tab-content my-2" id="myTabContent2">
                                    <div class="tab-pane fade show active" id="home3" role="tabpanel"
                                        aria-labelledby="home-tab3">
                                        <img id="addPreview" class="img-fluid img-thumbnail image"
                                        src="{{ asset('stisla/assets/img/example-image.jpg') }}" alt="edukasi"
                                        style="width: 20rem; height: 10rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                    </div>
                                </div>
                            </div>
                            <input type="file" name="image" id="addFiles" class="form-control" accept="image/*">
                            <div class="invalid-feedback">
                            </div>
                        </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Hero</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="modal-body p-4">
                        <div class="row my-2">
                            <div class="col-lg">
                                <label for="name">Nama Hero</label>
                                <input type="text" name="name" id="name" class="form-control nameCheck" placeholder="Nama">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="file">Unggah Foto Hero</label>
                            <small class="d-flex text-danger pb-1">*Unggah berupa foto</small>
                            <div class="mt-2">
                                <div class="tab-content editFile my-2" id="myTabContent2">

                                </div>
                            </div>
                            <input type="file" name="image" id="files" accept="image/*, video/*" class="form-control">
                            <div class="invalid-feedback">
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
            $('#addFiles').on('change', function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = viewer.load;
                reader.readAsDataURL(file);
            });

            var viewer = {
                load : function(e) {
                    $('#addPreview').attr('src', e.target.result)
                    $('#addVideoPreview').attr('src', e.target.result)
                }
            }
        });

        $(function() {

            $(".modal").on("hidden.bs.modal", function (e) {
                console.log("Modal hidden");
                $("#home3").html(`<img id="addPreview" class="img-fluid img-thumbnail image"
                                        src="../stisla/assets/img/example-image.jpg" alt="edukasi"
                                        style="width: 20rem; height: 10rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">`);
            });

            // add new employee ajax request
            $("#add_employee_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_employee_btn").text('Tunggu..');
                $("#add_employee_btn").prop('disabled', true);
                $.ajax({
                url: '{{ route('admin-hero-store') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('add_name', response.messages.name);
                        showError('addFiles', response.messages.image);
                        $("#add_employee_btn").text('Simpan');
                        $("#add_employee_btn").prop('disabled', false);
                    }
                    else if (response.status == 200) {
                        Swal.fire(
                            'Menambahkan!',
                            'Hero Berhasil Ditambahkan!',
                            'success'
                        )
                        fetchAllEmployees();
                        $("#add_employee_form")[0].reset();
                        $("#addEmployeeModal").modal('hide');
                        $("#add_employee_btn").text('Simpan');
                        $("#add_employee_btn").prop('disabled', false);
                    }
                }
                });
            });

            // edit employee ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                url: '{{ route('admin-hero-edit') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#name").val(response.name);
                    if (response.image) {
                        $(".editFile").html(
                            `<div class="tab-pane fade show active" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <img id="preview" class="img-fluid img-thumbnail image"
                                src="../storage/hero/${response.image}" alt="edukasi"
                                style="width: 20rem; height: 10rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                            </div>
                        `);
                    } else {
                        $(".editFile").html(
                            `<div class="tab-pane fade show active" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <img id="preview" class="img-fluid img-thumbnail image"
                                src="../stisla/assets/img/example-image.jpg" alt="edukasi"
                                style="width: 20rem; height: 10rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                            </div>
                        `);
                    }
                    $("#emp_id").val(response.id);
                    $("#emp_avatar").val(response.file);
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
                url: '{{ route('admin-hero-update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('name', response.messages.name);
                        $("#edit_employee_btn").text('Simpan');
                        $("#edit_employee_btn").prop('disabled', false);
                    }
                    else if (response.status == 200) {
                        Swal.fire(
                            'Memperbarui!',
                            'Hero Berhasil Diperbarui!',
                            'success'
                        )
                        fetchAllEmployees();
                        $("#edit_employee_form")[0].reset();
                        $("#editEmployeeModal").modal('hide');
                        $("#edit_employee_btn").text('Simpan');
                        $("#edit_employee_btn").prop('disabled', false);
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
                    url: '{{ route('admin-hero-delete') }}',
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

            // fetch all employees ajax request
            fetchAllEmployees();

            function fetchAllEmployees() {
                $.ajax({
                url: '{{ route('admin-hero-fetchAll') }}',
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

        $(function() {
            $('#files').on('change', function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = viewer.load;
                reader.readAsDataURL(file);
            });

            var viewer = {
                load : function(e) {
                    $('#preview').attr('src', e.target.result)
                    $('#videoPreview').attr('src', e.target.result)
                }
            }
        });

    </script>
@endsection
