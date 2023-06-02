@extends('costumer.template')
@section('title','Daftar Transaksi')

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
        input[type='file'] {
            opacity:0
        }
        /* 4.3 Page */
    .page-error {
        height: 100%;
        width: 100%;
        padding-top: 60px;
        padding-bottom: 60px;
        text-align: center;
        display: table;
    }

    .page-error .page-inner {
        display: table-cell;
        width: 100%;
        vertical-align: middle;
    }

    .page-error .page-description {
        padding-top: 30px;
        font-size: 18px;
        font-weight: 400;
        color: color: var(--primary);;
    }

    @media (max-width: 575.98px) {
        .page-error {
            padding-top: 0px;
        }
    }

    .costum-color {
        background-image: linear-gradient(195deg, #16A085 0%, #16A085 100%);
    }

    div.dataTables_filter > label > input[type="search"] {
        font-family: Arial, sans-serif;
        border: 2px solid #16A085;
        border-radius: 10px;
    }

    div.dataTables_length > label > select[name="listTableSemua_length"] {
        font-family: Arial, sans-serif;
        border: 2px solid #16A085;
        border-radius: 10px;
    }

    div.dataTables_length > label > select[name="listTableDikemas_length"] {
        font-family: Arial, sans-serif;
        border: 2px solid #16A085;
        border-radius: 10px;
    }

    div.dataTables_length > label > select[name="listTableDikirim_length"] {
        font-family: Arial, sans-serif;
        border: 2px solid #16A085;
        border-radius: 10px;
    }

    div.dataTables_length > label > select[name="listTableSelesai_length"] {
        font-family: Arial, sans-serif;
        border: 2px solid #16A085;
        border-radius: 10px;
    }

    div.dataTables_length > label > select[name="listTableDibatalkan_length"] {
        font-family: Arial, sans-serif;
        border: 2px solid #16A085;
        border-radius: 10px;
    }
    </style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4" id="tabs">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">@yield('title')</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <ul class="mx-3 p-1 nav bg-white rounded nav-fill">
                        <li class="nav-item">
                            <a class="nav-link listSemua text-black bg-white" href="#listSemua">Semua</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link listDikemas text-black bg-white" href="#listDikemas">Dikemas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link listDikirim text-black bg-white"  href="#listDikirim">Dikirim</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link listSelesai text-black bg-white" href="#listSelesai">Selesai</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link listDibatalkan text-black bg-white" href="#listDibatalkan">Dibatalkan</a>
                        </li>
                    </ul>
                    <div class="table-responsive border m-3 rounded" id="listSemua">
                        {{-- Table --}}
                        <div id="app">
                            <section class="section">
                                <div class="container">
                                    <div class="page-error">
                                        <div class="page-inner">
                                            <div class="page-description">
                                                Silahkan tunggu ..
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="table-responsive border m-3 rounded" id="listDikemas">
                        {{-- Table --}}
                        <div id="app">
                            <section class="section">
                                <div class="container">
                                    <div class="page-error">
                                        <div class="page-inner">
                                            <div class="page-description">
                                                Silahkan tunggu ..
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="table-responsive border m-3 rounded" id="listDikirim">
                        {{-- Table --}}
                        <div id="app">
                            <section class="section">
                                <div class="container">
                                    <div class="page-error">
                                        <div class="page-inner">
                                            <div class="page-description">
                                                Silahkan tunggu ..
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="table-responsive border m-3 rounded" id="listSelesai">
                        {{-- Table --}}
                        <div id="app">
                            <section class="section">
                                <div class="container">
                                    <div class="page-error">
                                        <div class="page-inner">
                                            <div class="page-description">
                                                Silahkan tunggu ..
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="table-responsive border m-3 rounded" id="listDibatalkan">
                        {{-- Table --}}
                        <div id="app">
                            <section class="section">
                                <div class="container">
                                    <div class="page-error">
                                        <div class="page-inner">
                                            <div class="page-description">
                                                Silahkan tunggu ..
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
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
        $( ".listSemua" ).tabs({
            classes: {
                "ui-tabs": "costum-color"
            }
        });
        $( ".listDikemas" ).tabs({
            classes: {
                "ui-tabs": "costum-color"
            }
        });
        $( ".listDikirim" ).tabs({
            classes: {
                "ui-tabs": "costum-color"
            }
        });
        $( ".listSelesai" ).tabs({
            classes: {
                "ui-tabs": "costum-color"
            }
        });
        $( ".listDibatalkan" ).tabs({
            classes: {
                "ui-tabs": "costum-color"
            }
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

        // fetch all employees ajax request
        fetchAllEmployees();
        fetchDikemasEmployees();
        fetchDikirimEmployees();
        fetchSelesaiEmployees();
        fetchDibatalkanEmployees();

        function fetchAllEmployees() {
            $.ajax({
            url: '{{ route('pembeli.transactionList.fetchAll') }}',
            method: 'get',
            success: function(response) {
                $("#listSemua").html(response);
                $("#listTableSemua").DataTable({
                    order: [0, 'desc'],
                    "oLanguage": {
                        "oPaginate": {
                            "sNext": '<i class="fa fa-chevron-right" ></i>',
                            "sPrevious": '<i class="fa fa-chevron-left" ></i>'
                        }
                    }
                });
            }
            });
        }

        function fetchDikemasEmployees() {
            $.ajax({
            url: '{{ route('pembeli.transactionList.fetchDikemas') }}',
            method: 'get',
            success: function(response) {
                $("#listDikemas").html(response);
                $("#listTableDikemas").DataTable({
                    order: [0, 'desc'],
                    "oLanguage": {
                        "oPaginate": {
                            "sNext": '<i class="fa fa-chevron-right" ></i>',
                            "sPrevious": '<i class="fa fa-chevron-left" ></i>'
                        }
                    }
                });
            }
            });
        }

        function fetchDikirimEmployees() {
            $.ajax({
            url: '{{ route('pembeli.transactionList.fetchDikirim') }}',
            method: 'get',
            success: function(response) {
                $("#listDikirim").html(response);
                $("#listTableDikirim").DataTable({
                    order: [0, 'desc'],
                    "oLanguage": {
                        "oPaginate": {
                            "sNext": '<i class="fa fa-chevron-right" ></i>',
                            "sPrevious": '<i class="fa fa-chevron-left" ></i>'
                        }
                    }
                });
            }
            });
        }

        function fetchSelesaiEmployees() {
            $.ajax({
            url: '{{ route('pembeli.transactionList.fetchSelesai') }}',
            method: 'get',
            success: function(response) {
                $("#listSelesai").html(response);
                $("#listTableSelesai").DataTable({
                    order: [0, 'desc'],
                    "oLanguage": {
                        "oPaginate": {
                            "sNext": '<i class="fa fa-chevron-right" ></i>',
                            "sPrevious": '<i class="fa fa-chevron-left" ></i>'
                        }
                    }
                });
            }
            });
        }

        function fetchDibatalkanEmployees() {
            $.ajax({
            url: '{{ route('pembeli.transactionList.fetchDibatalkan') }}',
            method: 'get',
            success: function(response) {
                $("#listDibatalkan").html(response);
                $("#listTableDibatalkan").DataTable({
                    order: [0, 'desc'],
                    "oLanguage": {
                        "oPaginate": {
                            "sNext": '<i class="fa fa-chevron-right" ></i>',
                            "sPrevious": '<i class="fa fa-chevron-left" ></i>'
                        }
                    }
                });
            }
            });
        }
    });
    </script>
@endsection
