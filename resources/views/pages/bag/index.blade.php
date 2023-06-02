@extends('pages.template3')
@section('title', 'Keranjang')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        /* padding-bottom: 60px; */
        text-align: center;
        display: table;
    }

    .page-error .page-inner {
        display: table-cell;
        width: 100%;
        vertical-align: middle;
    }

    .page-error img {
        width: 15rem;
    }

    .page-error .page-description {
        padding-top: 30px;
        font-size: 15px;
        font-weight: 400;
        color: color: var(--primary);;
    }

    @media (max-width: 575.98px) {
        .page-error {
            padding-top: 0px;
        }
    }

    .opacity-90 {
        opacity: 70%;
    }

    .keranjang_barang {
        display: flex;
        font-size: 16px;
        background: #fff;
        position: fixed;
        bottom: 0px;
        z-index: 3;
        cursor: pointer;
        -webkit-transition: all .3s ease-out 0s;
        transition: all .3s ease-out 0s;
        border-radius: 4px;
    }
</style>
@endsection

@section('content')
<!-- Start Item Details -->
<section class="item-details section bg-white overflow-hidden">
    <div class="container">
        <div class="bg-white">
            <form action="{{ route('checkout.pembeli') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="d-flex mb-5">
                    <div class="mt-md-4 rounded col-12 col-xl-8 mb-3 mb-xl-0" style="border: 1px solid #16A085;">
                        <div class="p-5 CartItems">
                            <h2 class="mb-3 fs-3 mb-md-4">Keranjang</h2>
                            @php
                            $total = 0;
                            $totalPrice = 0;
                            $totalQty = 0;
                            @endphp
                            @if ($cartItem->count() == 0 && $cartItemOutOfStock->count() == 0)
                            <div id="app">
                                <section class="section">
                                    <div class="container">
                                        <div class="page-error">
                                            <div class="page-inner">
                                                <img src="{{ asset('img/undraw_empty_re_opql.svg') }}" alt="">
                                                <div class="page-description">
                                                    Tidak ada produk dikeranjang!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            @endif
                            @foreach ($cartItem as $item)
                            <div class="mb-4 pb-4 pb-md-0" id="product_data" style="border-bottom: 1px solid #16A085;">
                                <div class="row align-items-center mb-6 mb-md-3">
                                    <div class="col-12 col-md-12 col-lg-12 mb-6 mb-md-0">
                                        <div class="row align-items-center">
                                            <div class="d-flex checkProductCart">
                                                <input class="form-check-input" type="checkbox" name="cart_id[]"
                                                    value="{{ $item->id }}" id="checkProductCart">
                                                <input class="form-check-input" type="hidden" name="cart_qty"
                                                    value="{{ $item->product_qty }}" id="checkProductQty">
                                                <input class="form-check-input" type="hidden" name="cart_total"
                                                    value="{{ $item->product->price }}" id="checkProductTotal">
                                                <p class="fw-bold ps-3 mb-2"><i class="bi bi-shop"></i>
                                                    {{ $item->product->user->name }}</p>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3">
                                                <div class="d-flex align-items-center justify-content-center bg-light"
                                                    style="width: 160px; height: 150px;">
                                                    @if ($item->product->photo_product->count() > 0)
                                                    @foreach ($item->product->photo_product->take(1) as $photos)
                                                    @if ($photos->name)
                                                    <img class="img-fluid rounded"
                                                        style="width: 9rem; height: 7rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                                        src="{{ asset('../storage/produk/'.$photos->name) }}"
                                                        alt="{{ $item->product->name }}">
                                                    @else
                                                    <img class="img-fluid rounded"
                                                        style="width: 9rem; height: 7rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                                        src="{{ asset('img/no-image.png') }}"
                                                        alt="{{ $item->product->name }}">
                                                    @endif
                                                    @endforeach
                                                    @else
                                                    <img class="img-fluid rounded"
                                                        style="width: 9rem; height: 7rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                                        src="{{ asset('img/no-image.png') }}"
                                                        alt="{{ $item->product->name }}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2 ms-md-3 mt-md-0">
                                                @if ($item->product->discount != 0)
                                                <p class="small mb-2 badge bg-danger">{{ $item->product->discount }}%
                                                    OFF</p>
                                                @endif
                                                <h3 class="mb-2 fs-6 fw-bold"><a style="color:#16A085;"
                                                        href="{{ url('home/'.$item->product->slug) }}">{{ $item->product->name }}</a>
                                                </h3>
                                                <p class="small" style="color:#16A085;">Stok tersisa
                                                    {{ $item->product->stoke }}</p>
                                                @if ($item->product->price_discount)
                                                <span class="text-decoration-line-through text-muted text-danger"
                                                    style="font-size: 13px">Rp.
                                                    {{ number_format($item->product->price_discount, 0) }} <span
                                                        class="fs-6 fw-bold" style="color:#16A085;">Rp.
                                                        {{ number_format($item->product->price, 0) }}</span></span>
                                                @else
                                                <span>Rp. {{ number_format($item->product->price, 0) }}</span>
                                                @endif
                                                {{-- <p class="mb-0 fs-6 fw-bold mt-2">Rp. {{ number_format($item->product->price, 0) }}
                                                </p> --}}
                                            </div>
                                            <input type="hidden" value="{{ $item->product_id }}" id="prod_id">
                                            <div class="col-12 mt-3 mt-md-0">
                                                <div
                                                    class="d-flex flex-md-row flex-column-reverse justify-content-end align-items-end align-items-md-center">
                                                    <div class="d-flex flex-row mt-2 mt-md-0">
                                                        <div class="text-black pe-3">
                                                            <button class="btn addToWishlistBtn"
                                                                style="background: #16A085; color: white">+
                                                                Wishlist</button>
                                                        </div>
                                                        <div>
                                                            <button class="delete-cart-item btn btn-danger ms-3"><i
                                                                    class="lni lni-trash-can"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-8 col-md-3 form-group ps-0 ps-md-3">
                                                        <div class="d-flex justify-content-between">
                                                            <script>
                                                                var stoke = '{{ $item->product->stoke }}';
                                                            </script>
                                                            <button
                                                                class="input-group-text changeQuantity decrement-btn me-1"
                                                                style="background: #16A085; color: white">-</button>
                                                            <input type="text" name="quantity"
                                                                class="form-control qty-input text-center"
                                                                value="{{ $item->product_qty }}">
                                                            @if ($item->product->stoke > $item->product_qty)
                                                            <button
                                                                class="input-group-text changeQuantity increment-btn ms-1"
                                                                style="background: #16A085; color: white">+</button>
                                                            @else
                                                            <button disabled
                                                                class="input-group-text changeQuantity increment-btn ms-1"
                                                                style="background: #16A085; color: white">+</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @php
                                                    $total += $item->product->price * $item->product_qty;
                                                    $totalQty += $item->product_qty;
                                                    $totalPrice += $item->product->price;
                                                    @endphp
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            {{-- ========================= --}}
                            {{-- Jika Stok Produk Kosong --}}
                            {{-- ================================== --}}
                            @if ($cartItemOutOfStock->count() > 0)
                            <div class="mb-3 d-flex align-items-center border-bottom fw-bold"><i
                                    class="bi bi-bag-x h4 pe-2"></i> Produk tidak valid</div>
                            @endif
                            @foreach ($cartItemOutOfStock as $itemOutOfStock)
                            <div class="opacity-90 mb-4 pb-4 pb-md-0" id="product_outof_stock">
                                <div class="row align-items-center mb-6 mb-md-3">
                                    <div class="col-12 col-md-12 col-lg-12 mb-6 mb-md-0">
                                        <div class="row align-items-center">
                                            <div class="d-flex checkProductCart">
                                                <input disabled class="form-check-input" type="checkbox">
                                                <p class="fw-bold ps-3 mb-2"><i class="bi bi-shop"></i>
                                                    {{ $itemOutOfStock->product->user->name }}</p>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3">
                                                <div class="d-flex align-items-center justify-content-center bg-light"
                                                    style="width: 160px; height: 150px;">
                                                    @if ($itemOutOfStock->product->photo_product->count() > 0)
                                                    @foreach ($itemOutOfStock->product->photo_product->take(1) as
                                                    $photos)
                                                    @if ($photos->name)
                                                    <img class="img-fluid rounded"
                                                        style="width: 9rem; height: 7rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                                        src="{{ asset('../storage/produk/'.$photos->name) }}"
                                                        alt="{{ $itemOutOfStock->product->name }}">
                                                    @else
                                                    <img class="img-fluid rounded"
                                                        style="width: 9rem; height: 7rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                                        src="{{ asset('img/no-image.png') }}"
                                                        alt="{{ $itemOutOfStock->product->name }}">
                                                    @endif
                                                    @endforeach
                                                    @else
                                                    <img class="img-fluid rounded"
                                                        style="width: 9rem; height: 7rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                                        src="{{ asset('img/no-image.png') }}"
                                                        alt="{{ $itemOutOfStock->product->name }}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2 ms-md-3 mt-md-0">
                                                @if ($itemOutOfStock->product->discount != 0)
                                                <p class="small mb-2 badge bg-danger">
                                                    {{ $itemOutOfStock->product->discount }}% OFF</p>
                                                @endif
                                                <h3 class="mb-2 fs-6 fw-bold"><a style="color:#16A085;"
                                                        href="{{ url('home/'.$itemOutOfStock->product->slug) }}">{{ $itemOutOfStock->product->name }}</a>
                                                </h3>
                                                <p class="small" style="color:#16A085;">Habis Terjual</p>
                                                @if ($itemOutOfStock->product->price_discount)
                                                <span class="text-decoration-line-through text-muted text-danger"
                                                    style="font-size: 13px">Rp.
                                                    {{ number_format($itemOutOfStock->product->price_discount, 0) }}
                                                    <span class="fs-6 fw-bold" style="color:#16A085;">Rp.
                                                        {{ number_format($itemOutOfStock->product->price, 0) }}</span></span>
                                                @else
                                                <span>Rp. {{ number_format($itemOutOfStock->product->price, 0) }}</span>
                                                @endif
                                            </div>
                                            <input type="hidden" value="{{ $itemOutOfStock->product_id }}"
                                                id="prod_id_outof_stock">
                                            <div class="col-12 mt-3 mt-md-0">
                                                <div
                                                    class="d-flex flex-md-row flex-column-reverse justify-content-end align-items-end align-items-md-center">
                                                    <div class="d-flex flex-row mt-2 mt-md-0">
                                                        <div class="text-black pe-3">
                                                            <button class="btn" disabled
                                                                style="background: #16A085; color: white">+
                                                                Wishlist</button>
                                                        </div>
                                                        <div>
                                                            <button
                                                                class="delete-out-of-stock-product btn btn-danger ms-3"><i
                                                                    class="lni lni-trash-can"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-8 col-md-3 form-group ps-0 ps-md-3">
                                                        <div class="d-flex justify-content-between">
                                                            <button disabled
                                                                class="input-group-text changeQuantity me-1"
                                                                style="background: #16A085; color: white">-</button>
                                                            <input disabled type="text" name="quantity"
                                                                class="form-control qty-input text-center" value="1">
                                                            @if ($itemOutOfStock->product->stoke >
                                                            $itemOutOfStock->product_qty)
                                                            <button disabled
                                                                class="input-group-text changeQuantity ms-1"
                                                                style="background: #16A085; color: white">+</button>
                                                            @else
                                                            <button disabled
                                                                class="input-group-text changeQuantity ms-1"
                                                                style="background: #16A085; color: white">+</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- =============== WEB ==================== --}}
                    <div class="col-12 col-xl-4 d-none d-sm-block">
                        <div class="m-0 m-xl-4 p-4 rounded" style="border: 1px solid #16A085;">
                            <h3 class="mb-3 fs-4">Ringkasan Belanja</h3>
                            <div
                                class="d-flex mb-8 align-items-center justify-content-between pb-3" style="border-bottom: 1px solid #16A085;">
                                <span class="">Total Harga(<span class="count-product">0</span> Barang)</span>
                                <span class="fs-6 fw-bold">Rp. <span class="total-price">0</span></span>
                            </div>
                            <div class="d-flex mb-10 mt-3 justify-content-between align-items-center">
                                <span class="fw-bold">Total Harga</span>
                                <span class="fs-6 fw-bold">Rp. <span class="total-price">0</span></span>
                            </div>
                            @if ($cartItem->count())
                                <button type="submit" class="btn w-100 text-uppercase text-white" style="background: #16A085;" href="{{ url('cart/shipment') }}">Checkout (<span class="beli-keranjang-count">0</span>)</a>
                            @else
                                <a class="btn w-100 text-uppercase text-white" style="background: #16A085;" href="{{ url('new-product') }}">Belanja Sekarang</a>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- ====================== MOBILE ====================== --}}
                <div class="row">
                    <div class="keranjang_barang d-block d-sm-none" style="border: 1px solid #16A085;">
                        <div class="col-12">
                            <div class="d-flex pt-3 mb-10 justify-content-between align-items-center">
                                <div class="f-flex">
                                    <p class="fw-bold">Total</p>
                                    <p>(<span class="count-product">0</span> Barang)</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <span class="me-2 fw-bold">Rp<span class="total-price">0</span></span>
                                    @if ($cartItem->count())
                                    <button type="submit" class="btn text-capitalize text-white"
                                        style="background: #16A085;" href="{{ url('cart/shipment') }}">Checkout(<span
                                            class="beli-keranjang-count">0</span>)</a>
                                        @else
                                        <a class="btn text-capitalize text-white" style="background: #16A085;"
                                            href="{{ url('new-product') }}">Belanja Sekarang</a>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="product-details-info rounded" style="border: 1px solid #16A085;">
                <div class="m-4">
                    <h5 class="mx-2 pt-3 fw-bold" style="color:#16A085;">Produk Lainnnya</h5>
                    <div class="owl-carousel owl-theme">
                        @foreach ($product_new as $item)
                        <!-- Start Single Product -->
                        <div class="mx-2 single-product shadow-none {{ $item->stoke === 0 ? 'bg-light opacity-90' : '' }}" style="height: 27rem; border: 1px solid #16A085;">
                            <div class="product-image {{ $item->stoke === 0 ? 'bg-light opacity-90' : '' }}">
                                <a href="{{ url('home/'.$item->slug) }}">
                                    @if ($item->stoke === 0)
                                    <div style="z-index: 3" class="badge bg-danger px-3 position-absolute top-50 start-50 translate-middle"><h5 class="text-white">Stok Habis</h5></div>
                                    @endif
                                    @if ($item->photo_product->count() > 0)
                                        @foreach ($item->photo_product->take(1) as $photos)
                                            @if ($photos->name)
                                            <img src="{{ asset('../storage/produk/'.$photos->name) }}" alt="{{ $item->name }}"
                                                style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                            @else
                                            <img src="{{ asset('img/no-image.png') }}" alt="{{ $item->name }}"
                                                style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                            @endif
                                        @endforeach
                                    @else
                                        <img src="{{ asset('img/no-image.png') }}" alt="{{ $item->name }}"
                                            style="width: 27rem; height: 12rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                    @endif
                                </a>
                            </div>
                            <div class="product-info {{ $item->stoke === 0 ? 'bg-light opacity-90' : '' }}"">
                                @if ($item->discount != 0)
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ url('product-category/'.$item->product_category->slug) }}">
                                            <span class="category">{{ $item->category_name }}</span>
                                        </a>
                                        <p class="small category text-white badge bg-danger">{{ $item->discount }}% OFF</p>
                                    </div>
                                @else
                                    <a href="{{ url('product-category/'.$item->product_category->slug) }}">
                                        <span class="category">{{ $item->category_name }}</span>
                                    </a>
                                @endif
                                <p class="small" style="color:#16A085;">Stok tersisa {{ $item->stoke }}</p>
                                <h4 class="title text-capitalize">
                                    <a href="{{ url('home/'.$item->slug) }}" style="color:#16A085; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">{{ $item->name }}</a>
                                </h4>
                                <ul class="review">
                                    <div>
                                        @if ($item->stock_out)
                                            <span>{{$item->stock_out}} Terjual</span>
                                        @else
                                            <span>0 Terjual</span>
                                        @endif
                                    </div>
                                    @php
                                        $reviewProduct = App\Models\Review::where('product_id', $item->id)->get();
                                        $ratingProductSum = App\Models\Review::where('product_id', $item->id)->sum('stars_rated');
                                        if ($reviewProduct->count() > 0){
                                            $ratingProductValue = $ratingProductSum / $reviewProduct->count();
                                        } else {
                                            $ratingProductValue = 0;
                                        }
                                        $ratingsProduckAll = number_format($ratingProductValue)
                                    @endphp
                                    @for ($i = 1; $i <= $ratingsProduckAll; $i++)
                                        <li><i class="lni lni-star-filled"></i></li>
                                    @endfor
                                    @for ($j = $ratingsProduckAll+1; $j <= 5; $j++)
                                        <li><i class="lni lni-star"></i>
                                        </li>
                                    @endfor
                                </ul>
                                <div class="fw-bold mt-2">
                                    @if ($item->price_discount)
                                        <span class="text-decoration-line-through text-muted " style="font-size: 13px">Rp. {{ number_format($item->price_discount, 0) }} <span style="color: #16A085">Rp. {{ number_format($item->price, 0) }}</span></span>
                                    @else
                                        <span style="color: #16A085">Rp. {{ number_format($item->price, 0) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    $( function() {
        $('.owl-carousel').owlCarousel({
            loop: false,
            responsiveClass: true,
            URLhashListener:true,
            autoplayHoverPause:true,
            startPosition: 'URLHash',
            stagePadding: 30,
            responsive: {
                0: {
                    items: 1,
                },
                480: {
                    items: 2,
                },
                600: {
                    items: 3,
                },
                1000: {
                    items: 4,
                }
            }
        });
    });

    $(document).ready(function ()
    {
        $('.checkProductCart').click( function()
        {
            var totalCheckboxes = $("input#checkProductCart:checked").length;
            var sum = 0;
            var total = 0;
            if (totalCheckboxes) {
                var checkedInputs = $("input#checkProductCart:checked");
                var sum_qty = 0;
                var total_price = 0;
                $.each(checkedInputs, function(i, val) {
                    var qty = $(this).closest('.checkProductCart').find("input[name=cart_qty]").val();
                    var price = $(this).closest('.checkProductCart').find("input[name=cart_total]").val();
                    sum_qty += parseInt(qty);
                    total_price += parseInt(price * qty);
                });
                sum = sum_qty;
                total = total_price
            } else {
                var qty = 0;
            }
            $.ajax({
                method: "POST",
                url: "/load-beli-keranjang",
                data: {
                    'totalCheckboxes': totalCheckboxes,
                    'sum': sum,
                    'total': total
                },
                success: function (response)
                {
                    $('.beli-keranjang-count').html('');
                    $('.beli-keranjang-count').html(response.countCart);

                    $('.count-product').html('');
                    $('.count-product').html(response.countQty);

                    $('.total-price').html('');
                    $('.total-price').html(response.totalPrice);
                }
            });
        });

            $('.increment-btn').click(function (e) {
                e.preventDefault();

                var inc_value = $(this).closest('#product_data').find('.qty-input').val();

                var value = parseInt(inc_value, stoke);
                value = isNaN(value) ? stoke : value;
                if (value < stoke) {
                    value++;
                    // $('.qty-input').val(value);
                    $(this).closest('#product_data').find('.qty-input').val(value);
                }
            });

            $('.decrement-btn').click(function (e) {
                e.preventDefault();

                var dec_value = $(this).closest('#product_data').find('.qty-input').val();

                var value = Number(dec_value, stoke);
                value = isNaN(value) ? stoke : value;
                if (value > 1) {
                    value--;
                    $(this).closest('#product_data').find('.qty-input').val(value);
                }
            });
        });

        $('.addToWishlistBtn').click(function (e) {
            e.preventDefault();

            var product_id = $(this).closest('#product_data').find('#prod_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: "/add-to-wishlist",
                data: {
                    'product_id': product_id,
                },
                success: function (response) {
                    if (response.status == 'Silahkan login!') {
                        window.location = '/login';
                    } else {
                        if (response.message == 'gagal')
                        {
                            iziToast.warning({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                title: 'Gagal',
                                message: response.status,
                                position: 'topRight'
                            });
                        }
                            else if(response.message == 'berhasil')
                        {
                            // window.location.reload();
                            iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                title: 'Berhasil',
                                message: response.status,
                                position: 'topRight'
                            });
                        }
                    }
                }
            });
        });

    // Script
    // function incrementValue(e) {
    //     e.preventDefault();
    //     var fieldName = $(e.target).data('field');
    //     var parent = $(e.target).closest('div');
    //     var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

    //     if (!isNaN(currentVal)) {
    //         parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
    //     } else {
    //         parent.find('input[name=' + fieldName + ']').val(0);
    //     }
    // }

    // function decrementValue(e) {
    //     e.preventDefault();
    //     var fieldName = $(e.target).data('field');
    //     var parent = $(e.target).closest('div');
    //     var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

    //     if (!isNaN(currentVal) && currentVal > 0) {
    //         parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
    //     } else {
    //         parent.find('input[name=' + fieldName + ']').val(0);
    //     }
    // }

    // $('.input-group').on('click', '.button-plus', function(e) {
    //     incrementValue(e);
    // });

    // $('.input-group').on('click', '.button-minus', function(e) {
    //     decrementValue(e);
    // });
</script>
@endsection
