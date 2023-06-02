@extends('admin.template')
@section('title', 'Kategori Kegiatan')

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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="add_employee_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <label for="name">Pilih Gapoktan</label>
                        <select class="form-control select2" name="gapoktan_id" id="add_gapoktan_id">
                            <option selected disabled>Pilih Gapoktan</option>
                            @foreach ($user as $item)
                                @if ( old('gapoktan_id') == $item->id )
                                    <option value="{{ $item->id }}" selected>{{ $item->user->name }}</option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <label for="name">Nama</label>
                                <input type="text" name="name" id="add_name" class="nameCheck form-control" placeholder="Nama">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="is_active">Status Kategori</label>
                            <div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="is_active" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="modal-body p-4">
                        <div class="form-group mb-5">
                            <label for="name">Ubah Gapoktan</label>
                            <small class="d-flex text-danger pb-1">*Catatan:
                                <br>1. Jika tidak ingin ubah Gapoktan biarkan kosong,
                                <br>2. Dan jika ingin ubah Gapoktan, silahkan pilih Gapoktan.
                            </small>
                            <select class="form-control select2" name="gapoktan_id">
                                <option selected disabled>Pilih Gapoktan</option>
                                @foreach ($user as $item)
                                    @if ( old('gapoktan_id') == $item->id )
                                        <option value="{{ $item->id }}" selected>{{ $item->user->name }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <label for="name">Nama</label>
                                <input type="text" name="name" id="name" class="form-control nameCheck" placeholder="Nama">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="is_active">Status Kategori</label>
                            <div id="is_active">

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
        $('.nameCheck').change(function(e) {
            $.get('{{ route('admin-kategoriKegiatan-checkSlug') }}',
            { 'name': $(this).val() },
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

            // add new employee ajax request
            $("#add_employee_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_employee_btn").text('Tunggu..');
                $("#add_employee_btn").prop('disabled', true);
                $.ajax({
                url: '{{ route('admin-kategoriKegiatan-store') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('add_gapoktan_id', response.messages.gapoktan_id);
                        showError('add_name', response.messages.name);
                        $("#add_employee_btn").text('Simpan');
                        $("#add_employee_btn").prop('disabled', false);
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Menambahkan!',
                            'Kategori Kegiatan Berhasil Ditambahkan!',
                            'success'
                        )
                        fetchAllEmployees();
                        $("#add_employee_btn").text('Simpan');
                        $("#add_employee_btn").prop('disabled', false);
                        $("#add_employee_form")[0].reset();
                        $("#addEmployeeModal").modal('hide');
                    }
                }
                });
            });

            // edit employee ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                url: '{{ route('admin-kategoriKegiatan-edit') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#name").val(response.name);
                    $("#is_active").html(
                        `<label class="custom-switch">
                            <input type="checkbox" name="is_active" ${response.is_active ? 'checked' : ''} class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                        </label>`);
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
                url: '{{ route('admin-kategoriKegiatan-update') }}',
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
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Memperbarui!',
                            'Kategori Kegiatan Berhasil Diperbarui!',
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

            // fetch all employees ajax request
            fetchAllEmployees();

            function fetchAllEmployees() {
                $.ajax({
                url: '{{ route('admin-kategoriKegiatan-fetchAll') }}',
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
