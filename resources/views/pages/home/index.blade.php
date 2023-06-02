@extends('pages.template')
@section('title', 'Menyediakan produk hasil tani organik')

@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
    integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .featured-categories .section-title {
        margin-top: 60px;
    }

    @media (max-width: 767px) {
        .section-title h2 {
            font-size: 20px;
            line-height: 30px;
        }

        .featured-categories .section-title {
            margin-top: 0px;
        }

        .featured-categories .single-category {
            margin-top: 0px;
        }
    }

    .featured-categories .single-category {
        padding: 40px;
        height: 200px;
        margin-top: 30px;
        position: relative;
        background: #fff;
        z-index: 0;
    }

    .featured-categories .single-category .heading {
        font-size: 17px;
        font-weight: 700;
        color: #081828;
    }

    .featured-categories .single-category ul {
        margin-top: 20px;
    }

    .featured-categories .single-category ul li {
        display: block;
        margin-bottom: 4px;
    }

    .featured-categories .single-category img {
        position: absolute;
        right: 0;
        top: 50%;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        z-index: -1;
    }

    .featured-categories .single-category ul li a {
        color: var(--primary);
    }

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
        text-align: center;
        display: table;
    }

    .page-error .page-inner {
        display: table-cell;
        width: 100%;
        vertical-align: middle;
    }

    .page-error img {
        width: 10rem;
    }

    .page-error .page-description {
        padding-top: 30px;
        font-size: 18px;
        font-weight: 400;
        color: var(--primary);
    }

    @media (max-width: 575.98px) {
        .page-error {
            padding-top: 0px;
        }
    }

    .opacity-90 {
        opacity: 90%;
    }
</style>
@endsection

@section('content')
<section class="featured-categories section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2 style="color: #16A085">Kategori Produk</h2>
                </div>
            </div>
        </div>
        <div class="row mx-2 mx-sm-0">
            @if ($category_product->count())
            @foreach ($category_product as $item)
            <div class="col-3 col-sm-3 col-md-2">
                {{-- Web --}}
                <div class="d-none d-sm-block">
                    <a href="{{ url('product-category/'.$item->slug) }}">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="rounded p-3 mt-5" style="border: 1px solid #16A085;">
                            <img src="{{ asset('../storage/icon/'.$item->icon) }}" class="img-fluid" style="width: 3rem; height: 3rem;"
                                alt="{{$item->name}}">
                        </div>
                    </div>
                    <p class="text-center pt-1" style="line-height: 19px; color:#16A085;">{{ $item->name }}</p>
                    </a>
                </div>

                {{-- Mobile --}}
                <div class="d-block d-sm-none">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="rounded p-2 mt-2" style="border: 1px solid #16A085;">
                            <img src="{{ asset('../storage/icon/'.$item->icon) }}" class="img-fluid" style="width: 2rem; height: 2rem;"
                                alt="{{$item->name}}">
                        </div>
                    </div>
                    <p class="text-center pt-1" style="line-height: 19px"><a style="color:#16A085;" href="{{ url('product-category/'.$item->slug) }}"> {{ $item->name }}</a></p>
                </div>
            </div>
            @endforeach
            @else
            <div id="app">
                <section class="section">
                    <div class="container">
                        <div class="page-error">
                            <div class="page-inner">
                                <img src="{{ asset('img/undraw_empty_re_opql.svg') }}" alt="">
                                <div class="page-description">
                                    Tidak ada Kategori Produk!
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Start Trending Product Area -->
<section class="section" style="background: #16A085;">
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center section-title">
                    <h2>Produk Terbaru</h2>
                    <a class="text-white" href="{{ url('new-product') }}">Lihat semua</a>
                </div>
            </div>
        </div>
        <div class="row mx-4 mx-sm-0 d-none d-sm-flex" id="homeNewProduct">
            {{-- Content --}}
        </div>

        @php
            $product_new = App\Models\Product::with('photo_product', 'review')
                    ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                    ->join('users', 'products.user_id', '=', 'users.id')
                    ->select('products.*', 'product_categories.name as category_name')
                    ->where('product_categories.is_active', '=', 1)
                    ->where('products.is_active', '=', 1)
                    ->orderBy('products.updated_at', 'desc')
                    ->take(8)
                    ->get();
        @endphp
        <div class="d-block d-sm-none">
            <div class="owl-carousel owl-theme">
                @foreach ($product_new as $item)
                <!-- Start Single Product -->
                <div class="mx-md-2 mx-3 single-product mt-0 shadow-none {{ $item->stoke === 0 ? 'bg-light opacity-90' : '' }}"
                    style="
                            height: 26rem">
                    <div class="product-image {{ $item->stoke === 0 ? 'bg-light opacity-90' : '' }}">
                        <a href=" {{ url('home/'.$item->slug) }}">
                            @if ($item->stoke === 0)
                            <div style="z-index: 3"
                                class="badge bg-danger px-3 position-absolute top-50 start-50 translate-middle">
                                <h5 class="text-white">Stok Habis</h5>
                            </div>
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
                    <div class="product-info {{ $item->stoke === 0 ? 'bg-light opacity-90' : '' }}">
                        @if ($item->discount != 0)
                        <div class=" d-flex justify-content-between">
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
                            <a href="{{ url('home/'.$item->slug) }}"
                                style="color:#16A085; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">{{ $item->name }}</a>
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
                            @for ($i = 1; $i <= $ratingsProduckAll; $i++) <li><i class="lni lni-star-filled"></i></li>
                                @endfor
                                @for ($j = $ratingsProduckAll+1; $j <= 5; $j++) <li><i class="lni lni-star"></i>
                                    </li>
                                    @endfor
                        </ul>
                        <div class="fw-bold mt-2">
                            @if ($item->price_discount)
                            <span class="text-decoration-line-through text-muted " style="font-size: 13px">Rp.
                                {{ number_format($item->price_discount, 0) }} <span style="color: #16A085">Rp.
                                    {{ number_format($item->price, 0) }}</span></span>
                            @else
                            <span style="color: #16A085">Rp. {{ number_format($item->price, 0) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="mx-md-2 mx-3 single-product mt-0 shadow-none bg-warning"
                    style="
                            height: 26rem">
                    <div class="text-center" style="padding-top: 70%">
                        <h5 class="fw-bold text-white"><a href="{{ url('new-product') }}">Lainnya...</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Trending Product Area -->

<!-- Start Trending Product Area -->
<section class="section mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center section-title">
                    <h2 class="col-6 col-sm-5">Berdasarkan Pencarianmu</h2>
                    <a class="col-6 col-sm-0" href="{{ url('based-on-your-search') }}">Lihat semua</a>
                </div>
            </div>
        </div>
        <div class="row mx-4 mx-sm-0 d-none d-sm-flex" id="homeSearchProduct">
            {{-- Content --}}
        </div>

        @php
            $product_search = App\Models\Product::with('photo_product', 'review', 'orderItems')
                    ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                    ->join('users', 'products.user_id', '=', 'users.id')
                    ->select('products.*', 'product_categories.name as category_name')
                    ->where('product_categories.is_active', '=', 1)
                    ->where('products.is_active', '=', 1)
                    ->orderBy('products.updated_at', 'desc')
                    ->orderByRaw('RAND()')
                    ->take(8)
                    ->get();
        @endphp
        <div class="d-block d-sm-none">
            <div class="owl-carousel owl-theme">
                @foreach ($product_search as $item)
                <!-- Start Single Product -->
                <div class="mx-md-2 mx-3 single-product mt-0 shadow-none {{ $item->stoke === 0 ? 'bg-light opacity-90' : '' }}"
                    style="
                            height: 26rem; border: 1px solid #16A085;">
                    <div class="product-image {{ $item->stoke === 0 ? 'bg-light opacity-90' : '' }}">
                        <a href=" {{ url('home/'.$item->slug) }}">
                            @if ($item->stoke === 0)
                            <div style="z-index: 3"
                                class="badge bg-danger px-3 position-absolute top-50 start-50 translate-middle">
                                <h5 class="text-white">Stok Habis</h5>
                            </div>
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
                    <div class="product-info {{ $item->stoke === 0 ? 'bg-light opacity-90' : '' }}">
                        @if ($item->discount != 0)
                        <div class=" d-flex justify-content-between">
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
                            <a href="{{ url('home/'.$item->slug) }}"
                                style="color:#16A085; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">{{ $item->name }}</a>
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
                            @for ($i = 1; $i <= $ratingsProduckAll; $i++) <li><i class="lni lni-star-filled"></i></li>
                                @endfor
                                @for ($j = $ratingsProduckAll+1; $j <= 5; $j++) <li><i class="lni lni-star"></i>
                                    </li>
                                    @endfor
                        </ul>
                        <div class="fw-bold mt-2">
                            @if ($item->price_discount)
                            <span class="text-decoration-line-through text-muted " style="font-size: 13px">Rp.
                                {{ number_format($item->price_discount, 0) }} <span style="color: #16A085">Rp.
                                    {{ number_format($item->price, 0) }}</span></span>
                            @else
                            <span style="color: #16A085">Rp. {{ number_format($item->price, 0) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="mx-md-2 mx-3 single-product mt-0 shadow-none bg-warning"
                    style="
                            height: 26rem; border: 1px solid #16A085;">
                    <div class="text-center" style="padding-top: 70%">
                        <h5 class="fw-bold text-white"><a href="{{ url('based-on-your-search') }}">Lainnya...</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Trending Product Area -->

<!-- Start Shipping Info -->
{{-- <section class="shipping-info">
    <div class="container">
        <ul>
            <!-- Free Shipping -->
            <li>
                <div class="media-icon">
                    <i class="lni lni-delivery"></i>
                </div>
                <div class="media-body">
                    <h5>Bebas biaya kirim</h5>
                    <span>On order over $99</span>
                </div>
            </li>
            <!-- Money Return -->
            <li>
                <div class="media-icon">
                    <i class="lni lni-support"></i>
                </div>
                <div class="media-body">
                    <h5>24/7 Support.</h5>
                    <span>Live Chat Or Call.</span>
                </div>
            </li>
            <!-- Support 24/7 -->
            <li>
                <div class="media-icon">
                    <i class="lni lni-credit-cards"></i>
                </div>
                <div class="media-body">
                    <h5>Online Payment.</h5>
                    <span>Secure Payment Services.</span>
                </div>
            </li>
            <!-- Safe Payment -->
            <li>
                <div class="media-icon">
                    <i class="lni lni-reload"></i>
                </div>
                <div class="media-body">
                    <h5>Easy Return.</h5>
                    <span>Hassle Free Shopping.</span>
                </div>
            </li>
        </ul>
    </div>
</section> --}}
<!-- End Shipping Info -->
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- AKHIR LIBARARY JS -->
<script>
    $('.owl-carousel').owlCarousel({
        loop: false,
        responsiveClass: true,
        center:true,
        URLhashListener:true,
        autoplayHoverPause:true,
        startPosition: 'URLHash',
        responsive: {
            0: {
                stagePadding: 40,
                items: 1,
            },
        }
    });

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $(function() {
        // fetch all employees ajax request
        var displayProduct = 8;
        $('#homeNewProduct').html(createSkeleton(displayProduct));
        $('#homeSearchProduct').html(createSkeleton(displayProduct));

        // jalankan fungsi load content setelah 2 detik
        function createSkeleton(limit)
        {
            var skeletonHTML = '';
            for(var i = 0; i < limit; i++){
                // skeletonHTML += '<div class="row">';
                    skeletonHTML += '<div class="col-lg-3 mt-5 col-md-6 col-12">';
                        skeletonHTML += '<div class="ph-item rounded">';
                            skeletonHTML += '<div class="ph-col-12">';
                                skeletonHTML += '<div class="ph-picture rounded"></div>';
                            skeletonHTML += '</div>';

                            skeletonHTML += '<div>';
                                skeletonHTML += '<div class="ph-row">';
                                    skeletonHTML += '<div class="ph-col-12 rounded"></div>';
                                    skeletonHTML += '<div class="ph-col-12 rounded"></div>';
                                    skeletonHTML += '<div class="ph-col-12 rounded"></div>';
                                    skeletonHTML += '<div class="ph-col-12 empty"></div>';
                                    skeletonHTML += '<div class="ph-col-12 rounded big"></div>';
                                skeletonHTML += '</div>';
                            skeletonHTML += '</div>';

                            skeletonHTML += '<div>';
                                skeletonHTML += '<div class="ph-row">';
                                    skeletonHTML += '<div class="ph-col-12 big rounded"></div>';
                                skeletonHTML += '</div>';
                            skeletonHTML += '</div>';
                        skeletonHTML += '</div>';
                    skeletonHTML += '</div>';
                // skeletonHTML += '</div>';
            }
            return skeletonHTML;
        }

        setTimeout(function(){
            fetchallHomeNewProduct(displayProduct);
            fetchallHomeSearchProduct(displayProduct);
        }, 2000);

        function fetchallHomeNewProduct(limit) {
            $.ajax({
                url: '{{ route('fetchallHomeNewProduct') }}',
                data:{
                    limit:limit,
                },
                method: 'get',
                success: function(response) {
                    $("#homeNewProduct").html(response);
                }
            });
        }

        function fetchallHomeSearchProduct(limit) {
            $.ajax({
                url: '{{ route('fetchallHomeSearchProduct') }}',
                data:{
                    limit:limit,
                },
                method: 'get',
                success: function(response) {
                    $("#homeSearchProduct").html(response);
                }
            });
        }
    });
</script>
@endsection
