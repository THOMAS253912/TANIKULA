@extends('admin.template')
@section('title', 'Rekap Penjualan')

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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center input-daterange mb-4">
                                <div class="col-md-4">
                                    <input type="text" name="from_date" id="from_date" class="form-control"
                                        placeholder="Dari Tanggal" readonly />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="to_date" id="to_date" class="form-control"
                                        placeholder="Ke Tanggal" readonly />
                                </div>
                                <div class="col-md-4 mt-md-0 mt-3">
                                    <button type="button" name="filter" id="filter"
                                        class="btn btn-primary shadow-none">Filter</button>
                                    <button type="button" name="refresh" id="refresh"
                                        class="text-white btn btn-secondary shadow-none">Refresh</button>
                                </div>
                            </div>
                            <p class="d-inline-flex font-weight-bold text-white py-1 px-3 border border-light rounded"
                                style="background: #16A085; cursor: pointer;" href="#" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-expanded="false">
                                Export
                            </p>
                            <div class="dropdown-menu mt-2" aria-labelledby="dropdownMenuButton">
                                <ul class="m-0 p-0">
                                    <ul class="m-0 p-0">
                                        <ul class="m-0 p-0">
                                            <a class="dropdown-item" href="#">Export CSV</a>
                                            <a class="dropdown-item" href="#">Export Excel</a>
                                            <a class="dropdown-item" href="#">Export PDF</a>
                                            <a class="dropdown-item" href="#">Print</a>
                                        </ul>
                                    </ul>
                                </ul>
                            </div>
                            <div class="table-responsive" id="show_all_employees">
                                <h1 class="text-center text-secondary my-5">Memuat..</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                url: '{{ route('admin-salesRekap-fetchAll') }}',
                data:{from_date:from_date, to_date:to_date},
                method: 'get',
                success: function(response) {
                    $("#show_all_employees").html(response);
                    $("table").DataTable({
                    order: [0, 'asc'],
                    dom: "Blfrtip",
                    "bLengthChange": false,
                    fixedHeader: true,
                    buttons: [
                        {
                            text: 'Csv',
                            extend: 'csvHtml5',
                            footer: true,
                            title: 'Laporan Penjualan',
                            exportOptions: {
                                columns: ':visible:not(.not-export-col)'
                            }
                        },
                        {
                            text: 'Excel',
                            extend: 'excelHtml5',
                            footer: true,
                            title: 'Laporan Penjualan',
                            exportOptions: {
                                columns: ':visible:not(.not-export-col)'
                            }
                        },
                        {
                            text: 'Pdf',
                            extend: 'pdfHtml5',
                            footer: true,
                            title: 'Laporan Penjualan',
                            // download: 'open',
                            exportOptions: {
                                columns: ':visible:not(.not-export-col)'
                            },
                        },
                        {
                            text: 'Print',
                            extend: 'print',
                            footer: true,
                            title: 'Laporan Penjualan',
                            exportOptions: {
                                columns: ':visible:not(.not-export-col)'
                            },
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
