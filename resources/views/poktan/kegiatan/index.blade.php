@extends('poktan.template')
@section('title', 'Kegiatan')

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
        .datepicker {
            z-index: 1600 !important; /* has to be larger than 1050 */
        }
        /* STYLE CSS */
        .costum-color {
            background-image: linear-gradient(195deg, #16A085 0%, #16A085 100%);
        }
    </style>
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
                            <div class="card-body" id="tabs">
                                <div class="card-body px-0 pb-2">
                                    <ul class="mx-3 p-1 nav bg-white rounded nav-fill">
                                        <li class="nav-item">
                                            <a class="nav-link addActivity col-12"  href="#addActivity">Tambah Kegiatan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link draftActivity col-12" href="#draftActivity">Daftar Kegiatan</a>
                                        </li>
                                    </ul>
                                    <div class="card mt-4 table-responsive" id="addActivity">
                                        <div class="card-header">
                                            <button type="button" style="border-radius: 5px;" class="btn btn btn-primary shadow-none py-1" data-toggle="modal"
                                                data-target="#addEmployeeModal">Tambah
                                                @yield('title')</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive" id="add_activity">
                                                <h1 class="text-center text-secondary my-5">Memuat..</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mt-4 table-responsive" id="draftActivity">
                                        {{-- Table --}}
                                        <h5 class="text-center text-secondary my-5">Memuat..</h5>
                                    </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kegiatan</h5>
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
                            <label>Kategori Kegiatan</label>
                            @if ($category->count() > 0)
                            <select class="form-control select2" id="add_category_activity_id" name="category_activity_id" required>
                                <option selected disabled>Pilih Kategori</option>
                                @foreach ($category as $item)
                                    @if ( old('category_activity_id') == $item->id )
                                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @else
                            <select class="form-control select2" disabled required>
                                    <option selected disabled>Tidak ada kategori</option>
                            </select>
                            @endif
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="date">Tanggal Kegiatan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="bi bi-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" id="add_date" name="date" v-model="plating_date" class="form-control datepicker" autocomplete="off">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="desc">Deskripsi</label>
                            <textarea class="form-control" style="height: 8rem" id="add_desc" name="desc" rows="3" required placeholder="Deskripsi"></textarea>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="modal-body p-4">
                        <div class="form-group my-2">
                            <label for="title">Judul</label>
                            <input type="text" name="title" id="title" class="form-control titleCheck" placeholder="Judul" required>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label>Kategori Kegiatan</label>
                            @if ($category->count() > 0)
                            <select class="form-control select2" id="category_activity_id" name="category_activity_id">
                                <option selected disabled>Pilih Kategori</option>
                                @foreach ($category as $item)
                                    @if ( old('category_activity_id') == $item->id )
                                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @else
                            <select class="form-control select2" disabled required>
                                <option selected disabled>Tidak ada kategori</option>
                            </select>
                            @endif
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="date">Tanggal Kegiatan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="bi bi-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" name="date" id="date" v-model="plating_date" class="form-control datepicker" autocomplete="off">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="desc">Deskripsi</label>
                            <textarea class="form-control" style="height: 8rem" name="desc" id="desc" rows="3" required placeholder="Deskripsi"></textarea>
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

    <div class="modal fade" id="showDraftActivityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-2">
                        <div class="col-12">
                            <article class="article article-style-b shadow-none">
                                <div class="article-header">
                                    <div class="article-image rounded-lg" style="height: 300px;" data-background="{{ asset('img/undraw_articles_wbpb.svg') }}">
                                    </div>
                                    <div class="article-badge">
                                        <div class="article-badge-item bg-danger" id="category_activity">

                                        </div>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <div class="m-0 row justify-content-between">
                                        <div id="user_id" style="font-weight: bold">

                                        </div>
                                        <div id="date_activity">

                                        </div>
                                    </div>
                                    <div class="article-title">
                                        <div id="title_activity" class="mt-3 text-capitalize">

                                        </div>
                                    </div>
                                    <div id="desc_activity">

                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!-- LIBARARY JS -->
    {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script> --}}
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
        $( function() {
            $("#tabs").tabs();
            $( ".addActivity" ).tabs({
                classes: {
                    "ui-tabs": "costum-color"
                }
            });
            $( ".draftActivity" ).tabs({
                classes: {
                    "ui-tabs": "costum-color"
                }
            });
        });

        $( function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'dd-M-yy',
                minDate: 0,
                timepicker:false,
            });
        });

        $('.titleCheck').change(function(e) {
            $.get('{{ route('poktan-kegiatan-checkSlug') }}',
            { 'title': $(this).val() },
                function( data ) {
                    $('.slugCheck').val(data.slug);
                }
            );
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

            // edit employee ajax request
            $(document).on('click', '.showDraftActivity', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                url: '{{ route('poktan-kegiatan-show') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#title_activity").html(`
                        <h6 class="text-capitalize">
                            ${response.title}
                        </h6>
                    `);
                    $("#category_activity").html(`
                        <i class="bi bi-bookmark"></i> ${response.activity_category.name}
                    `);
                    $("#user_id").html(`
                        <span>
                            Dibuat oleh
                            ${response.user.name}
                        </span>
                    `);
                    $("#date_activity").html(`
                        <span>
                            <i class="bi bi-calendar"></i>
                            ${moment(response.date).locale('id').format('DD MMM YYYY')}
                        </span>
                    `);
                    $("#desc_activity").html(`
                        <p class="text-justify text-capitalize">
                            ${response.desc}
                        </p>
                    `);
                    $("#emp_id").val(response.id);
                }
                });
            });

            // add new employee ajax request
            $("#add_employee_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_employee_btn").text('Tunggu..');
                $("#add_employee_btn").prop('disabled', true);
                $.ajax({
                url: '{{ route('poktan-kegiatan-store') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('add_title', response.messages.title);
                        showError('add_category_activity_id', response.messages.category_activity_id);
                        showError('add_desc', response.messages.desc);
                        showError('add_date', response.messages.date);
                        $("#add_employee_btn").text('Simpan');
                        $("#add_employee_btn").prop('disabled', false);
                    }
                    else if (response.status == 200) {
                        Swal.fire(
                            'Menambahkan!',
                            'Kegiatan Berhasil Ditambahkan!',
                            'success'
                        )
                        fetchAddActivity();
                        fetchDraftActivity();
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
                url: '{{ route('poktan-kegiatan-edit') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#title").val(response.title);
                    $("#category_activity_id").val(response.category_activity_id);
                    $("#date").val(moment(response.date).format('DD-MMM-YYYY'));
                    $("#desc").val(response.desc);
                    $("#emp_id").val(response.id);
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
                url: '{{ route('poktan-kegiatan-update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('title', response.messages.title);
                        showError('category_activity_id', response.messages.category_activity_id);
                        showError('desc', response.messages.desc);
                        showError('date', response.messages.date);
                        $("#edit_employee_btn").text('Simpan');
                        $("#edit_employee_btn").prop('disabled', false);
                    }
                    else if (response.status == 200) {
                        Swal.fire(
                            'Memperbarui!',
                            'Kegiatan Berhasil Diperbarui!',
                            'success'
                        )
                        fetchAddActivity();
                        fetchDraftActivity();
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
                    url: '{{ route('poktan-kegiatan-delete') }}',
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
                        fetchAddActivity();
                        fetchDraftActivity();
                    }
                    });
                }
                })
            });

            // fetch all employees ajax request
            fetchAddActivity();
            // fetch all employees ajax request
            fetchDraftActivity();

            function fetchAddActivity() {
                $.ajax({
                url: '{{ route('poktan-kegiatan-fetchAddActivity') }}',
                method: 'get',
                success: function(response) {
                    $("#add_activity").html(response);
                    $("#table_add_activity").DataTable({
                        order: [0, 'asc']
                    });
                }
                });
            }

            function fetchDraftActivity() {
                $.ajax({
                url: '{{ route('poktan-kegiatan-fetchDraftActivity') }}',
                method: 'get',
                success: function(response) {
                    $("#draftActivity").html(response);
                    $("#table_draft_activity").DataTable({
                        order: [0, 'asc']
                    });
                }
                });
            }
        });

    </script>
@endsection
