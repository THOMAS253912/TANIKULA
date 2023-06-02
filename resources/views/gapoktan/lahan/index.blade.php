@extends('gapoktan.template')
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
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Gapoktan</div>
                    <div class="breadcrumb-item active"><a href="#">@yield('title')</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <button type="button" style="border-radius: 5px;" class="btn shadow-none py-1 btn-primary" data-toggle="modal"
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Lahan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="add_employee_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        @php
                            $gapoktans = App\Models\Gapoktan::where('user_id', auth()->user()->id)->first();
                        @endphp
                        <input type="hidden" name="gapoktan_id" value="{{ $gapoktans->id }}" class="titleCheck form-control" placeholder="{{ $gapoktans->user->name }}"
                           required>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Lahan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="modal-body p-4">
                        <input type="hidden" name="gapoktan_id" value="{{ $gapoktans->id }}" class="titleCheck form-control" placeholder="{{ $gapoktans->user->name }}"
                           required>
                        <div class="form-group my-2">
                            <label>Pilih Petani</label>
                            @if ($farmers->count() > 0)
                            <select class="form-control select2" id="farmer_id" name="farmer_id">
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
                minDate: 0,
                timepicker:false,
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
                url: '{{ route('gapoktan-lahan-store') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
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
                }
                });
            });

            // edit employee ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                url: '{{ route('gapoktan-lahan-edit') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#farmer_id").val(response.farmer_id);
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
                url: '{{ route('gapoktan-lahan-update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
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
                        $("#edit_employee_form")[0].reset();
                        $("#editEmployeeModal").modal('hide');
                        $("#edit_employee_btn").text('Simpan');
                        $("#edit_employee_btn").prop('disabled', false);
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
                    url: '{{ route('gapoktan-lahan-recycleField') }}',
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
                    url: '{{ route('gapoktan-lahan-delete') }}',
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
                url: '{{ route('gapoktan-lahan-fetchAll') }}',
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
