@extends('admin.template')
@section('title', 'Lahan')

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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Lahan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="add_employee_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="form-group my-2">
                            <label>Gapoktan</label>
                            <select class="form-control select2" id="add_gapoktan_id" name="gapoktan_id">
                                <option selected disabled>Pilih Gapoktan</option>
                                @foreach ($gapoktans as $gapoktan)
                                    @if ( old('gapoktan_id') == $gapoktan->id )
                                        <option value="{{ $gapoktan->id }}" selected>{{ $gapoktan->user->name }}</option>
                                    @else
                                        <option value="{{ $gapoktan->id }}">{{ $gapoktan->user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label>Pilih Petani</label>
                            @if ($farmers->count() > 0)
                            <select class="form-control select2" id="add_farmer_id" name="farmer_id">
                                <option selected disabled>Pilih Petani</option>
                                @foreach ($farmers as $farmer)
                                    @if ( old('farmer_id') == $farmer->id )
                                        <option value="{{ $farmer->id }}" selected>{{ $farmer->user->name }}</option>
                                    @else
                                        <option value="{{ $farmer->id }}">{{ $farmer->user->name }}</option>
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
                        <div class="form-group my-2">
                            <label>Kategori Lahan</label>
                            @if ($category->count() > 0)
                            <select class="form-control select2" id="add_field_category_id" name="field_category_id" required>
                                <option selected disabled>Pilih Kategori</option>
                                @foreach ($category as $item)
                                    @if ( old('field_category_id') == $item->id )
                                        <option value="{{ $item->id }}" selected>{{ $item->name }} ({{ $item->details }})</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->details }})</option>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Lahan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="modal-body p-4">
                        <div class="form-group my-2">
                            <label>Gapoktan</label>
                            @if ($gapoktans->count() > 0)
                            <select class="form-control select2" id="edit_gapoktan_id" name="gapoktan_id">
                                <option selected disabled>Pilih Kategori</option>
                                @foreach ($gapoktans as $gapoktan)
                                    @if ( old('gapoktan_id') == $gapoktan->id )
                                        <option value="{{ $gapoktan->id }}" selected>{{ $gapoktan->user->name }}</option>
                                    @else
                                        <option value="{{ $gapoktan->id }}">{{ $gapoktan->user->name }}</option>
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
                        <div class="form-group my-2">
                            <label>Pilih Petani</label>
                            @if ($farmers->count() > 0)
                            <select class="form-control select2" id="edit_farmer_id" name="farmer_id">
                                <option selected disabled>Pilih Petani</option>
                                @foreach ($farmers as $farmer)
                                    @if ( old('farmer_id') == $farmer->id )
                                        <option value="{{ $farmer->id }}" selected>{{ $farmer->user->name }}</option>
                                    @else
                                        <option value="{{ $farmer->id }}">{{ $farmer->user->name }}</option>
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
                        <div class="form-group my-2">
                            <label>Kategori Lahan</label>
                            @if ($category->count() > 0)
                            <select class="form-control select2" id="field_category_id" name="field_category_id">
                                <option selected disabled>Pilih Kategori</option>
                                @foreach ($category as $item)
                                    @if ( old('field_category_id') == $item->id )
                                        <option value="{{ $item->id }}" selected>{{ $item->name }} ({{ $item->details }})</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->details }})</option>
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
        $(document).ready(function() {
            $('select[name="gapoktan_id"]').on('change', function() {
                var stateID = $(this).val();
                if(stateID) {
                    $.ajax({
                        url: '/dropdown-farmer/'+stateID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="farmer_id"]').html('<option selected disabled>Pilih Petani</option>');
                            $.each(data, function(key, value) {
                            $('select[name="farmer_id"]').append('<option class="text-capitalize" value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="farmer_id"]').empty();
                }
            });
        });

        $(document).ready(function() {
            $('select[name="edit_gapoktan_id"]').on('change', function() {
                var stateID = $(this).val();
                if(stateID) {
                    $.ajax({
                        url: '/dropdown-farmer/'+stateID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="edit_farmer_id"]').html('<option selected disabled>Ubah Petani</option>');
                            $.each(data, function(key, value) {
                            $('select[name="edit_farmer_id"]').append('<option class="text-capitalize" value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="edit_farmer_id"]').empty();
                }
            });
        });

        $( function() {
            $( ".datepicker" ).datepicker({
                dateFormat: 'dd-M-yy'
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

            // add new employee ajax request
            $("#add_employee_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_employee_btn").text('Tunggu..');
                $("#add_employee_btn").prop('disabled', true);
                $.ajax({
                url: '{{ route('admin-lahan-store') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('add_gapoktan_id', response.messages.gapoktan_id);
                        showError('add_field_category_id', response.messages.field_category_id);
                        showError('add_farmer_id', response.messages.farmer_id);
                        $("#add_employee_btn").text('Simpan');
                        $("#add_employee_btn").prop('disabled', false);
                    }
                    else if (response.status == 200) {
                        Swal.fire(
                            'Menambahkan!',
                            'Lahan Berhasil Ditambahkan!',
                            'success'
                        )
                        fetchAllEmployees();
                        $("#add_employee_form")[0].reset();
                        $("#addEmployeeModal").modal('hide');
                        $("#add_employee_btn").text('Simpan');
                        $("#add_employee_btn").prop('disabled', false);
                    }
                }, error: function (xhr) {
                    $('#validation-errors').html('');
                    $.each(xhr.responseJSON.errors, function(key,value) {
                        $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
                    });
                },
                });
            });

            // edit employee ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                url: '{{ route('admin-lahan-edit') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#edit_farmer_id").val(response.farmer_id);
                    $("#edit_gapoktan_id").val(response.gapoktan_id);
                    $("#field_category_id").val(response.field_category_id);
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
                url: '{{ route('admin-lahan-update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('gapoktan_id', response.messages.gapoktan_id);
                        showError('field_category_id', response.messages.field_category_id);
                        showError('farmer_id', response.messages.farmer_id);
                        $("#edit_employee_btn").text('Simpan');
                        $("#edit_employee_btn").prop('disabled', false);
                    }
                    else if (response.status == 200) {
                        Swal.fire(
                            'Memperbarui!',
                            'Lahan Berhasil Diperbarui!',
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
            $(document).on('click', '.recycleField', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Mengembalikan data ini kesemula!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin!',
                cancelButtonText: 'Kembali!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    url: '{{ route('admin-lahan-recycleField') }}',
                    method: 'post',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire(
                        'Berhasil!',
                        'Data berhasil semula!',
                        'success'
                        )
                        fetchAllEmployees();
                    }
                    });
                }
                })
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
                    url: '{{ route('admin-lahan-delete') }}',
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
                url: '{{ route('admin-lahan-fetchAll') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_employees").html(response);
                    $("table").DataTable();
                }
                });
            }
        });

    </script>
@endsection
