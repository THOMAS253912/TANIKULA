@extends('pages.template1')
@section('title', 'Produk Terbaru')
@section('breadcrumb-title', 'Pencarian')
@section('breadcrumb-subTitle', 'Produk')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <style>
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
    </style>
@endsection

@section('content')
    <div class="container pt-5 d-flex justify-content-end">
        <div class="dropdown dropstart">
            <button class="btn btn-light dropdown-toggle" style="color:#16A085;" type="button" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false">
                Filter Berdasarkan
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li>
                    <form action="{{ url('/search-product') }}">
                        <input type="hidden" name="harga_tertinggi" id="harga_tertinggi" value="harga_tertinggi">
                        <button type="submit" id="max_price_btn" class="dropdown-item">Harga Tertinggi</button>
                    </form>
                </li>
                <li>
                    <form action="{{ url('/search-product') }}">
                        <input type="hidden" name="harga_terendah" id="harga_terendah" value="harga_terendah">
                        <button type="submit" id="min_price_btn" class="dropdown-item">Harga Terendah</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <script>
        var countProductSearch = '{{ $product_new->count() }}';
    </script>
    <!-- Start Trending Product Area -->
    <section class="section">
        <div class="container">
            <div class="row mx-4 mx-sm-0" id="pencarian_product">
                {{-- Konten Produk --}}
            </div>
        </div>
    </section>
    <!-- End Trending Product Area -->
@endsection

@section('script')
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        var displayProduct = countProductSearch;
        var displayProductNull = 4;
        if (displayProduct > 0) {
            $('#pencarian_product').html(createSkeleton(displayProduct));
        } else {
            $('#pencarian_product').html(createSkeleton(displayProductNull));
        }

        // jalankan fungsi load content setelah 2 detik
        function createSkeleton(limit){
        var skeletonHTML = '';
        for(var i = 0; i < limit; i++){
            // skeletonHTML += '<div class="row">';
                skeletonHTML += '<div class="col-lg-3 mt-4 col-md-6 col-12">';
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
            $('#pencarian_product').html(`@if ($product_new->count() > 0)
            @foreach ($product_new as $item)
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Product -->
                    <div class="single-product {{ $item->stoke === 0 ? 'bg-light opacity-90' : '' }}" style="height: 26">
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
                        <div class="product-info {{ $item->stoke === 0 ? 'bg-light opacity-90' : '' }}">
                            @if ($item->discount != 0)
                                <div class="d-flex justify-content-between">
                                    <a href="{{ url('product-category/'.$item->product_category->slug) }}">
                                        <span class="category">{{ $item->category_name }}</span>
                                    </a>
                                    <p class="small badge bg-danger">{{ $item->discount }}% OFF</p>
                                </div>
                            @else
                                <a href="{{ url('product-category/'.$item->product_category->slug) }}">
                                    <span class="category">{{ $item->category_name }}</span>
                                </a>
                            @endif
                            <p class="small" style="color:#16A085;">Stok tersisa {{ $item->stoke }}</p>
                            <h4 class="title">
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
                                    $reviews = App\Models\Review::where('product_id', $item->id)->get();
                                    $ratingSum = App\Models\Review::where('product_id', $item->id)->sum('stars_rated');
                                    if ($reviews->count() > 0){
                                        $ratingValue = $ratingSum / $reviews->count();
                                    } else {
                                        $ratingValue = 0;
                                    }
                                    $rateNum = number_format($ratingValue)
                                @endphp
                                @for ($i = 1; $i <= $rateNum; $i++)
                                    <li><i class="lni lni-star-filled"></i></li>
                                @endfor
                                @for ($j = $rateNum+1; $j <= 5; $j++)
                                    <li><i class="lni lni-star"></i>
                                    </li>
                                @endfor
                            </ul>
                            <div class="price">
                                @if ($item->price_discount)
                                    <span class="text-decoration-line-through text-muted " style="font-size: 13px">Rp. {{ number_format($item->price_discount, 0) }} <span>Rp. {{ number_format($item->price, 0) }}</span></span>
                                @else
                                    <span>Rp. {{ number_format($item->price, 0) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                </div>
                @endforeach
                @else
                    @if (request('pencarian'))
                    <div id="app">
                        <section class="section">
                            <div class="container">
                                <div class="page-error">
                                    <div class="page-inner">
                                        <img src="img/undraw_empty_re_opql.svg" alt="">
                                        <div class="page-description">
                                            Produk yang anda cari tidak ada!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    @else
                    <div id="app">
                        <section class="section">
                            <div class="container">
                                <div class="page-error">
                                    <div class="page-inner">
                                        <img src="../img/undraw_empty_re_opql.svg" alt="">
                                        <div class="page-description">
                                            Tidak ada produk yang diposting!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    @endif
                @endif`);
        }, 2000);
    });
</script>
@endsection
