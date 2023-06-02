@extends('admin.template')
@section('title', 'Detail Pesanan')

@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- MULAI STYLE CSS -->
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel='stylesheet'
    href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
    integrity="sha256-pODNVtK3uOhL8FUNWWvFQK0QoQoV3YA9wGGng6mbZ0E=" crossorigin="anonymous" />
<link rel="stylesheet" href="{{ asset('css/LineIcons.3.0.css') }}" />
<!-- AKHIR STYLE CSS -->
<style>
    /* STYLE CSS */
    .dt-buttons {
        display: none;
    }

    .rating-produkView div {
        color: #f0d800;
        font-size: 10px;
        font-family: sans-serif;
        font-weight: 800;
        text-transform: uppercase;
    }

</style>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="d-md-flex justify-content-between align-items-center mb-4">
                            <p class="fw-normal mb-0" style="font-size: 18px">Invoice ID :</p>
                            <p class="font-weight-bold mb-0" style="font-size: 18px">#{{ $order->code }}</p>
                        </div>
                        <div class="card shadow-0 border mb-4">
                            <div class="card-body">
                                <h5>Pesanan {{ $order->address->recipients_name }}</h5>
                                <hr style="background-color: #e0e0e0; opacity: 1;">
                                <div>
                                    <p class="font-weight-bold text-black text-uppercase mb-2">Alamat Tagihan</p>
                                    <div>
                                        <p class="text-black m-0">{{ $order->address->recipients_name }}
                                            <span class="fw-normal">({{$order->address->address_label}})
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-black m-0">
                                            @if ($order->address->village_id && $order->address->district_id &&
                                            $order->address->city_id && $order->address->province_id != null)
                                            {{ $order->address->village->name }}, Kecamatan
                                            {{ $order->address->district->name }}, {{ $order->address->city->name }},
                                            Provinsi {{ $order->address->province->name }}
                                            @endif, {{$order->address->postal_code}}. [TaniKula Note:
                                            {{$order->address->complete_address}}
                                            {{$order->address->note_for_courier}}].</p>
                                        <p class="text-black m-0">
                                            @if ($order->address->district_id != null)
                                            {{ $order->address->district->name }},
                                            @endif{{$order->address->postal_code}}.
                                        </p>
                                        <p class="text-black m-0 pt-3"><span> Email : </span>
                                            {{$order->user->email}}</p>
                                        <p class="text-black m-0"><span> No Telp : </span>
                                            {{$order->address->telp}}</p>
                                        <p class="text-black m-0"><span> Kode Pos : </span>
                                            {{$order->address->postal_code}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-0 border mb-4">
                            <div class="card-body">
                                <!-- End Navbar -->
                                <div class="card-body px-0 pb-2">
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-black text-xxs font-weight-bolder">
                                                        Foto Produk</th>
                                                    <th
                                                        class="text-uppercase text-black text-xxs font-weight-bolder ps-2">
                                                        Nama Produk</th>
                                                    <th
                                                        class="text-center text-uppercase text-black text-xxs font-weight-bolder">
                                                        Qty</th>
                                                    <th
                                                        class="text-center text-uppercase text-black text-xxs font-weight-bolder">
                                                        Harga Satuan</th>
                                                    <th
                                                        class="text-center text-uppercase text-black text-xxs font-weight-bolder">
                                                        Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $total = 0;
                                                $totalPrice = 0;
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
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $orderitem->product->name }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span
                                                            class="text-xs font-weight-bold">{{ $orderitem->qty }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-xs font-weight-bold">Rp.
                                                            {{ number_format($orderitem->price, 0) }}</span>
                                                    </td>
                                                    @php
                                                    if ($orderitem->product->discount) {
                                                    $discount += $orderitem->product->price_discount -
                                                    $orderitem->product->price;
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
                                                            class="text-xs font-weight-bold">Rp.{{ number_format($subTotal, 0) }}</span>
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
                                <p class="font-weight-bold mb-0">Rincian Pesanan</p>

                                <p class="text-muted mb-0">Invoice ID : #{{ $order->code }}</p>
                                <p class="text-muted mb-0">Tanggal Pemesanan :
                                    {{ \App\Helpers\General::datetimeFormat($order->order_date) }}</p>
                                <p class="text-muted mb-0 text-capitalize">Status Pesanan :
                                    {{$order->status}}</p>
                                <p class="text-muted mb-0 text-capitalize">Status Pembayaran :
                                    {{$order->payment_status}}</p>
                            </div>

                            <div class="mt-3 mt-md-0">
                                <p class="text-muted mb-0"><span class="font-weight-bold me-4">Total</span> Rp.
                                    {{ number_format($total, 0) }}</p>
                                <p class="text-muted mb-0"><span class="font-weight-bold me-4">Ongkir</span> Rp.
                                    {{ number_format($ongkirTotal, 0) }}</p>
                                <p class="text-muted mb-0"><span class="font-weight-bold me-4">Diskon</span> Rp.
                                    {{ number_format($discount, 0) }}</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="border-0 px-4 bg-primary shadow-primary border-radius-lg py-5 d-md-flex align-items-center justify-content-between">
                        <h5 class="text-white text-uppercase mb-0">Total
                            Pembayaran: <span class="d-flex h2 mb-0 text-white text-capitalize">Rp.
                                {{ number_format($order->total_price, 0) }}</span></h5>
                        @if ($order->status == 'confirmed')
                        <div class="d-block mt-3 mt-md-0">
                            <form action="#" method="POST" id="edit_employee_form">
                                @csrf
                                <input type="hidden" value="{{$order->id}}" name="emp_id">
                                <button type="submit" class="d-inline-flex btn border"
                                    style="background: #ffff; color: #16A085;">
                                    Pesanan Siap Dikirim
                                </button>
                            </form>
                        </div>
                        @elseif ( $order->status == 'completed')
                            @if ($order->review == 'reviewed')
                            <button type="button" class="mt-3 shadow-none mt-md-0 btn border" style="background: #FFFACD;"
                                data-toggle="modal" data-target="#editReviewModal">
                                Lihat Ulasan
                            </button>
                            @endif
                        @elseif ($order->status == 'cancelled')
                        <button type="button" class="mt-3 mt-md-0 btn border bg-light" data-toggle="modal" data-target="#rincianPembatalan">
                            Rincian Pembatalan
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@php
    function get_starred($str) {
        $len = strlen($str);
        return substr($str, 0, 1).str_repeat('*', $len - 2).substr($str, $len - 1, 1);
    }
@endphp
{{-- Lihat Ulasan --}}
<div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <style>
        #style-1::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px #007bff;
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
            -webkit-box-shadow: inset 0 0 6px #007bff;
            background-color: #007bff;
        }
    </style>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border">
                <h5 class="modal-title" id="exampleModalLabel">Ulasan Pembeli</h5>
            </div>
            <div class="modal-body text-start text-black p-4" id="style-1">
                <form action="#" method="POST" id="add_employee_form" accept-charset="utf-8"
                    enctype="multipart/form-data">
                    @csrf
                    <div>
                        @foreach ($reviews as $review)
                        <input type="hidden" name="review_id[]" value="{{ $review->id }}">
                        <div class="d-flex align-items-center pt-3">
                            @if ($userInfo->image)
                            <img src="{{asset('../storage/profile/'. $userInfo->image)}}"
                                class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 55px; height: 55px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                alt="{{ $userInfo->user->name }}">
                            @else
                            <img src="{{ asset('stisla/assets/img/example-image.jpg') }}"
                                class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 55px; height: 55px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                alt="{{ $userInfo->user->name }}">
                            @endif
                            <div>
                                <p class="my-0 mx-3 text-xs font-weight-bold">
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
                                            @for ($j = $review->stars_rated+1; $j <=5; $j++) <i class="lni lni-star">
                                                </i>
                                                @endfor
                                    </div>
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <p class="my-1 mx-3 text-xs">
                                    {{ \App\Helpers\General::datetimeFormat($review->created_at) }}</p>
                            </div>
                        </div>
                        <div class="m-3">
                            <p class="my-0 mx-3 text-xs font-weight-bold">{{ $review->review }}</p>
                        </div>

                        <div class="d-flex align-items-center py-2 rounded bg-light px-3">
                            @if ($review->product->photo_product->count() > 0)
                            @foreach ($review->product->photo_product->take(1) as
                            $photos)
                            @if ($photos->name)
                            <img src="{{ asset('../storage/produk/'.$photos->name) }}" class="img-fluid rounded"
                                style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                alt="{{ $review->product->name }}">
                            @else
                            <img src="{{ asset('img/no-image.png') }}" class="img-fluid rounded"
                                style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                alt="{{ $review->product->name }}">
                            @endif
                            @endforeach
                            @else
                            <img src="{{ asset('img/no-image.png') }}" class="img-fluid rounded"
                                style="width: 7rem; height: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                alt="{{ $review->product->name }}">
                            @endif
                            <div>
                                <p class="my-0 mx-3 text-xs font-weight-bold text-truncate col-9">
                                    {{ $review->product->name }}</p>
                            </div>
                        </div>
                        @if ($review->reply_review)
                        <div class="my-2">
                            <label for=""><i class="bi bi-arrow-return-right"></i> Balasan Ulasan</label>
                            <textarea class="form-control border px-3" placeholder="Balasan ulasan untuk pembeli."
                                name="reply_review[]" style="height: 6rem" rows="5"
                                id="message-text">{{ $review->reply_review }}</textarea>
                        </div>
                        @else
                        <div class="my-2">
                            <textarea class="form-control border px-3" placeholder="Balasan ulasan untuk pembeli."
                                name="reply_review[]" style="height: 6rem" rows="5" id="message-text"></textarea>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="modal-footer d-flex justify-content-center border-top-0 pt-4">
                        <button type="submit" id="add_employee_btn" style="color: white"
                            class="btn shadow-none border bg-primary">
                            Kirim Balasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Ulasan --}}
<div class="modal fade" id="rincianPembatalan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title align-middle" id="exampleModalLabel"><span class="bi bi-arrow-left pr-3 h4 align-middle" data-bs-dismiss="modal"></span>Rincian Pembatalan</h5>
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
    //CSRF TOKEN PADA HEADER
    //Script ini wajib krn kita butuh csrf token setiap kali mengirim request post, patch, put dan delete ke server
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $(function () {
        // add new employee ajax request
        $("#add_employee_form").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $("#add_employee_btn").text('Tunggu..');
            $("#add_employee_btn").prop('disabled', true);
            $.ajax({
                url: '{{ route('gapoktan.replyReview') }}',
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 400) {
                        $("#add_employee_btn").text('Kirim Balasan');
                        $("#add_employee_btn").prop('disabled', false);
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Berhasil!',
                            'Berhasil membuat komentar pada ulasan pembeli!',
                            'success'
                        )
                        $("#reviewModal").modal('hide');
                        $("#add_employee_form")[0].reset();
                        $("#add_employee_btn").text('Kirim Balasan');
                        $("#add_employee_btn").prop('disabled', false);
                        window.setTimeout(function () {
                            location.reload()
                        }, 1000)
                    }
                }
            });
        });

        // update employee ajax request
        $("#edit_employee_form").submit(function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('gapoktan.updateOrder') }}',
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
                        window.setTimeout(function () {
                            location.reload()
                        }, 1000)
                    }
                }
            });
        });
    });

</script>
@endsection
