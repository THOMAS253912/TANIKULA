@extends('pages.template3')
@section('title', 'Order')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
        integrity="sha256-pODNVtK3uOhL8FUNWWvFQK0QoQoV3YA9wGGng6mbZ0E=" crossorigin="anonymous" />
    <style>
        /* Style */
        .icon-shape {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            vertical-align: middle;
        }

        .icon-sm {
            width: 2rem;
            height: 2rem;
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

        .page-error img {
            width: 30rem;
        }

        .page-error .page-description {
            padding-top: 30px;
            font-size: 18px;
            font-weight: 400;
            color: color: var(--primary);
            ;
        }

        @media (max-width: 575.98px) {
            .page-error {
                padding-top: 0px;
            }
        }
    </style>
@endsection

@section('content')
    <section class="h-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-10 col-xl-12">
                    <div class="card rounded" style="border: 1px solid #16A085;">
                        <div class="d-md-flex flex-row justify-content-between align-items-center card-header px-4 py-5"
                            style="background: #16A085;">
                            @if (!$order->isPaid())
                                <div>
                                    <h5 class="mb-0 text-white">Pesanan Anda telah dibuat.</h5>
                                    <h5 class="mb-0 text-white">Silahkan melanjutkan untuk pembayaran!</h5>
                                    <input type="hidden" name="passingIdOrder" class="text-white"
                                        value="{{ $order->id }}">
                                </div>
                            @else
                                <div>
                                    <h5 class="mb-0 text-white">Pembayaran Berhasil.</h5>
                                    <h5 class="mb-0 text-white">Terima Kasih, pesanan anda sedang diproses!</h5>
                                </div>
                            @endif
                            <script>
                                var isExpired = false;
                                CountDownTimer('{{ $order->order_date }}', 'countdown');

                                function CountDownTimer(dt, id) {
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

                                            function deleteOrders() {
                                                var id = $("input[name=passingIdOrder]").val();
                                                $.ajax({
                                                    method: "GET",
                                                    url: '/delete-orders/' + id,
                                                    success: function(response) {
                                                        iziToast.warning({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                                            title: 'Peringatan',
                                                            message: 'Maaf pesanan anda sudah kadaluarsa',
                                                            position: 'topRight'
                                                        });
                                                        window.setTimeout(function() {
                                                            location.reload()
                                                        }, 3000);
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
                            @if (!$order->isPaid())
                                <div class="mt-md-0 mt-3">
                                    <h6 class="mb-0 text-white" id="countdown"></h6>
                                </div>
                            @endif
                        </div>
                        <div class="card-body p-4">
                            <div class="d-md-flex justify-content-between align-items-center mb-4">
                                <p class="fw-normal mb-0" style="font-size: 18px">Invoice ID :</p>
                                <p class="fw-bold mb-0" style="font-size: 18px">#{{ $order->code }}</p>
                            </div>
                            <div class="card mb-4" style="border: 1px solid #16A085;">
                                <div class="card-body">
                                    <h5>Pesanan Anda</h5>
                                    <hr style="background-color: #e0e0e0; opacity: 1;">
                                    <div>
                                        <p class="fw-bold text-secondary text-uppercase mb-2">Alamat Tagihan</p>
                                        <div>
                                            <p class="text-secondary">{{ $order->address->recipients_name }} <span
                                                    class="fw-normal">({{ $order->address->address_label }}) </span>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-secondary">
                                                @if (
                                                    $order->address->village_id &&
                                                        $order->address->district_id &&
                                                        $order->address->city_id &&
                                                        $order->address->province_id != null)
                                                    {{ $order->address->village->name }}, Kecamatan
                                                    {{ $order->address->district->name }},
                                                    {{ $order->address->city->name }}, Provinsi
                                                    {{ $order->address->province->name }}
                                                @endif, {{ $order->address->postal_code }}. [TaniKula
                                                Note: {{ $order->address->complete_address }}
                                                {{ $order->address->note_for_courier }}].
                                            </p>
                                            <p class="text-secondary">
                                                @if ($order->address->district_id != null)
                                                    {{ $order->address->district->name }},
                                                @endif{{ $order->address->postal_code }}.
                                            </p>
                                            <p class="text-secondary pt-3"><span> Email : </span> {{ $order->user->email }}
                                            </p>
                                            <p class="text-secondary"><span> No Telp : </span> {{ $order->address->telp }}
                                            </p>
                                            {{-- <p class="text-black"><span> Kode Pos : </span>
                                            {{$order->address->postal_code}}</p> --}}
                                        </div>
                                    </div>
                                    {{-- <div class="mt-3 mt-md-0 col-md-6 col-12">
                                        <p class="fw-bold text-black text-uppercase mb-2">Rincian Pesanan</p>
                                        <div>
                                            <p class="text-black"><span> Invoice ID : </span> #{{ $order->code }}</p>
                                <p class="text-black">{{ \App\Helpers\General::datetimeFormat($order->order_date) }}</p>
                                <p class="text-black text-capitalize"><span> Status Pesanan : </span> {{$order->status}}
                                </p>
                                <p class="text-black text-capitalize"><span> Status Pembayaran : </span>
                                    {{$order->payment_status}}</p>
                                </div>
                                </div> --}}
                                </div>
                            </div>
                            <div class="card mb-4" style="border: 1px solid #16A085;">
                                <div class="card-body">
                                    <!-- End Navbar -->
                                    <div class="card-body px-0 pb-2">
                                        <div class="table-responsive p-0">
                                            <table class="table table-borderless align-items-center mb-0">
                                                <thead class="border-bottom-0">
                                                    <tr>
                                                        <th class="text-center text-uppercase text-secondary opacity-7">
                                                            Foto Produk</th>
                                                        <th class="text-center text-uppercase text-secondary opacity-7">
                                                            Nama Produk</th>
                                                        <th class="text-center text-uppercase text-secondary opacity-7">
                                                            Qty</th>
                                                        <th class="text-center text-uppercase text-secondary opacity-7">
                                                            Harga Satuan</th>
                                                        <th class="text-center text-uppercase text-secondary opacity-7">
                                                            Subtotal</th>
                                                    </tr>
                                                </thead>
                                                @php
                                                    $total = 0;
                                                    $ongkirTotal = 0;
                                                    $totalQty = 0;
                                                    $discount = 0;
                                                @endphp
                                                <tbody class="border-top-0">
                                                    @foreach ($order->orderItems as $orderitem)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex px-2 py-1 justify-content-center">
                                                                    @if ($orderitem->product->photo_product->count() > 0)
                                                                        @foreach ($orderitem->product->photo_product->take(1) as $photos)
                                                                            @if ($photos->name)
                                                                                <img src="{{ asset('../storage/produk/' . $photos->name) }}"
                                                                                    class="img-fluid rounded"
                                                                                    style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                                                                    alt="{{ $orderitem->product->name }}">
                                                                            @else
                                                                                <img src="{{ asset('img/no-image.png') }}"
                                                                                    class="img-fluid rounded"
                                                                                    style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                                                                    alt="{{ $orderitem->product->name }}">
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <img src="{{ asset('img/no-image.png') }}"
                                                                            class="img-fluid rounded"
                                                                            style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                                                            alt="{{ $orderitem->product->name }}">
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <p class="text-xs font-weight-bold mb-0">
                                                                    {{ $orderitem->product->name }}</p>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <span
                                                                    class="text-secondary text-xs font-weight-bold">{{ $orderitem->qty }}</span>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <span class="text-secondary text-xs font-weight-bold">Rp.
                                                                    {{ number_format($orderitem->price, 0) }}</span>
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
                                    <p class="text-muted mb-0 text-capitalize">Status Pesanan : {{ $order->status }}</p>
                                    <p class="text-muted mb-0 text-capitalize">Status Pembayaran :
                                        {{ $order->payment_status }}</p>
                                </div>
                                <div class="mt-3 mt-md-0">
                                    <p class="text-muted mb-0"><span class="fw-bold me-4">Total</span> Rp.
                                        {{ number_format($total, 0) }}</p>
                                    <p class="text-muted mb-0"><span class="fw-bold me-4">Ongkir</span> Rp.
                                        {{ number_format($ongkirTotal, 0) }}</p>
                                    <p class="text-muted mb-0"><span class="fw-bold me-4">Diskon</span> Rp.
                                        {{ number_format($discount, 0) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 px-4 rounded-bottom py-5 d-md-flex align-items-center justify-content-between "
                            style="background-color: #16A085; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                            <h5 class="text-white text-uppercase mb-0">Total
                                Pembayaran: <span class="h2 mb-0 ms-2 text-capitalize">Rp.
                                    {{ number_format($order->total_price, 0) }}</span></h5>
                            @if (!$order->isPaid())
                                <a href="{{ $order->payment_url }}" target="blank" class="mt-3 mt-md-0 btn border"
                                    style="background: #ffff; color: #16A085;">
                                    Lanjutkan Pembayaran
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"
        integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js"
        integrity="sha256-siqh9650JHbYFKyZeTEAhq+3jvkFCG8Iz+MHdr9eKrw=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
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
                var formData = new FormData(this);
                $("#add_employee_btn").text('Tunggu..');
                $("#add_employee_btn").prop('disabled', true);
                $.ajax({
                    url: '{{ route('add-alamat-costumer') }}',
                    method: 'post',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            showError('recipients_name', response.messages.recipients_name);
                            showError('telp', response.messages.telp);
                            showError('address_label', response.messages.address_label);
                            showError('postal_code', response.messages.postal_code);
                            showError('complete_address', response.messages.complete_address);
                            showError('note_for_courier', response.messages.note_for_courier);
                        } else if (response.status == 200) {
                            Swal.fire(
                                'Menambahkan!',
                                'Alamat Berhasil Ditambahkan!',
                                'success'
                            )
                            fetchAllEmployees();
                            $("#TambahAlamat").modal('hide');
                            $("#add_employee_form")[0].reset();
                        }
                        $("#add_employee_btn").text('Simpan');
                        $("#add_employee_btn").prop('disabled', false);
                        window.location.reload();
                    }
                });
            });

            // edit employee ajax request
            $(document).on('click', '.editAlamat', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('edit.alamat.costumer') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#recipients_name").val(response.recipients_name);
                        $("#telp").val(response.telp);
                        $("#address_label").val(response.address_label);
                        $("#city").val(response.city);
                        $("#postal_code").val(response.postal_code);
                        $("#complete_address").val(response.complete_address);
                        $("#note_for_courier").val(response.note_for_courier);
                        $("#main_address").html(`
                        <input class="form-check-input mt-0" type="checkbox" ${response.main_address ? 'checked' : ''} name="main_address">
                        <span class="px-3">Jadikan Alamat Utama</span>
                    `);
                        $("#emp_id").val(response.id);
                    }
                });
            });

            // update employee ajax request
            $("#edit_employee_form").submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                $("#edit_employee_btn").text('Tunggu..');
                $("#edit_employee_btn").prop('disabled', true);
                $.ajax({
                    url: '{{ route('update.alamat.costumer') }}',
                    method: 'post',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            showError('recipients_name', response.messages.recipients_name);
                            showError('telp', response.messages.telp);
                            showError('address_label', response.messages.address_label);
                            showError('postal_code', response.messages.postal_code);
                            showError('complete_address', response.messages.complete_address);
                            showError('note_for_courier', response.messages.note_for_courier);
                        } else if (response.status == 200) {
                            Swal.fire(
                                'Memperbarui!',
                                'Alamat Berhasil diperbarui!',
                                'success'
                            )
                            fetchAllEmployees();
                            $("#EditAlamat").modal('hide');
                            $("#edit_employee_form")[0].reset();
                        }
                        $("#edit_employee_btn").text('Simpan');
                        $("#edit_employee_btn").prop('disabled', false);
                        window.location.reload();
                    }
                });
            });

            // fetch all employees ajax request
            fetchAllEmployees();

            function fetchAllEmployees() {
                $.ajax({
                    url: '{{ route('alamat-fetchAll') }}',
                    method: 'get',
                    success: function(response) {
                        $("#show_all_employees").html(response);
                    }
                });
            }
        });
    </script>
@endsection
