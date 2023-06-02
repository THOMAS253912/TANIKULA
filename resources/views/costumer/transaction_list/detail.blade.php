@extends('costumer.template')
@section('title','Detail Transaksi')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- MULAI STYLE CSS -->
    <!-- default styles -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"> --}}
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />

    <!-- with v4.1.0 Krajee SVG theme is used as default (and must be loaded as below) - include any of the other theme CSS files as mentioned below (and change the theme property of the plugin) -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/themes/krajee-svg/theme.css" media="all" rel="stylesheet" type="text/css" />
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

    .card-stepper {
        z-index: 0
    }

    #progressbar-2 {
        color: #455A64;
    }

    #progressbar-2 li {
        list-style-type: none;
        font-size: 13px;
        width: 33.33%;
        float: left;
        position: relative;
    }

    #progressbar-2 #step1:before {
        content: '\f058';
        font-family: "Font Awesome 5 Free";
        color: #fff;
        width: 37px;
        margin-left: 0px;
        padding-left: 0px;
    }

    #progressbar-2 #step2:before {
        content: '\f058';
        font-family: "Font Awesome 5 Free";
        color: #fff;
        width: 37px;
    }

    #progressbar-2 #step3:before {
        content: '\f058';
        font-family: "Font Awesome 5 Free";
        color: #fff;
        width: 37px;
        margin-right: 0;
        text-align: center;
    }

    #progressbar-2 #step4:before {
        content: '\f111';
        font-family: "Font Awesome 5 Free";
        color: #fff;
        width: 37px;
        margin-right: 0;
        text-align: center;
    }

    #progressbar-2 li:before {
        line-height: 37px;
        display: block;
        font-size: 12px;
        background: #c5cae9;
        border-radius: 50%;
    }

    #progressbar-2 li:after {
        content: '';
        width: 100%;
        height: 10px;
        background: #c5cae9;
        position: absolute;
        left: 0%;
        right: 0%;
        top: 15px;
        z-index: -1;
    }

    #progressbar-2 li:nth-child(1):after {
        left: 1%;
        width: 100%
    }

    #progressbar-2 li:nth-child(2):after {
        left: 1%;
        width: 100%;
    }

    #progressbar-2 li:nth-child(3):after {
        left: 1%;
        width: 100%;
        background: #c5cae9 !important;
    }

    #progressbar-2 li:nth-child(4) {
        left: 0;
        width: 37px;
    }

    #progressbar-2 li:nth-child(4):after {
        left: 0;
        width: 0;
    }

    #progressbar-2 li.active:before,
    #progressbar-2 li.active:after {
        background: #6520ff;
    }

    /* rating */
    .rating-produkUlasan div {
        color: #f0d800;
        font-size: 30px;
        font-family: sans-serif;
        font-weight: 800;
        text-align: center;
        text-transform: uppercase;
        margin: 25px 0 0 0;
    }

    .rating-produkView div {
        color: #f0d800;
        font-size: 10px;
        font-family: sans-serif;
        font-weight: 800;
        text-transform: uppercase;
    }

    .rating-produk div {
        color: #f0d800;
        font-size: 30px;
        font-family: sans-serif;
        font-weight: 800;
        text-align: center;
        text-transform: uppercase;
        margin: 25px 0 0 0;
    }

    .rating-produk input {
        display: none;
    }

    .rating-produk input+label {
        font-size: 35px;
        text-shadow: 1px 1px 0 #8f8420;
        cursor: pointer;
    }

    .rating-produk input:checked+label~label {
        color: #b4afaf;
    }

    .rating-produk label:active {
        transform: scale(0.8);
        transition: 0.3s ease;
    }
    </style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">@yield('title')</h6>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if ($order->status == 'cancelled')
                        <div class="card shadow border mb-4 bg-primary text-white p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="pe-3">
                                    <p class="m-0 fw-bold">Pesanan Dibatalkan</p>
                                    <small>Kamu telah membatalkan pesanan ini. Cek Rincian Pembatalan untuk informasi lebih lanjut.</small>
                                </div>
                                <div><i class="bi bi-bag-x h1 text-white"></i></div>
                            </div>
                        </div>
                    @elseif ($order->status == 'confirmed')
                        <div class="card shadow border mb-4 bg-primary text-white p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="pe-3">
                                    <p class="m-0 fw-bold">Pesanan Sedang Diproses</p>
                                    <small>Pesanan anda sedang diproses oleh penjual. Penjual memerlukan beberapa waktu untuk mengecek pesanan anda.</small>
                                </div>
                                <div><i class="bi bi-truck h1 text-white"></i></div>
                            </div>
                        </div>
                    @endif
                    <div class="d-md-flex justify-content-between align-items-center mb-4">
                        <p class="fw-normal mb-0" style="font-size: 18px">Invoice ID :</p>
                        <p class="fw-bold mb-0" style="font-size: 18px">#{{ $order->code }}</p>
                    </div>
                    <div class="card shadow-0 border mb-4">
                        <div class="card-body">
                            <h5>Pesanan Anda</h5>
                            <hr style="background-color: #e0e0e0; opacity: 1;">
                            <div>
                                <p class="fw-bold text-black text-uppercase mb-2">Alamat Tagihan</p>
                                <div>
                                    <p class="text-black m-0">{{ $order->address->recipients_name }}
                                        <span class="fw-normal">({{$order->address->address_label}})
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-black m-0">
                                        @if ($order->address->village_id && $order->address->district_id && $order->address->city_id && $order->address->province_id != null)
                                            {{ $order->address->village->name }}, Kecamatan {{ $order->address->district->name }}, {{ $order->address->city->name }}, Provinsi {{ $order->address->province->name }}
                                        @endif, {{$order->address->postal_code}}. [TaniKula Note: {{$order->address->complete_address}} {{$order->address->note_for_courier}}].</p>
                                    <p class="text-black m-0">
                                        @if ($order->address->district_id != null)
                                            {{ $order->address->district->name }},
                                        @endif{{$order->address->postal_code}}.
                                    </p>
                                    <p class="text-black m-0 pt-3"><span> Email : </span>
                                        {{$order->user->email}}</p>
                                    <p class="text-black m-0"><span> No Telp : </span>
                                        {{$order->address->telp}}</p>
                                    {{-- <p class="text-black m-0"><span> Kode Pos : </span>
                                        {{$order->address->postal_code}}</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-0 border mb-4">
                        <div class="card-body">
                            <!-- End Navbar -->
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table table-borderless align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Foto Produk</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Nama Produk</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Qty</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Harga Satuan</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $total = 0;
                                            $ongkirTotal = 0;
                                            $totalQty = 0;
                                            $discount = 0;
                                            @endphp
                                            @foreach ($order->orderItems as $orderitem)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        @if ($orderitem->product->photo_product->count() > 0)
                                                        @foreach ($orderitem->product->photo_product->take(1) as
                                                        $photos)
                                                        @if ($photos->name)
                                                        <img src="{{ asset('../storage/produk/'.$photos->name) }}"
                                                            class="img-fluid rounded"
                                                            style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                                            alt="{{ $orderitem->product->name }}">
                                                        @else
                                                        <img src="{{ asset('img/no-image.png') }}" class="img-fluid rounded"
                                                            style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                                            alt="{{ $orderitem->product->name }}">
                                                        @endif
                                                        @endforeach
                                                        @else
                                                        <img src="{{ asset('img/no-image.png') }}" class="img-fluid rounded"
                                                            style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                                            alt="{{ $orderitem->product->name }}">
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $orderitem->product->name }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $orderitem->qty }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">Rp. {{ number_format($orderitem->price, 0) }}</span>
                                                </td>
                                                @php
                                                    if ($orderitem->product->discount) {
                                                        $discount += $orderitem->product->price_discount - $orderitem->product->price;
                                                        $discount = $discount * $orderitem->qty;
                                                    } else {
                                                        $discount += 0;
                                                    }
                                                    $subTotal = $orderitem->price * $orderitem->qty;
                                                    $total += $orderitem->price * $orderitem->qty;
                                                    $totalQty += $orderitem->product_qty;
                                                    $ongkirTotal = $order->total_price - $total;
                                                @endphp
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">Rp.{{ number_format($subTotal, 0) }}</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-md-flex justify-content-between pt-2">
                        <div>
                            <p class="fw-bold mb-0">Rincian Pesanan</p>

                            <p class="text-muted mb-0">Invoice ID : #{{ $order->code }}</p>
                            <p class="text-muted mb-0">Tanggal Pemesanan :
                                {{ \App\Helpers\General::datetimeFormat($order->order_date) }}</p>
                            <p class="text-muted mb-0 text-capitalize">Status Pesanan :
                                {{$order->status}}</p>
                            <p class="text-muted mb-0 text-capitalize">Status Pembayaran :
                                {{$order->payment_status}}</p>
                        </div>

                        <div class="mt-3 mt-md-0">
                            <p class="text-muted mb-0"><span class="fw-bold me-4">Total</span> Rp.
                                {{ number_format($total, 0) }}</p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">Ongkir</span> Rp. {{ number_format($ongkirTotal, 0) }}</p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">Diskon</span> Rp. {{ number_format($discount, 0) }}</p>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="passingIdOrder" value="{{ $order->id }}">
                <div class="card-footer border-0 px-4 bg-primary shadow-primary border-radius-lg py-5 d-md-flex align-items-center justify-content-between">
                    <h5 class="text-white text-uppercase mb-0">Total
                        Pembayaran: <span class="d-flex h2 mb-0 text-white text-capitalize">Rp.
                            {{ number_format($order->total_price, 0) }}</span></h5>
                    @if (!$order->isPaid())
                        @if (!$order->isCancelled())
                        <div class="d-block mt-3 mt-md-0">
                            <script>
                                CountDownTimer('{{ $order->order_date }}', 'countdown');
                                function CountDownTimer(dt, id)
                                {
                                    var end = new Date('{{ $order->payment_due }}');
                                    var _second = 1000;
                                    var _minute = _second * 60;
                                    var _hour = _minute * 60;
                                    var _day = _hour * 24;
                                    var timer;
                                    function showRemaining() {
                                        var now = new Date();
                                        var distance = end - now;
                                        if (distance < 0) {
                                            clearInterval(timer);
                                            // document.getElementById(id).innerHTML = '<b>Pembayaran Sudah Kadaluarsa';
                                            // return;

                                            return deleteOrders();

                                            function deleteOrders()
                                            {
                                                var id = $("input[name=passingIdOrder]").val();
                                                $.ajax({
                                                    method: "GET",
                                                    url: '/delete-orders/' +id,
                                                    success: function (response) {
                                                        iziToast.warning({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                                            title: 'Peringatan',
                                                            message: 'Maaf pesanan anda sudah kadaluarsa',
                                                            position: 'topRight'
                                                        });
                                                        window.setTimeout(function(){location.reload()},3000);
                                                    }
                                                });
                                            }
                                        }
                                        var days = Math.floor(distance / _day);
                                        var hours = Math.floor((distance % _day) / _hour);
                                        var minutes = Math.floor((distance % _hour) / _minute);
                                        var seconds = Math.floor((distance % _minute) / _second);

                                        document.getElementById(id).innerHTML = days + 'Hari ';
                                        document.getElementById(id).innerHTML += hours + 'Jam ';
                                        document.getElementById(id).innerHTML += minutes + 'Menit ';
                                        document.getElementById(id).innerHTML += seconds + 'Detik';
                                    }
                                    timer = setInterval(showRemaining, 1000);
                                }
                            </script>
                            <div>
                                <p class="fw-bold mb-0 text-white">Waktu Pembayaran</p>
                                <p class="fw-bold mb-0 text-white" id="countdown"></p>
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn border bg-danger text-white" data-bs-toggle="modal" data-bs-target="#cancelledOrderModal">
                                    Batalkan Pesanan
                                </button>
                                <a href="{{ $order->payment_url }}" class="d-inline-flex btn border" style="background: #ffff; color: #16A085;">
                                    Lanjutkan Pembayaran
                                </a>
                            </div>
                        </div>
                        @endif
                    @endif
                    @if ( $order->status == 'completed')
                        @if (!$order->review == 'reviewed')
                            <button type="button" class="mt-3 mt-md-0 btn border bg-light" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                Berikan Ulasan
                            </button>
                        @else
                            <button type="button" class="mt-3 mt-md-0 btn border bg-light" data-bs-toggle="modal" data-bs-target="#editReviewModal">
                                Lihat Ulasan
                            </button>
                        @endif
                    @elseif ($order->status == 'confirmed')
                    <button type="button" class="mt-3 mt-md-0 btn border bg-warning text-white">
                        Sedang Dikemas
                    </button>
                    @elseif ($order->status == 'delivered')
                    <div class="d-md-flex">
                        <button type="button" class="mt-3 mt-md-0 btn border bg-light" data-bs-toggle="modal" data-bs-target="#showOrderModal">
                            Lacak Pesanan
                        </button>
                        <form action="#" method="POST" id="order_completed">
                            @csrf
                            <input type="hidden" value="{{$order->id}}" name="emp_id">
                            <button type="submit" class="btn ms-md-2 border text-white bg-warning">
                                Pesanan Diterima
                            </button>
                        </form>
                    </div>
                    @elseif ($order->status == 'cancelled')
                    <button type="button" class="mt-3 mt-md-0 btn border bg-light" data-bs-toggle="modal" data-bs-target="#rincianPembatalan">
                        Rincian Pembatalan
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Rincian Pembatalan --}}
<div class="modal fade" id="rincianPembatalan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title align-middle" id="exampleModalLabel"><span class="bi bi-arrow-left pe-3 h4 align-middle" data-bs-dismiss="modal"></span>Rincian Pembatalan</h5>
            </div>
            <div class="modal-body text-start text-black p-4">
                <div class="my-2">
                    <label for="">Dibatalkan oleh</label>
                    <input class="form-control border px-3" value="Pembeli" disabled disabled rows="5">
                </div>
                <div class="my-2">
                    <label for="">Dibatalkan pada</label>
                    <input class="form-control border px-3" value="{{ \App\Helpers\General::datetimeFormat($order->cancelled_at) }}" disabled disabled rows="5">
                </div>
                <div class="my-2">
                    <label for="">Alasan batal</label>
                    <textarea class="form-control border px-3" disabled rows="5">{{ $order->cancellation_note }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Ulasan --}}
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <style>
        #style-0::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px #16A085;
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        #style-0::-webkit-scrollbar
        {
            width: 12px;
            background-color: #F5F5F5;
        }

        #style-0::-webkit-scrollbar-thumb
        {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px #16A085;
            background-color: #16A085;
        }
    </style>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title align-middle" id="exampleModalLabel"><span class="bi bi-arrow-left pe-3 h4 align-middle" data-bs-dismiss="modal"></span>Ulasan Produk</h5>
            </div>
            <div class="modal-body text-start text-black p-4" id="style-0">
                <form action="#" method="POST" id="add_employee_form" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div>
                        @foreach ($order->orderItems as $orderitem)
                        <input type="hidden" name="product_id[]" value="{{ $orderitem->product_id }}">
                        <input type="hidden" name="order_id[]" value="{{ $orderitem->order_id }}">
                        <input type="hidden" name="rev_order_id" value="{{ $orderitem->order_id }}">
                        <div class="d-flex align-items-center py-1 border-bottom">
                            @if ($orderitem->product->photo_product->count() > 0)
                                @foreach ($orderitem->product->photo_product->take(1) as
                                $photos)
                                    @if ($photos->name)
                                        <img src="{{ asset('../storage/produk/'.$photos->name) }}" class="img-fluid rounded"
                                            style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="{{ $orderitem->product->name }}">
                                    @else
                                        <img src="{{ asset('img/no-image.png') }}" class="img-fluid rounded"
                                            style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="{{ $orderitem->product->name }}">
                                    @endif
                                @endforeach
                            @else
                                <img src="{{ asset('img/no-image.png') }}" class="img-fluid rounded"
                                    style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="{{ $orderitem->product->name }}">
                            @endif
                            <div>
                                <p class="my-0 mx-3 text-secondary text-xs font-weight-bold">{{ $orderitem->product->name }}</p>
                                <span class="my-0 mx-3 text-secondary text-xs font-weight-bold">{{ $orderitem->qty }} Qty</span>
                            </div>
                        </div>
                        <div class="rating-produkUlasan">
                            <div>
                                <input id="stars_rated" name="stars_rated[]" type="number" class="rating" step=1
                                    data-showClear="false" required data-showCaption="false" data-animate="false">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <textarea class="form-control border px-3"
                                placeholder="Beritahu kepada pengguna lain mengapa anda sangat menyukai produk ini."
                                name="review[]" required rows="5" id="message-text"></textarea>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        @endforeach
                        <div class="mt-3">
                            <div class="px-3 border text-sm p-2 rounded bg-white d-flex justify-content-between">
                                <div>
                                    <span>Tampilkan username pada penilaian</span>
                                    @php
                                    function get_starred($str) {
                                        $len = strlen($str);
                                        return substr($str, 0, 1).str_repeat('*', $len - 2).substr($str, $len - 1, 1);
                                    }
                                    @endphp
                                    <div>Username yang akan ditampilkan adalah <span id="console-event">{{ get_starred(strtok(auth()->user()->name, ' ')) }}</span></div>
                                </div>
                                <input id="toggle-event" name="hide" checked type="checkbox" data-toggle="toggle">
                            </div>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center border-top-0">
                        <button type="submit" id="add_employee_btn" class="text-white btn bg-primary btn-lg mb-1" style="background-color: #35558a;">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Lihat Ulasan --}}
<div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <style>
        #style-1::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px #16A085;
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        #style-1::-webkit-scrollbar
        {
            width: 12px;
            background-color: #F5F5F5;
        }

        #style-1::-webkit-scrollbar-thumb
        {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px #16A085;
            background-color: #16A085;
        }
    </style>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title align-middle" id="exampleModalLabel"><span class="bi bi-arrow-left pe-3 h4 align-middle" data-bs-dismiss="modal"></span>Ulasan Saya</h5>
            </div>
            <div class="modal-body text-start text-black p-4" id="style-1">
                <div>
                    @foreach ($reviews as $review)
                    <div class="d-flex align-items-center pt-3">
                        @if ($userInfo->image)
                        <img src="{{asset('../storage/profile/'. $userInfo->image)}}" class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 55px; height: 55px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="{{ $userInfo->user->name }}">
                        @else
                        <img src="{{ asset('stisla/assets/img/example-image.jpg') }}" class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 55px; height: 55px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="{{ $userInfo->user->name }}">
                        @endif
                        <div>
                            <p class="my-0 mx-3 text-secondary text-xs font-weight-bold">
                                @if ($review->hide === 1)
                                    {{ get_starred(strtok($order->user->name, ' ')) }}
                                @else
                                    {{ $order->user->name }}
                                @endif
                            </p>
                            <div class="my-0 mx-3 rating-produkView">
                                <div class="star-icon">
                                    @for ($i=1; $i<=$review->stars_rated; $i++)
                                        <i class="lni lni-star-filled checked"></i>
                                    @endfor
                                    @for ($j = $review->stars_rated+1; $j <=5; $j++)
                                        <i class="lni lni-star"></i>
                                    @endfor
                                </div>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <p class="my-1 mx-3 text-secondary text-xs">
                                {{ \App\Helpers\General::datetimeFormat($review->created_at) }}</p>
                        </div>
                    </div>
                    <div class="m-3">
                        <p class="my-0 mx-3 text-secondary text-xs font-weight-bold">{{ $review->review }}</p>
                    </div>

                    <div class="d-flex align-items-center py-2 rounded bg-light px-3">
                        @if ($review->product->photo_product->count() > 0)
                            @foreach ($review->product->photo_product->take(1) as
                            $photos)
                                @if ($photos->name)
                                    <img src="{{ asset('../storage/produk/'.$photos->name) }}" class="img-fluid rounded"
                                        style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="{{ $review->product->name }}">
                                @else
                                    <img src="{{ asset('img/no-image.png') }}" class="img-fluid rounded"
                                        style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="{{ $review->product->name }}">
                                @endif
                            @endforeach
                        @else
                            <img src="{{ asset('img/no-image.png') }}" class="img-fluid rounded"
                                style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="{{ $review->product->name }}">
                         @endif
                        <div>
                            <p class="my-0 mx-3 text-secondary text-xs font-weight-bold text-truncate col-9">
                                {{ $review->product->name }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer d-flex justify-content-center border-top-0 py-4">
                    <button type="button" class="text-white btn bg-primary btn-lg mb-1"
                        data-bs-toggle="modal" data-bs-target="#editUlasanModal"
                        data-bs-dismiss="modal">
                        Edit Ulasan Saya
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Edit Ulasan --}}
<div class="modal fade" id="editUlasanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <style>
        #style-2::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px #16A085;
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        #style-2::-webkit-scrollbar
        {
            width: 12px;
            background-color: #F5F5F5;
        }

        #style-2::-webkit-scrollbar-thumb
        {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px #16A085;
            background-color: #16A085;
        }
    </style>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title align-middle" id="exampleModalLabel"><span class="bi bi-arrow-left pe-3 h4 align-middle" data-bs-dismiss="modal"></span>Edit Ulasan Produk</h5>
            </div>
            <div class="modal-body text-start text-black p-4" id="style-2">
                <form action="#" method="POST" id="edit_employee_form" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div>
                        @php
                            $checked = 0;
                        @endphp
                        @foreach ($reviews as $review)
                        <input type="hidden" name="reviewed_id[]" value="{{ $review->id }}">
                        <input type="hidden" name="reviewed_product_id[]" value="{{ $review->product_id }}">
                        <div class="d-flex align-items-center py-1 border-bottom">
                            @if ($review->product->photo_product->count() > 0)
                                @foreach ($review->product->photo_product->take(1) as
                                $photos)
                                    @if ($photos->name)
                                        <img src="{{ asset('../storage/produk/'.$photos->name) }}" class="img-fluid rounded"
                                            style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="{{ $review->product->name }}">
                                    @else
                                        <img src="{{ asset('img/no-image.png') }}" class="img-fluid rounded"
                                            style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="{{ $review->product->name }}">
                                    @endif
                                @endforeach
                            @else
                                <img src="{{ asset('img/no-image.png') }}" class="img-fluid rounded"
                                    style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="{{ $review->product->name }}">
                            @endif
                            <div>
                                <p class="my-0 mx-3 text-secondary text-xs font-weight-bold">{{ $review->product->name }}</p>
                                <p class="my-1 mx-3 text-secondary text-xs">
                                {{ \App\Helpers\General::datetimeFormat($review->created_at) }}</p>
                            </div>
                        </div>
                        <div class="rating-produkUlasan">
                            <div>
                                <input id="reviewed_stars_rated" value="{{ $review->stars_rated }}" name="reviewed_stars_rated[]" type="number" class="rating" step=1
                                    data-showClear="false" data-showCaption="false" data-animate="false" required>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        @php
                            $checked = $review->hide;
                        @endphp
                        <div class="mb-5">
                            <textarea class="form-control border px-3" required
                                placeholder="Beritahu kepada pengguna lain mengapa anda sangat menyukai produk ini."
                                name="reviewed_review[]" rows="5" id="reviewed_message-text">{{ $review->review }}</textarea>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        @endforeach
                        <div class="mt-3">
                            <div class="px-3 border text-sm p-2 rounded bg-white d-flex justify-content-between">
                                <div>
                                    <span>Tampilkan username pada penilaian</span>
                                    @php
                                    function hideReview($str) {
                                        $len = strlen($str);
                                        return substr($str, 0, 1).str_repeat('*', $len - 2).substr($str, $len - 1, 1);
                                    }
                                    @endphp
                                    <div>Username yang akan ditampilkan adalah <span id="edit-event">
                                        @if ($checked == 1)
                                            {{ hideReview(strtok(auth()->user()->name, ' ')) }}
                                        @elseif ($checked == 0)
                                            {{ strtok(auth()->user()->name, ' ') }}
                                        @endif</span>
                                    </div>
                                </div>
                                <input id="edit-event-toogle" {{ $checked == 1 ? 'checked' : '' }} name="hide" type="checkbox" data-toggle="toggle">
                            </div>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center border-top-0">
                        <button type="submit" id="edit_employee_btn" class="text-white btn bg-primary btn-lg mb-1" style="background-color: #35558a;">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tracking -->
<div class="modal fade" id="showOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    <div class="card card-stepper text-black" style="border-radius: 16px;">
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <div>
                                    <h5 class="mb-0">INVOICE <span class="text-primary font-weight-bold">#{{ $order->code }}</span>
                                    </h5>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0">Expected Arrival <span>01/12/19</span></p>
                                    <p class="mb-0">No Tracking</p>
                                    <span class="font-weight-bold">234094567242423422898</span>
                                </div>
                            </div>
                            <ul id="progressbar-2" class="d-flex justify-content-between mx-0 mt-0 mb-5 px-0 pt-0 pb-2">
                                <li class="step0 active text-center" id="step1"></li>
                                <li class="step0 active text-center" id="step2"></li>
                                <li class="step0 active text-center" id="step3"></li>
                                <li class="step0 text-muted text-end" id="step4"></li>
                            </ul>
                            <div class="d-flex justify-content-between">
                                <div class="d-lg-flex align-items-center">
                                    <i class="fas fa-clipboard-list fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                                    <div>
                                        <p class="fw-bold mb-1">Order</p>
                                        <p class="fw-bold mb-0">Processed</p>
                                    </div>
                                </div>
                                <div class="d-lg-flex align-items-center">
                                    <i class="fas fa-box-open fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                                    <div>
                                        <p class="fw-bold mb-1">Order</p>
                                        <p class="fw-bold mb-0">Shipped</p>
                                    </div>
                                </div>
                                <div class="d-lg-flex align-items-center">
                                    <i class="fas fa-shipping-fast fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                                    <div>
                                        <p class="fw-bold mb-1">Order</p>
                                        <p class="fw-bold mb-0">En Route</p>
                                    </div>
                                </div>
                                <div class="d-lg-flex align-items-center">
                                    <i class="fas fa-home fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                                    <div>
                                        <p class="fw-bold mb-1">Order</p>
                                        <p class="fw-bold mb-0">Arrived</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cancel Order -->
<div class="modal fade" id="cancelledOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center border-bottom-0">
                <h5 class="modal-title align-middle" id="exampleModalLabel"><span class="bi bi-arrow-left pe-3 h4 align-middle" data-bs-dismiss="modal"></span>Pilih Alasan Pembatalan</h5>
            </div>
            <form action="#" method="POST" id="cancelled_orders_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-start text-black p-4">
                    <input type="hidden" value="{{$order->id}}" name="emp_id">
                    <div class="alert alert-danger text-white d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-circle pe-2"></i>
                        <div>
                            Silahkan pilih alasan pembatalan. Pesananmu akan langsung dibatalkan setelah
                            alasan pembatalan diajukan.
                        </div>
                    </div>
                    <div class="p-0 form-check">
                        <input class="form-check-input" value="Ingin mengubah alamat pengiriman" type="radio" name="cancellation_note" id="cancellation_note">
                        <label class="form-check-label" for="cancellation_note">
                            Ingin mengubah alamat pengiriman
                        </label>
                    </div>
                    <div class="p-0 form-check">
                        <input class="form-check-input" value="Ingin mengubah rincian dan membuat pesanan baru" type="radio" name="cancellation_note" id="cancellation_note">
                        <label class="form-check-label" for="cancellation_note">
                            Ingin membuat pesanan baru
                        </label>
                    </div>
                    <div class="p-0 form-check">
                        <input class="form-check-input" value="Lainnya/berubah pikiran" type="radio" name="cancellation_note" id="cancellation_note">
                        <label class="form-check-label" for="cancellation_note">
                            Lainnya/berubah pikiran
                        </label>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center border-top-0 py-4">
                    <button type="submit" id="cancelled_orders_btn" class="btn btn-primary btn-lg mb-1" style="background-color: #16A085;">
                        Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <!-- LIBARARY JS -->
    <!-- important mandatory libraries -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/js/star-rating.min.js" type="text/javascript"></script>

    <!-- with v4.1.0 Krajee SVG theme is used as default (and must be loaded as below) - include any of the other theme JS files as mentioned below (and change the theme property of the plugin) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/themes/krajee-svg/theme.js"></script>

    <!-- optionally if you need translation for your language then include locale file as mentioned below (replace LANG.js with your own locale file) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-star-rating@4.1.2/js/locales/LANG.js"></script>
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
    $(function() {
        $('#toggle-event').change(function() {
            if ($(this).prop('checked') == true) {
                $('#console-event').html('{{ get_starred(strtok(auth()->user()->name, ' ')) }}')
            } else if ($(this).prop('checked') == false){
                $('#console-event').html('{{ strtok(auth()->user()->name, ' ') }}')
            }
        });
    });

    $(function() {
        $('#edit-event-toogle').change(function() {
            if ($(this).prop('checked') == true) {
                $('#edit-event').html('{{ hideReview(strtok(auth()->user()->name, ' ')) }}')
            } else if ($(this).prop('checked') == false){
                $('#edit-event').html('{{ strtok(auth()->user()->name, ' ') }}')
            }
        });
    });

    // initialize with defaults
    $("#input-id").rating({
        showClear: 'false',
        showCaption: 'false'
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
        // update employee ajax request
        $("#cancelled_orders_form").submit(function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            $("#cancelled_orders_btn").text('Tunggu..');
            $("#cancelled_orders_btn").prop('disabled', true);
            $.ajax({
                url: '{{ route('pembeli.updateWaitingPayment') }}',
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 400) {
                        showError('cancellation_note', response.messages.cancellation_note);
                        $("#cancelled_orders_btn").text('Konfirmasi');
                        $("#cancelled_orders_btn").prop('disabled', false);
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Memperbarui!',
                            'Berhasil membatalkan pesanan!',
                            'success'
                        )
                        $("#cancelledOrderModal").modal('hide');
                        $("#cancelled_orders_form")[0].reset();
                        $("#cancelled_orders_btn").text('Konfirmasi');
                        $("#cancelled_orders_btn").prop('disabled', false);
                        window.setTimeout(function(){location.reload()},1000)
                    }
                }
            });
        });

        // add new employee ajax request
        $("#add_employee_form").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $("#add_employee_btn").text('Tunggu..');
            $("#add_employee_btn").prop('disabled', true);
            $.ajax({
            url: '{{ route('add.pembeli.review') }}',
            method: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 400) {
                    showError('stars_rated', response.messages.stars_rated);
                    showError('message-text', response.messages.review);
                    $("#add_employee_btn").text('Kirim');
                    $("#add_employee_btn").prop('disabled', false);
                } else if (response.status == 200){
                    Swal.fire(
                        'Membuat Ulasan!',
                        'Berhasil membuat ulasan!',
                        'success'
                    )
                    $("#reviewModal").modal('hide');
                    $("#add_employee_form")[0].reset();
                    $("#add_employee_btn").text('Kirim');
                    $("#add_employee_btn").prop('disabled', false);
                    window.setTimeout(function(){location.reload()},1000)
                }
            }
            });
        });

        // update employee ajax request
        $("#edit_employee_form").submit(function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            $("#edit_employee_btn").text('Tunggu..');
            $("#edit_employee_btn").prop('disabled', true);
            $.ajax({
                url: '{{ route('pembeli.updateUlasanSaya') }}',
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 400) {
                        showError('reviewed_stars_rated', response.messages.stars_rated);
                        showError('reviewed_message-text', response.messages.review);
                        $("#edit_employee_btn").text('Kirim');
                        $("#edit_employee_btn").prop('disabled', false);
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Memperbarui!',
                            'Berhasil memperbarui ulasan!',
                            'success'
                        )
                        $("#editUlasanModal").modal('hide');
                        $("#edit_employee_form")[0].reset();
                        $("#edit_employee_btn").text('Kirim');
                        $("#edit_employee_btn").prop('disabled', false);
                        window.setTimeout(function(){location.reload()},1000)
                    }
                }
            });
        });

        // update employee ajax request
        $("#order_completed").submit(function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('pembeli.orderCompleted') }}',
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 400) {
                        showError('cancellation_note', response.messages.cancellation_note);
                    } else if (response.status == 200) {
                        window.setTimeout(function(){location.reload()},1000)
                    }
                }
            });
        });
    });
    </script>
@endsection
