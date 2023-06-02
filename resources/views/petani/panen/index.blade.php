@extends('petani.template')
@section('title', 'Panen')

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
                    <div class="breadcrumb-item">Petani</div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Panen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div id="show_all_fields">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editPanenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Panen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="edit_panen_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id_edit">
                    <input type="hidden" name="field_id" id="field_id_edit">
                    <input type="hidden" name="plant_id" id="plant_id_edit">
                    <input type="hidden" name="farmer_id" id="farmer_id_edit">
                    <div class="modal-body p-4">
                        <div class="form-group">
                            <label for="plating_date">Tanggal Panen</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="bi bi-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" name="date_harvest" placeholder="Tanggal Panen" id="date_harvest_edit"
                                    class="form-control datepicker" autocomplete="off">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="status">Status</label>
                            </div>
                            <select class="custom-select" name="status" id="status_edit">
                                <option selected disabled>Pilih...</option>
                                <option value="panen">Selesai Panen</option>
                                <option value="belum selesai panen">Belum Selesai Panen</option>
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn shadow-none border" style="background: #FFFACD;" data-dismiss="modal">Kembali</button>
                        <button type="submit" id="edit_panen_btn" style="background: #16A085; color: white" class="btn shadow-none border">Simpan</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Panen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <input type="hidden" name="plant_id" id="plant_id">
                    <input type="hidden" name="farmer_id" id="farmer_id">
                    <input type="hidden" name="field_id" id="field_id">
                    <div class="modal-body p-4">
                        <div class="form-group">
                            <label for="plating_date">Tanggal Panen</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="bi bi-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" name="date_harvest" placeholder="Tanggal Panen" id="date_harvest"
                                    class="form-control datepicker" autocomplete="off">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="status">Status</label>
                            </div>
                            <select class="custom-select" name="status" id="status">
                                <option selected disabled>Pilih...</option>
                                <option value="panen">Selesai Panen</option>
                                <option value="belum selesai panen">Belum Selesai Panen</option>
                            </select>
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
                // minDate: 0,
                // timepicker:false,
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
            // edit employee ajax request
            $(document).on('click', '.editPanen', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                url: '{{ route('petani-panen-editPanen') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#status_edit").val(response.status);
                    $("#date_harvest_edit").val(moment(response.date_harvest).format('DD-MMM-YYYY'));
                    $("#plant_id_edit").val(response.planting_id);
                    $("#farmer_id_edit").val(response.farmer_id);
                    $("#field_id_edit").val(response.field_recap_planting.field_id);
                    $("#emp_id_edit").val(response.id);
                }
                });
            });

            // update employee ajax request
            $("#edit_panen_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#edit_panen_btn").text('Tunggu..');
                $("#edit_panen_btn").prop('disabled', true);
                $.ajax({
                url: '{{ route('petani-panen-updatePanen') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('date_harvest_edit', response.messages.date_harvest);
                        showError('status_edit', response.messages.status);
                        $("#edit_panen_btn").text('Simpan');
                        $("#edit_panen_btn").prop('disabled', false);
                    } else if (response.status == 401) {
                        Swal.fire(
                            'Peringatan!',
                            'Tanggal panen tidak boleh mendahului tanggal tandur!',
                            'warning'
                        )
                        $("#edit_panen_btn ").text('Simpan');
                        $("#edit_panen_btn ").prop('disabled', false);
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Memperbarui!',
                            'Panen Berhasil Diperbarui!',
                            'success'
                        )
                        fetchAllEmployees();
                        fetchAllEmployeesFields();
                        $("#edit_panen_btn").text('Simpan');
                        $("#edit_panen_btn").prop('disabled', false);
                        $("#edit_panen_form")[0].reset();
                        $("#editPanenModal").modal('hide');
                    }
                }
                });
            });

            // edit employee ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                url: '{{ route('petani-panen-edit') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#farmer_id").val(response.farmer_id);
                    $("#field_id").val(response.field_id);
                    $("#plant_id").val(response.id);
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
                url: '{{ route('petani-panen-update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('date_harvest', response.messages.date_harvest);
                        showError('status', response.messages.status);
                        $("#edit_employee_btn").text('Simpan');
                        $("#edit_employee_btn").prop('disabled', false);
                    } else if (response.status == 401) {
                        Swal.fire(
                            'Peringatan!',
                            'Tanggal panen tidak boleh mendahului tanggal tandur!',
                            'warning'
                        )
                        $("#edit_employee_btn").text('Simpan');
                        $("#edit_employee_btn").prop('disabled', false);
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Berhasil!',
                            'Panen Berhasil Ditambahkan!',
                            'success'
                        )
                        fetchAllEmployees();
                        fetchAllEmployeesFields();
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
                url: '{{ route('petani-panen-fetchAll') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_employees").html(response);
                    $("#recapHarvest").DataTable();
                }
                });
            }

            // fetch all employees ajax request
            fetchAllEmployeesFields();

            function fetchAllEmployeesFields() {
                $.ajax({
                url: '{{ route('petani-panen-fetchAllPlanting') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_fields").html(response);
                    $("#recapPlanting").DataTable();
                }
                });
            }
        });

    </script>
@endsection
