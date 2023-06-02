@extends('costumer.template')
@section('title','Wishlist')

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

    .opacity-90 {
        opacity: 90%;
    }

    .top-30{
        top: 90px;
    }
    </style>
@endsection

@section('content')
<div class="container-fluid px-2 px-md-4 mb-5">
    <div class="page-header min-height-300 border-radius-xl mt-4"
        style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <span class="mask  bg-primary  opacity-6"></span>
    </div>
    <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="row gx-4 mb-2">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    @if ($userInfo->image)
                    <img id="image_preview" src="{{asset('../storage/profile/'. $userInfo->image)}}" alt="profile_image"
                        class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 80px; height: 80px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                    @else
                    <img id="image_preview" src="{{ asset('../stisla/assets/img/example-image.jpg') }}" alt="profile_image"
                        class="rounded-circle shadow-sm" style="border: 1px solid #16A085; width: 80px; height: 80px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                    @endif
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        {{$userInfo->user->name}}
                    </h5>
                </div>
                <div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input hidden" style="width: 0px;" accept="image/*" id="image" name="image">
                        <label class="custom-file-label" for="image"><i class="bi bi-camera h-4"></i> Ubah foto</label>
                        <label class="custom-file-label ps-5" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" for="">
                            <i class="bi bi-three-dots h-4"></i>
                        </label>
                        <ul class="dropdown-menu" style="border: 1px solid" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item deletePhoto" id="{{ $userInfo->id }}" style="font-size: 12px; color: red;" href="#"><i class="bi bi-trash"></i> Hapus Foto Profil</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" id="id" value="{{ $userInfo->id }}">
            <div class="col-lg-5 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-fill p-1">
                        <li class="nav-item">
                            <a class="btn {{ Request::is('pembeli') ? 'active text-white bg-primary shadow' : 'border' }}" onclick="pembeli_dashboard('{{ url('pembeli') }}')" href="#">
                                <span class="ms-1 fw-bold">Biodata Diri</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn {{ Request::is('pembeli/alamat*') ? 'active text-white bg-primary shadow' : 'border' }}" onclick="pembeli_alamat('{{ url('pembeli/alamat') }}')" href="#">
                                <span class="ms-1 fw-bold">Daftar Alamat</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="mb-2 ps-3">
                    <h6 class="mb-1">Wishlist</h6>
                    <p class="text-sm">Produk favorit yang dipilih.</p>
                </div>
                <div class="row mx-4 mx-sm-0 WishlistItems">
                    @if ($wishlist->count())
                    @foreach ($wishlist as $item)
                    <div class="col-xl-3 col-md-6 mb-xl-0 mt-3" id="product_data">
                        <div class="card card-blog border rounded bg-white shadow card-plain {{ $item->product->stoke === 0 ? 'bg-light opacity-90' : '' }}" style="height: 26rem">
                            <div class="{{ $item->product->stoke === 0 ? 'bg-light opacity-90' : '' }}">
                                <a href="{{ url('home/'.$item->product->slug) }}">
                                    @if ($item->product->stoke === 0)
                                    <div style="z-index: 3" class="badge bg-danger px-3 position-absolute top-30 start-50 translate-middle"><h5 class="text-white m-0">Stok Habis</h5></div>
                                    @endif
                                    @if ($item->product->photo_product->count() > 0)
                                    @foreach ($item->product->photo_product->take(1) as $photos)
                                    @if ($photos->name)
                                    <img src="{{ asset('../storage/produk/'.$photos->name) }}" alt="{{ $item->name }}"
                                        class="rounded-top border-bottom"
                                        style="width: 100%; height: 11rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                    @else
                                    <img src="{{ asset('img/no-image.png') }}" alt="{{ $item->name }}"
                                        class="rounded-top border-bottom"
                                        style="width: 100%; height: 11rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                    @endif
                                    @endforeach
                                    @else
                                    <img src="{{ asset('img/no-image.png') }}" alt="{{ $item->name }}"
                                        class="rounded-top border-bottom"
                                        style="width: 100%; height: 11rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                    @endif
                                </a>
                            </div>
                            <div class="card-body p-3 {{ $item->product->stoke === 0 ? 'bg-light opacity-90' : '' }}">
                                @if ($item->product->discount != 0)
                                <div class="d-flex justify-content-between">
                                    <p class="m-0 text-sm"><a
                                        class="text-secondary" href="{{ url('product-category/'.$item->product->product_category->slug) }}">{{ $item->product->product_category->name }}</a>
                                    </p>
                                    <p class="small m-0 badge bg-danger">{{ $item->product->discount }}% OFF</p>
                                </div>
                                @else
                                <p class="m-0 text-sm"><a
                                    class="text-secondary" href="{{ url('product-category/'.$item->product->product_category->slug) }}">{{ $item->product->product_category->name }}</a>
                                </p>
                                @endif
                                <p class="small m-0">Stok tersisa {{ $item->product->stoke }}</p>
                                <h6 class="title">
                                    <a href="{{ url('home/'.$item->product->slug) }}"
                                        style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 1; overflow: hidden;">{{ $item->product->name }}</a>
                                </h6>
                                <div>
                                    @if ($item->product->stock_out)
                                    <span class="small">{{$item->product->stock_out}} Terjual</span>
                                    @else
                                    <span class="small">0 Terjual</span>
                                    @endif
                                </div>
                                @php
                                $reviews = App\Models\Review::where('product_id', $item->product->id)->get();
                                $ratingSum = App\Models\Review::where('product_id',
                                $item->product->id)->sum('stars_rated');
                                if ($reviews->count() > 0){
                                $ratingValue = $ratingSum / $reviews->count();
                                } else {
                                $ratingValue = 0;
                                }
                                $rateNum = number_format($ratingValue)
                                @endphp
                                @for ($i = 1; $i <= $rateNum; $i++) <span><i class="lni lni-star-filled" style="color: #f0d800;"></i></span>
                                    @endfor
                                    @for ($j = $rateNum+1; $j <= 5; $j++) <span><i class="lni lni-star"></i>
                                        </span>
                                        @endfor
                                        <p class="mb-4 text-sm fw-bold">
                                    Rp. {{ number_format($item->product->price, 0) }}
                                </p>
                                <input type="hidden" name="quantity" class="form-control qty-input text-center"
                                    value="1">
                                <input type="hidden" value="{{ $item->product_id }}" id="prod_id">
                                <div class="d-flex align-items-center justify-content-between">
                                    @if ($item->product->stoke === 0)
                                    <button type="button" disabled
                                        class="btn btn-outline-primary btn-sm mb-0">+
                                        Keranjang</button>
                                    @else
                                    <button type="button" id="addToCartBtn"
                                        class="btn btn-outline-primary btn-sm mb-0">+
                                        Keranjang</button>
                                    @endif
                                    <button type="button" id="delete-cart-wishlistItem"
                                        class="btn btn-outline-primary btn-sm mb-0">
                                        <i class="bi bi-trash h-5 text-danger"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div id="app">
                        <section class="section">
                            <div class="container">
                                <div class="page-error">
                                    <div class="page-inner">
                                        <div class="page-description">
                                            Tidak ada produk favorit yang dipilih!
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ url('new-product') }}"
                                                class="btn btn-outline-primary btn-sm mb-0">
                                                Belanja Sekarang
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    @endif
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

    <!-- AKHIR LIBARARY JS -->

    <!-- JAVASCRIPT -->
    <script>
    $(document).ready(function () {
        $("#image").change(function(e) {
            const file = e.target.files[0];
            let url = window.URL.createObjectURL(file);
            $("#image_preview").attr('src', url);
            let fd = new FormData();
            fd.append('image', file);
            fd.append('id', $("#id").val());
            fd.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('pembeli.pengaturan.image') }}',
                method: 'POST',
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res){
                    if(res.status == 200) {
                        // $("#profile_alert").html(showMessage('success', res.messages));
                        iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                            title: 'Berhasil',
                            message: res.messages,
                            position: 'topRight'
                        });
                        $("#image").val('');
                    }
                }
            });
        });

        // $('#addToCartBtn').click(function (e) {
        $(document).on('click', '#addToCartBtn', function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var product_id = $(this).closest('#product_data').find('#prod_id').val();
        var product_qty = $(this).closest('#product_data').find('.qty-input').val();

        $("#addToCartBtn").prop('disabled', true);
            $.ajax({
                method: "POST",
                url: "/add-to-cart",
                data: {
                    'product_id': product_id,
                    'product_qty': product_qty,
                },
                success: function (response) {
                    if (response.status == 'Silahkan login!') {
                        window.location = '/login';
                    } else {
                        if (response.status == 'Kuantiti tidak boleh melebihi stok')
                        {
                            $("#addToCartBtn").prop('disabled', false);
                            iziToast.warning({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                title: 'Gagal',
                                message: response.status,
                                position: 'topRight'
                            });
                        }
                            else
                        {
                            $("#addToCartBtn").prop('disabled', false);
                            iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                title: 'Berhasil',
                                message: response.status,
                                position: 'topRight'
                            });
                            window.setTimeout(function(){location.reload()},1000)
                        }
                    }
                }
            });
        });

        // $('#delete-cart-wishlistItem').click(function (e) {
        $(document).on('click', '#delete-cart-wishlistItem', function (e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var product_id = $(this).closest('#product_data').find('#prod_id').val();

            $.ajax({
                method: "POST",
                url: "/delete-cart-wishlist",
                data: {
                    'product_id': product_id,
                },
                success: function (response) {
                    // $('.WishlistItems').load(location.href + '.WishlistItems');
                    iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                        title: 'Berhasil',
                        message: response.status,
                        position: 'topRight'
                    });
                    window.setTimeout(function(){location.reload()},1000);
                }
            });
        });
    });
    </script>
@endsection
