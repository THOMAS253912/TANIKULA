@extends('costumer.template')
@section('title','Detail Pesanan')

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
                            <button type="button" class="btn border bg-danger text-white" data-bs-toggle="modal" data-bs-target="#showOrderModal">
                                Batalkan Pesanan
                            </button>
                            <a href="{{ $order->payment_url }}" class="d-inline-flex btn border" style="background: #ffff; color: #16A085;">
                                Lanjutkan Pembayaran
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Alamat -->
<div class="modal fade" id="showOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Alasan Pembatalan</h5>
            </div>
            <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
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
                    <button type="submit" id="edit_employee_btn" class="btn btn-primary btn-lg mb-1" style="background-color: #16A085;">
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
        $("#edit_employee_form").submit(function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            $("#edit_employee_btn").text('Tunggu..');
            $("#edit_employee_btn").prop('disabled', true);
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
                        $("#edit_employee_btn").text('Konfirmasi');
                        $("#edit_employee_btn").prop('disabled', false);
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Memperbarui!',
                            'Berhasil membatalkan pesanan!',
                            'success'
                        )
                        $("#showOrderModal").modal('hide');
                        $("#edit_employee_form")[0].reset();
                        $("#edit_employee_btn").text('Konfirmasi');
                        $("#edit_employee_btn").prop('disabled', false);
                        window.location = '{{ route('pembeli.waitingPayment') }}';
                    }
                }
            });
        });
    });
    </script>
@endsection
