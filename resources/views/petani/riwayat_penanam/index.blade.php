@extends('petani.template')
@section('title', 'Riwayat Penanam')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- MULAI STYLE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
        integrity="sha256-pODNVtK3uOhL8FUNWWvFQK0QoQoV3YA9wGGng6mbZ0E=" crossorigin="anonymous" />
    <!-- AKHIR STYLE CSS -->
    <style>
        /* STYLE CSS */
        .dt-buttons {
            display: none;
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
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Riwayat Tandur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="modal-body p-4">
                        <div class="form-group my-2">
                            <label for="plant_tanaman">Tanaman</label>
                            <input type="text" disabled name="plant_tanaman" id="plant_tanaman" class="form-control" placeholder="Nama Tanaman" required>
                        </div>
                        <div class="form-group my-2">
                            <label for="surface_area">Luas Tanah</label>
                            <input type="text" disabled name="surface_area" id="surface_area" class="form-control" placeholder="Luas Tanah" required>
                        </div>
                        <div class="form-group my-2">
                            <label for="address">Alamat</label>
                            <textarea class="form-control" style="height: 8rem" name="address" rows="3" placeholder="Alamat" required></textarea>
                        </div>
                        <div class="my-2 form-group">
                            <label for="plating_date">Tanggal Tandur</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="bi bi-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" name="plating_date" disabled id="plating_date" v-model="plating_date" class="form-control datepicker">
                            </div>
                        </div>
                        <div class="my-2 form-group">
                            <label for="plating_date">Tanggal Panen</label>
                            <div class="input-group" id="harvest_date">

                            </div>
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
    <!-- DataTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"
        integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js"
        integrity="sha256-siqh9650JHbYFKyZeTEAhq+3jvkFCG8Iz+MHdr9eKrw=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- AKHIR LIBARARY JS -->

    <!-- JAVASCRIPT -->
    <script>
        $(document).ready(function() {
            $('.input-daterange').datepicker({
                todayBtn:'linked',
                format:'yyyy-mm-dd',
                autoclose:true
            });

            // fetch all employees ajax request
            fetchAllEmployees();

            function fetchAllEmployees(from_date = '', to_date = '') {
                $.ajax({
                url: '{{ route('petani-riwayat-penanam-fetchAll') }}',
                data:{from_date:from_date, to_date:to_date},
                method: 'get',
                success: function(response) {
                    $("#show_all_employees").html(response);
                    $("table").DataTable({
                    order: [0, 'asc'],
                    dom: "Blfrtip",
                    "bLengthChange": false,
                    buttons: [
                        {
                            text: 'Csv',
                            extend: 'csvHtml5',
                            title: 'Laporan Penjualan',
                            exportOptions: {
                                columns: ':visible:not(.not-export-col)'
                            }
                        },
                        {
                            text: 'Excel',
                            extend: 'excelHtml5',
                            title: 'Laporan Penjualan',
                            exportOptions: {
                                columns: ':visible:not(.not-export-col)'
                            }
                        },
                        {
                            text: 'Pdf',
                            extend: 'pdfHtml5',
                            title: 'Laporan Penjualan',
                            exportOptions: {
                                columns: ':visible:not(.not-export-col)'
                            }
                        },
                        {
                            text: 'Print',
                            extend: 'print',
                            title: 'Laporan Penjualan',
                            exportOptions: {
                                columns: ':visible:not(.not-export-col)'
                            }
                        },
                    ],
                    columnDefs: [{
                        orderable: false,
                        targets: -1
                    }]
                    });
                }
                });
            }

            $('#filter').click(function(){
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if(from_date != '' &&  to_date != '')
                {
                    $('table').DataTable().destroy();
                    fetchAllEmployees(from_date, to_date);
                }
                else
                {
                    Swal.fire(
                        'Peringatan!',
                        'Kedua tanggal perlu diisi!',
                        'warning'
                    )
                }
            });

            $('#refresh').click(function(){
                $('#from_date').val('');
                $('#to_date').val('');
                $('table').DataTable().destroy();
                fetchAllEmployees();
            });
        });

        $("ul ul ul a").click(function() {
            var i = $(this).index() + 1
            var table = $('table').DataTable();
            if (i == 1) {
                table.button('.buttons-csv').trigger();
            } else if (i == 2) {
                table.button('.buttons-excel').trigger();
            } else if (i == 3) {
                table.button('.buttons-pdf').trigger();
            } else if (i == 4) {
                table.button('.buttons-print').trigger();
            }
        });
    </script>
@endsection
