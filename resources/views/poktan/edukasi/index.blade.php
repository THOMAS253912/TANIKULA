@extends('poktan.template')
@section('title', 'Edukasi')

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
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Poktan</div>
                    <div class="breadcrumb-item active"><a href="#">@yield('title')</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <button type="button" style="border-radius: 5px;" class="btn btn btn-primary shadow-none py-1" data-toggle="modal"
                                    data-target="#addEmployeeModal">Tambah
                                    @yield('title')</button>
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Edukasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="add_employee_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="form-group my-2">
                            <label for="title">Judul</label>
                            <input type="text" id="add_title" name="title" class="titleCheck form-control" placeholder="Judul"
                                required>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label>Kategori Edukasi</label>
                            @if ($category->count() > 0)
                            <select class="form-control select2" id="add_category_education_id" name="category_education_id" required>
                                <option selected disabled>Pilih Kategori</option>
                                @foreach ($category as $item)
                                    @if ( old('category_education_id') == $item->id )
                                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @else
                            <select class="form-control select2" disabled >
                                    <option selected disabled>Tidak ada kategori</option>
                            </select>
                            @endif
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="desc">Deskripsi</label>
                            <textarea class="form-control" style="height: 8rem" id="add_desc" name="desc" rows="3" required placeholder="Deskripsi"></textarea>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="file">Unggah File</label>
                            <small class="d-flex text-danger pb-1">*Unggah berupa foto dan video</small>
                            <div>
                                <ul class="nav nav-pills" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3"
                                            role="tab" aria-controls="home" aria-selected="true">Foto</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3"
                                            role="tab" aria-controls="profile" aria-selected="false">Video</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade show active" id="home3" role="tabpanel"
                                        aria-labelledby="home-tab3">
                                        <img id="addPreview" class="img-fluid img-thumbnail image"
                                        src="{{ asset('stisla/assets/img/example-image.jpg') }}" alt="edukasi"
                                        style="width: 20rem; height: 10rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                    </div>
                                    <div class="tab-pane fade" id="profile3" role="tabpanel"
                                        aria-labelledby="profile-tab3">
                                        <video id="addVideoPreview" class="img-fluid img-thumbnail image" src=""
                                        style="width: 20rem; height: 10rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                        controls></video>
                                    </div>
                                </div>
                            </div>
                            <input type="file" name="file" id="addFiles" class="form-control" accept="image/*, video/*" required>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn shadow-none border" style="background: #FFFACD;" data-dismiss="modal">Kembali</button>
                        <button type="submit" id="add_employee_btn" style="background: #16A085; color: white" class="btn shadow-none border">Simpan</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Edukasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <input type="hidden" name="emp_avatar" id="emp_avatar">
                    <div class="modal-body p-4">
                        <div class="form-group my-2">
                            <label for="title">Judul</label>
                            <input type="text" name="title" id="title" class="form-control titleCheck" placeholder="Judul" required>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label>Kategori Edukasi</label>
                            @if ($category->count() > 0)
                            <select class="form-control select2" id="category_education_id" name="category_education_id" required>
                                <option selected disabled>Pilih Kategori</option>
                                @foreach ($category as $item)
                                    @if ( old('category_education_id') == $item->id )
                                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @else
                            <select class="form-control select2" disabled >
                                <option selected disabled>Tidak ada kategori</option>
                            </select>
                            @endif
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="desc">Deskripsi</label>
                            <textarea class="form-control" style="height: 8rem" name="desc" id="desc" rows="3" required placeholder="Deskripsi"></textarea>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="file">Unggah File</label>
                            <small class="d-flex text-danger pb-1">*Unggah berupa foto dan video</small>
                            <div class="mt-2">
                                <ul class="nav nav-pills" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2"
                                            role="tab" aria-controls="home" aria-selected="true">Foto</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2"
                                            role="tab" aria-controls="profile" aria-selected="false">Video</a>
                                    </li>
                                </ul>
                                <div class="tab-content editFile" id="myTabContent2">

                                </div>
                            </div>
                            <input type="file" name="file" id="files" accept="image/*, video/*" class="form-control">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn shadow-none border" style="background: #FFFACD;" data-dismiss="modal">Kembali</button>
                        <button type="submit" id="edit_employee_btn" style="background: #16A085; color: white" class="btn shadow-none border">Simpan</button>
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
        $('.titleCheck').change(function(e) {
            $.get('{{ route('poktan-edukasi-checkSlug') }}',
            { 'title': $(this).val() },
                function( data ) {
                    $('.slugCheck').val(data.slug);
                }
            );
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

            // add new employee ajax request
            $("#add_employee_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_employee_btn").text('Tunggu..');
                $("#add_employee_btn").prop('disabled', true);
                $.ajax({
                url: '{{ route('poktan-edukasi-store') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('add_title', response.messages.title);
                        showError('add_category_education_id', response.messages.category_education_id);
                        showError('add_desc', response.messages.desc);
                        showError('addFiles', response.messages.file);
                        $("#add_employee_btn").text('Simpan');
                        $("#add_employee_btn").prop('disabled', false);
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Menambahkan!',
                            'Edukasi Berhasil Ditambahkan!',
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
                url: '{{ route('poktan-edukasi-edit') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#title").val(response.title);
                    $("#category_education_id").val(response.category_education_id);
                    $("#date").val(response.date);
                    $("#desc").val(response.desc);
                    if (response.file) {
                        $(".editFile").html(
                            `<div class="tab-pane fade show active" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <img id="preview" class="img-fluid img-thumbnail image"
                                src="../storage/edukasi/${response.file}" alt="edukasi"
                                style="width: 20rem; height: 10rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                            </div>
                            <div class="tab-pane fade" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">
                                <video id="videoPreview" class="img-fluid img-thumbnail image" src="../storage/edukasi/${response.file}"
                                style="width: 20rem; height: 10rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                controls></video>
                            </div>`);
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
                url: '{{ route('poktan-edukasi-update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('title', response.messages.title);
                        showError('category_education_id', response.messages.category_education_id);
                        showError('desc', response.messages.desc);
                        $("#edit_employee_btn").text('Simpan');
                        $("#edit_employee_btn").prop('disabled', false);
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Memperbarui!',
                            'Edukasi Berhasil Diperbarui!',
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
                    url: '{{ route('poktan-edukasi-delete') }}',
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
                url: '{{ route('poktan-edukasi-fetchAll') }}',
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
