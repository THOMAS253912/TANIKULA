@extends('pages.template1')
@section('title', 'Detail Produk')
@section('breadcrumb-title', $product->product_category->name)
@section('breadcrumb-subTitle', substr($product->name, 0, 20) . '...')

@section('style')
    <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #chat2 .form-control {
            border-color: transparent;
        }

        #chat2 .form-control:focus {
            border-color: transparent;
            box-shadow: inset 0px 0px 0px 1px transparent;
        }

        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .ratings-color {
            color: #f0d800;
        }

        .page-error-chat {
            height: 100%;
            width: 100%;
            text-align: center;
            display: table;
        }

        .page-error-chat .page-description-chat {
            padding-top: 100px;
            font-size: 18px;
            font-weight: 400;
            color: var(--primary);
        }

        @media (max-width: 575.98px) {
            .page-error-chat {
                padding-top: 0px;
            }
        }

        .page-error {
            height: 100%;
            width: 100%;
            text-align: center;
            display: table;
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

        .chat-messages {
            height: 300px;
            overflow-y: scroll;
        }

        .costum-color {
            background-image: linear-gradient(195deg, rgb(255, 255, 255) 0%, #ffffff 100%);
        }

        .opacity-90 {
            opacity: 90%;
        }
    </style>
@endsection



@section('content')
    <!-- Start Item Details -->
    <section class="item-details section bg-white mt-md-5">
        <div class="container">
            <form action="{{ url('/buy-now') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="top-area" style="border: 1px solid #16A085;" id="product_data">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="product-images">
                                <main id="">
                                    <div class="main-img">
                                        @if ($product->photo_product->count() > 0)
                                            @foreach ($product->photo_product->take(1) as $photos)
                                                @if ($photos->name)
                                                    <img src="{{ asset('../storage/produk/' . $photos->name) }}"
                                                        id="current" alt="{{ $product->name }}"
                                                        style="height: 25rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                                @else
                                                    <img src="{{ asset('img/no-image.png') }}" id="current"
                                                        alt="{{ $product->name }}">
                                                @endif
                                            @endforeach
                                        @else
                                            <img src="{{ asset('img/no-image.png') }}" id="current"
                                                alt="{{ $product->name }}">
                                        @endif
                                    </div>
                                    <div class="images">
                                        @foreach ($product->photo_product as $photos)
                                            <img src="{{ asset('../storage/produk/' . $photos->name) }}" class="img"
                                                style="height: 6rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"
                                                alt="#">
                                        @endforeach
                                    </div>
                                </main>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="product-info">
                                @if ($product->stoke < 1)
                                    <p class="h5 mb-3">
                                        <label class="badge bg-danger">Habis</label>
                                    </p>
                                @elseif($product->stoke < 10)
                                    <p class="h5 mb-3">
                                        <label class="badge bg-danger">Tersisa {{ $product->stoke }}</label>
                                    </p>
                                @endif
                                <h2 class="title text-capitalize" style="color:#16A085;">
                                    {{ $product->name }}
                                    @if ($product->discount != 0)
                                        <p class="small ms-3 badge bg-danger">{{ $product->discount }}% OFF</p>
                                    @endif
                                </h2>
                                @php
                                    $rateNum = number_format($ratingValue);
                                @endphp
                                <div class="pb-3 rating-produk">
                                    <div class="star-icon"
                                        style="
                                            font-size: 20px;
                                            font-family: sans-serif;
                                            font-weight: 800;
                                            text-transform: uppercase;">
                                        @for ($i = 1; $i <= $rateNum; $i++)
                                            <i class="lni lni-star-filled ratings-color"></i>
                                        @endfor
                                        @for ($j = $rateNum + 1; $j <= 5; $j++)
                                            <i class="lni lni-star-filled">
                                            </i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="category"><i class="lni lni-tag"></i> Kategori:<a
                                        href="{{ url('product-category/' . $product->product_category->slug) }}">{{ $product->product_category->name }}</a>
                                </p>
                                <p class="category">Stok {{ $product->stoke }}</p>
                                {{-- <h3 class="price">Rp. {{ number_format($product->price, 0) }}<span>Rp.
                                        {{ number_format(0, 0) }}</span></h3> --}}
                                @if ($product->price_discount)
                                    <h3 class="price" style="color:#16A085;">
                                        <span class="text-decoration-line-through text-muted" style="font-size: 15px">
                                            Rp. {{ number_format($product->price_discount, 0) }}</span> Rp.
                                        {{ number_format($product->price, 0) }}
                                    </h3>
                                @else
                                    <h3 class="price" style="color:#16A085;">Rp. {{ number_format($product->price, 0) }}
                                    </h3>
                                @endif
                                <p class="info-text" style="border-bottom: 1px solid #16A085;">{{ $product->desc }}</p>
                                <div class="row">
                                    {{-- <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="color">Tipe</label>
                                            <select class="form-control" id="color">
                                                <option>Tipe A</option>
                                                <option>Tipe B</option>
                                                <option>Tipe C</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <input type="hidden" value="{{ $product->id }}" name="prod_id"
                                                id="prod_id">
                                            <label for="quantity">Kuantitas</label>
                                            <div class="d-flex">
                                                <script>
                                                    var stoke = '{{ $product->stoke }}';
                                                </script>
                                                @if ($product->stoke < 1)
                                                    <button disabled class="input-group-text decrement-btn me-1">-</button>
                                                    <input disabled type="text" name="quantity"
                                                        class="form-control qty-input text-center" value="1">
                                                    <button disabled class="input-group-text increment-btn ms-1">+</button>
                                                @else
                                                    <button class="input-group-text decrement-btn me-1">-</button>
                                                    <input type="text" name="quantity"
                                                        class="form-control qty-input text-center" value="1">
                                                    <button class="input-group-text increment-btn ms-1">+</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="color">Lainnya</label>
                                            <div class="wish-button">
                                                @auth

                                                    @if (auth()->user()->getRoleNames()[0] == 'pembeli' ||
                                                            auth()->user()->getRoleNames()[0] == 'gapoktan')
                                                        <a href="{{ auth()->user()->getRoleNames()[0] == 'pembeli'? route('pembeli.chat'): route('gapoktan.chat') }}"
                                                            id="chat-button" class="btn"
                                                            data-chat="{{ json_encode(['product' => $product, 'url' => url()->current()]) }}"><i
                                                                class="bi bi-chat-dots"></i>
                                                            Chat</a>
                                                    @endif
                                                @endauth
                                                <a href="{{ route('pembeli.chat')}}" id="chat-button" class="btn"
                                                    data-chat="{{ json_encode(['product' => $product, 'url' => url()->current()]) }}"><i
                                                        class="bi bi-chat-dots"></i>
                                                    Chat</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-content">
                                    <div class="row align-items-end">
                                        @if ($product->stoke < 1)
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <div class="button cart-button">
                                                    <button class="btn" style="width: 100%;">+
                                                        Keranjang</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <div class="wish-button">
                                                    <button class="btn">Beli Langsung</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <div class="wish-button">
                                                    <button class="btn" id="addToWishlistBtn">+ Wishlist</button>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <div class="button cart-button">
                                                    <button class="btn" id="addToCartBtn" style="width: 100%;">+
                                                        Keranjang</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <div class="wish-button">
                                                    <button class="btn" id="buyNow">Beli Langsung</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <div class="wish-button">
                                                    <button class="btn" id="addToWishlistBtn">+ Wishlist</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="product-details-info">
                <div class="single-block" style="border: 1px solid #16A085;">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-body row align-items-center">
                                <div class="col-md-5 col-12 d-flex align-items-center">
                                    @php
                                        $gapoktan = App\Models\Gapoktan::where('user_id', $product->user_id)->first();
                                        $nama_gapoktan = strtolower($product->user->name);
                                    @endphp
                                    <img alt="image"
                                        src="{{ $gapoktan->image === null ? '../assets/img/avatar/avatar-1.png' : '../storage/profile/' . $gapoktan->image . '' }}"
                                        class="border rounded-circle border-white shadow-sm"
                                        style="width: 70px; height: 70px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                    <div class="ps-3">
                                        <h6>{{ $product->user->name }}</h6>
                                        @if ($gapoktan->city_id)
                                            <p style="font-size: 12px"><i class="bi bi-geo-alt me-1"></i>
                                                {{ $gapoktan->city->name }}</p>
                                        @endif
                                        <a class="rounded mt-1" style="background: #16A085"
                                            href="/profile/{{ str_replace(' ', '-', $nama_gapoktan) }}">
                                            <p class="m-0 px-2 text-white text-uppercase"><i class="bi bi-shop me-2"></i>
                                                <span class="small text-white">Kunjungi Toko</span>
                                            </p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-7 col-12 d-md-flex justify-content-between">
                                    @php
                                        $koleksiProduk = App\Models\Product::with('photo_product', 'review')
                                            ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                                            ->join('users', 'products.user_id', '=', 'users.id')
                                            ->select('products.*', 'product_categories.name as category_name')
                                            ->where('product_categories.is_active', '=', 1)
                                            ->where('products.is_active', '=', 1)
                                            ->where('user_id', $product->user_id)
                                            ->orderBy('products.updated_at', 'desc')
                                            ->get();

                                        $penilaianProduk = App\Models\Review::with('user', 'product', 'order')
                                            ->join('users', 'reviews.user_id', '=', 'users.id')
                                            ->join('products', 'reviews.product_id', '=', 'products.id')
                                            ->select('reviews.*', 'users.name as name_reviewer')
                                            ->where('products.user_id', '=', $product->user_id)
                                            ->count();
                                    @endphp
                                    <div class="mt-md-0 mt-3">
                                        <p>Penilaian
                                            <span class="ps-md-2" style="color: #16A085; font-weight: bold">
                                                @if ($penilaianProduk < 1000)
                                                    {{ $penilaianProduk }}
                                                @elseif ($penilaianProduk === 1000 || 2000 || 3000 || 4000 || 5000 || 6000 || 7000 || 8000 || 9000 || 10000)
                                                    {{ substr($penilaianProduk, 0, 1) }}RB
                                                @endif
                                            </span>
                                        </p>
                                        <p>Produk <span class="ps-md-2"
                                                style="color: #16A085; font-weight: bold">{{ $koleksiProduk->count() }}</span>
                                        </p>
                                    </div>
                                    <div class="d-md-flex mt-md-0 mt-3">
                                        <p class="pe-3">Koleksi Produk</p>
                                        @foreach ($koleksiProduk->take(5) as $item)
                                            @if ($item->photo_product->count() > 0)
                                                @foreach ($item->photo_product->take(1) as $photos)
                                                    @if ($photos->name)
                                                        <img src="{{ asset('../storage/produk/' . $photos->name) }}"
                                                            alt="{{ $item->name }}" class="me-1 mb-md-0 mb-1"
                                                            style="width: 60px; height: 60px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                                    @else
                                                        <img src="{{ asset('img/no-image.png') }}"
                                                            alt="{{ $item->name }}" class="me-1 mb-md-0 mb-1"
                                                            style="width: 60px; height: 60px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                                    @endif
                                                @endforeach
                                            @else
                                                <img src="{{ asset('img/no-image.png') }}" alt="{{ $item->name }}"
                                                    class="me-1 mb-md-0 mb-1"
                                                    style="width: 60px; height: 60px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-details-info">
                <div class="single-block" style="border: 1px solid #16A085;">
                    <h5 class="mx-2 fw-bold" style="color:#16A085;">Produk Lainnnya</h5>
                    <div class="owl-carousel owl-theme">
                        @foreach ($product_new as $item)
                            <!-- Start Single Product -->
                            <div class="mx-md-2 mx-2 single-product border border-success shadow-none {{ $item->stoke === 0 ? 'bg-light opacity-90' : '' }}"
                                style="
                    height: 27rem">
                                <div class="product-image {{ $item->stoke === 0 ? 'bg-light opacity-90' : '' }}">
                                    <a href=" {{ url('home/' . $item->slug) }}">
                                        @if ($item->stoke === 0)
                                            <div style="z-index: 3"
                                                class="badge bg-danger px-3 position-absolute top-50 start-50 translate-middle">
                                                <h5 class="text-white">Stok Habis</h5>
                                            </div>
                                        @endif
                                        @if ($item->photo_product->count() > 0)
                                            @foreach ($item->photo_product->take(1) as $photos)
                                                @if ($photos->name)
                                                    <img src="{{ asset('../storage/produk/' . $photos->name) }}"
                                                        alt="{{ $item->name }}"
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
                                            <a href="{{ url('product-category/' . $item->product_category->slug) }}">
                                                <span class="category">{{ $item->category_name }}</span>
                                            </a>
                                            <p class="small category text-white badge bg-danger">{{ $item->discount }}%
                                                OFF</p>
                                        </div>
                                    @else
                                        <a href="{{ url('product-category/' . $item->product_category->slug) }}">
                                            <span class="category">{{ $item->category_name }}</span>
                                        </a>
                                    @endif
                                    <p class="small" style="color:#16A085;">Stok tersisa {{ $item->stoke }}</p>
                                    <h4 class="title text-capitalize">
                                        <a href="{{ url('home/' . $item->slug) }}"
                                            style="color:#16A085; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">{{ $item->name }}</a>
                                    </h4>
                                    <ul class="review">
                                        <div>
                                            @if ($item->stock_out)
                                                <span>{{ $item->stock_out }} Terjual</span>
                                            @else
                                                <span>0 Terjual</span>
                                            @endif
                                        </div>
                                        @php
                                            $reviewProduct = App\Models\Review::where('product_id', $item->id)->get();
                                            $ratingProductSum = App\Models\Review::where('product_id', $item->id)->sum('stars_rated');
                                            if ($reviewProduct->count() > 0) {
                                                $ratingProductValue = $ratingProductSum / $reviewProduct->count();
                                            } else {
                                                $ratingProductValue = 0;
                                            }
                                            $ratingsProduckAll = number_format($ratingProductValue);
                                        @endphp
                                        @for ($i = 1; $i <= $ratingsProduckAll; $i++)
                                            <li><i class="lni lni-star-filled"></i></li>
                                        @endfor
                                        @for ($j = $ratingsProduckAll + 1; $j <= 5; $j++)
                                            <li><i class="lni lni-star"></i>
                                            </li>
                                        @endfor
                                    </ul>
                                    <div class="fw-bold mt-2">
                                        @if ($item->price_discount)
                                            <span class="text-decoration-line-through text-muted "
                                                style="font-size: 13px">Rp.
                                                {{ number_format($item->price_discount, 0) }} <span
                                                    style="color: #16A085">Rp.
                                                    {{ number_format($item->price, 0) }}</span></span>
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
            <div class="product-details-info">
                <div class="single-block" style="border: 1px solid #16A085;">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="info-body custom-responsive-margin">
                                <h4>Ulasan <span>({{ $showReviews->count() }} Ulasan)</span></h4>
                                <p class="fw-bold text-capitalize col-10">{{ $product->name }}</p>
                                <div class="rating-produk">
                                    <div class="star-icon"
                                        style="
                                        font-size: 40px;
                                        font-family: sans-serif;
                                        font-weight: 800;
                                        text-align: center;
                                        text-transform: uppercase;">
                                        @for ($i = 1; $i <= $rateNum; $i++)
                                            <i class="lni lni-star-filled ratings-color"></i>
                                        @endfor
                                        @for ($j = $rateNum + 1; $j <= 5; $j++)
                                            <i class="lni lni-star-filled"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-12 mt-md-5">
                            <div class="info-body">
                                <input type="hidden" name="passingIdProduct" value="{{ $product->id }}">
                                <h4 class="fw-bold" style="color:#16A085;">Semua Ulasan</h4>
                                <div class="card-body px-0 py-3" id="tabs">
                                    <ul class="mx-3 p-1 nav bg-white rounded nav-fill">
                                        <li class="nav-item">
                                            <a class="nav-link fiveStars text-black bg-white" href="#fiveStars">
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <span>(<span class="five-count"></span>)</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link fourStars text-black bg-white" href="#fourStars">
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star"></i>
                                                <span>(<span class="four-count"></span>)</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link threeStars text-black bg-white" href="#threeStars">
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star"></i>
                                                <i class="lni lni-star"></i>
                                                <span>(<span class="three-count"></span>)</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link twoStars text-black bg-white" href="#twoStars">
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star"></i>
                                                <i class="lni lni-star"></i>
                                                <i class="lni lni-star"></i>
                                                <span>(<span class="two-count"></span>)</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link oneStars text-black bg-white" href="#oneStars">
                                                <i class="lni lni-star-filled" style="color: #f0d800;"></i>
                                                <i class="lni lni-star"></i>
                                                <i class="lni lni-star"></i>
                                                <i class="lni lni-star"></i>
                                                <i class="lni lni-star"></i>
                                                <span>(<span class="one-count"></span>)</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="py-4 px-md-5" id="fiveStars">
                                        <p class="h5 text-center" style="color: #16A085">Memuat</p>
                                    </div>
                                    <div class="py-4 px-md-5" id="fourStars">
                                        <p class="h5 text-center" style="color: #16A085">Memuat</p>
                                    </div>
                                    <div class="py-4 px-md-5" id="threeStars">
                                        <p class="h5 text-center" style="color: #16A085">Memuat</p>
                                    </div>
                                    <div class="py-4 px-md-5" id="twoStars">
                                        <p class="h5 text-center" style="color: #16A085">Memuat</p>
                                    </div>
                                    <div class="py-4 px-md-5" id="oneStars">
                                        <p class="h5 text-center" style="color: #16A085">Memuat</p>
                                    </div>
                                </div>
                                {{-- @if ($showReviews->count() > 0)
                                    @foreach ($showReviews as $review)
                                    <div class="mt-3 d-lg-flex align-items-center justify-content-start">
                                        <div class="col-8 col-lg-3 col-xl-2">
                                            <div>
                                                @foreach ($review->user->costumer as $potoProfile)
                                                @if ($potoProfile->image)
                                                <img src="{{ asset('../storage/profile/'.$potoProfile->image) }}"
                        style="max-width: 4rem;" class="img-fluid img-thumbnail rounded-circle"
                        alt="">
                        @else
                        <img src="{{ asset('stisla/assets/img/avatar/avatar-1.png') }}" style="max-width: 4rem;"
                            class="img-fluid img-thumbnail rounded-circle" alt="">
                        @endif
                        @endforeach
                        @php
                        function get_starred($str) {
                        $len = strlen($str);
                        return substr($str, 0, 1).str_repeat('*', $len - 2).substr($str, $len - 1, 1);
                        }
                        @endphp
                        <span class="ms-1">
                            @if ($review->hide === 1)
                            {{ get_starred(strtok($review->user->name, ' ')) }}
                            @else
                            {{ $review->user->name }}
                            @endif
                        </span>
                    </div>
                </div>
                <div class="col-12 col-lg-8 col-xl-10 mt-2 mt-lg-0 ms-0 ms-lg-5">
                    <ul class="normal-list">
                        <li>
                            <div class="ratings">
                                <div class="star-icon" style="
                                                        font-size: 20px;
                                                        font-family: sans-serif;
                                                        font-weight: 800;
                                                        text-transform: uppercase;">
                                    @for ($i = 1; $i <= $review->stars_rated; $i++)
                                        <i class="lni lni-star-filled ratings-color"></i>
                                        @endfor
                                        @for ($j = $review->stars_rated + 1; $j <= 5; $j++) <i
                                            class="lni lni-star-filled"></i>
                                            @endfor
                                </div>
                            </div>
                        </li>
                        <span class="me-md-5">
                            {{ $review->review }}
                        </span>
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
                            <div class="page-description text-black">
                                Belum ada ulasan produk!
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @endif --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    {{-- <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="chat2">
                        <div class="border rounded p-3 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">{{ $item->user->name }}</h6>
</div>
<div class="card-body position-relative">
    <div class="chat-messages">
        @if ($roomChats->count() > 0)
        @foreach ($roomChats as $roomChat)
        @auth
        @if ($roomChat->sender_id === auth()->user()->id)
        <div class="d-flex flex-row justify-content-end mb-4 pt-1">
            <div>
                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">{{ $roomChat->message }}</p>
                <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">
                    {{ date('H:i', strtotime($roomChat->created_at)) }}</p>
            </div>
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava4-bg.webp" alt="avatar 1"
                style="width: 45px; height: 100%;">
        </div>
        @else
        <div class="d-flex flex-row justify-content-start">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 1"
                style="width: 45px; height: 100%;">
            <div>
                <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">{{ $roomChat->message }}</p>
                <p class="small ms-3 mb-3 rounded-3 text-muted">{{ date('H:i', strtotime($roomChat->created_at)) }}</p>
            </div>
        </div>
        @endif
        @endauth
        @endforeach
        @else
        <div id="app">
            <section class="section">
                <div class="container">
                    <div class="page-error-chat">
                        <div class="page-inner-chat">
                            <div class="page-description-chat">
                                Belum ada pesan!
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @endif
    </div>
</div>
<div class="border rounded d-flex flex-row align-items-center mb-3">
    <div>
        @if ($item->photo_product->count() > 0)
        @foreach ($item->photo_product->take(1) as $photos)
        @if ($photos->name)
        <img src="{{ asset('../storage/produk/'.$photos->name) }}" alt="{{ $item->name }}"
            style="width: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
        @else
        <img src="{{ asset('img/no-image.png') }}" alt="{{ $item->name }}"
            style="width: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
        @endif
        @endforeach
        @else
        <img src="{{ asset('img/no-image.png') }}" alt="{{ $item->name }}"
            style="width: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
        @endif
    </div>
    <div class="ms-3">
        <p class="fw-bold">{{ $product->name }}</p>
        <p style="font-size: 12px">Rp. {{ number_format($product->price, 0) }}</p>
    </div>
</div>
<form action="#" method="POST" id="addChatForm">
    @auth
    <input type="hidden" name="sender_id" value="{{ auth()->user()->id }}">
    <input type="hidden" name="receiver_id" value="{{ $product->user_id }}">
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    @endauth
    <div class="border rounded text-muted d-flex justify-content-start align-items-center p-3">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 3"
            style="width: 40px; height: 100%;">
        <input type="text" name="message" class="border form-control ms-3" id="exampleFormControlInput1"
            placeholder="Tulis Pesan...">
        <button type="submit" id="chatBtnDisabled" class="ms-3 btn btn-white rounded border border"><i
                class="fas fa-paper-plane"></i></button>
    </div>
</form>
</div>
</div>
</div>
</div>
</div> --}}
@endsection

@section('script')
    <!-- LIBARARY JS -->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        // ========================================= Tabs UI ==========================================
        $(function() {
            $("#tabs").tabs();
            $(".fiveStars").tabs({
                classes: {
                    "ui-tabs": "costum-color"
                },
            });
            $(".fourStars").tabs({
                classes: {
                    "ui-tabs": "costum-color"
                }
            });
            $(".threeStars").tabs({
                classes: {
                    "ui-tabs": "costum-color"
                }
            });
            $(".twoStars").tabs({
                classes: {
                    "ui-tabs": "costum-color"
                }
            });
            $(".oneStars").tabs({
                classes: {
                    "ui-tabs": "costum-color"
                }
            });
        });

        $(function() {

            countStarsFive();
            countStarsFour();
            countStarsThree();
            countStarsTwo();
            countStarsOne();

            // fetchAllFiveStar();
            // fetchAllFourStar();
            // fetchAllThreeStar();
            // fetchAllTwoStar();
            // fetchAllOneStar();

            // fetch all employees ajax request
            var displayProduct = 1;
            $('#fiveStars').html(createSkeleton(displayProduct));
            $('#fourStars').html(createSkeleton(displayProduct));
            $('#threeStars').html(createSkeleton(displayProduct));
            $('#twoStars').html(createSkeleton(displayProduct));
            $('#oneStars').html(createSkeleton(displayProduct));

            // jalankan fungsi load content setelah 2 detik
            function createSkeleton(limit) {
                var skeletonHTML = '';
                for (var i = 0; i < limit; i++) {
                    // skeletonHTML += '<div class="row">';
                    skeletonHTML += '<div class="ph-item mt-4 rounded">';
                    skeletonHTML += '<div class="ph-col-2">';
                    skeletonHTML += '<div class="ph-avatar"></div>';
                    skeletonHTML += '</div>';

                    skeletonHTML += '<div class="ph-col-2">';
                    skeletonHTML += '<div class="ph-col-2 big empty"></div>';
                    skeletonHTML += '<div class="ph-col-2 big empty"></div>';
                    skeletonHTML += '<div class="ph-row">';
                    skeletonHTML += '<div class="ph-col-6 rounded"></div>';
                    skeletonHTML += '</div>';
                    skeletonHTML += '</div>';

                    skeletonHTML += '<div class="ph-col-8">';
                    skeletonHTML += '<div class="ph-row">';
                    skeletonHTML += '<div class="ph-col-2 rounded"></div>';
                    skeletonHTML += '<div class="ph-col-4 empty"></div>';
                    skeletonHTML += '<div class="ph-col-4 empty"></div>';
                    skeletonHTML += '<div class="ph-col-4 rounded"></div>';
                    skeletonHTML += '<div class="ph-col-6 empty"></div>';
                    skeletonHTML += '<div class="ph-col-12 big empty"></div>';
                    skeletonHTML += '<div class="ph-col-12 big rounded"></div>';
                    skeletonHTML += '<div class="ph-col-12 empty"></div>';
                    skeletonHTML += '<div class="ph-col-2 rounded"></div>';
                    skeletonHTML += '<div class="ph-col-12 big rounded"></div>';
                    skeletonHTML += '</div>';
                    skeletonHTML += '</div>';

                    skeletonHTML += '</div>';
                    // skeletonHTML += '</div>';
                }
                return skeletonHTML;
            }

            setTimeout(function() {
                fetchAllFiveStar(displayProduct);
                fetchAllFourStar(displayProduct);
                fetchAllThreeStar(displayProduct);
                fetchAllTwoStar(displayProduct);
                fetchAllOneStar(displayProduct);
            }, 2000);

            // ==================================== Count Star Review ===============================

            function countStarsFive() {
                var id = $("input[name=passingIdProduct]").val();
                $.ajax({
                    method: "GET",
                    url: '/five-stars-count/' + id,
                    success: function(response) {
                        $('.five-count').html('');
                        $('.five-count').html(response.countStarsFive);
                        // alert(response.count);
                    }
                });
            }

            function countStarsFour() {
                var id = $("input[name=passingIdProduct]").val();
                $.ajax({
                    method: "GET",
                    url: '/four-stars-count/' + id,
                    success: function(response) {
                        $('.four-count').html('');
                        $('.four-count').html(response.countStarsFour);
                        // alert(response.count);
                    }
                });
            }

            function countStarsThree() {
                var id = $("input[name=passingIdProduct]").val();
                $.ajax({
                    method: "GET",
                    url: '/three-stars-count/' + id,
                    success: function(response) {
                        $('.three-count').html('');
                        $('.three-count').html(response.countStarsThree);
                        // alert(response.count);
                    }
                });
            }

            function countStarsTwo() {
                var id = $("input[name=passingIdProduct]").val();
                $.ajax({
                    method: "GET",
                    url: '/two-stars-count/' + id,
                    success: function(response) {
                        $('.two-count').html('');
                        $('.two-count').html(response.countStarsTwo);
                        // alert(response.count);
                    }
                });
            }

            function countStarsOne() {
                var id = $("input[name=passingIdProduct]").val();
                $.ajax({
                    method: "GET",
                    url: '/one-stars-count/' + id,
                    success: function(response) {
                        $('.one-count').html('');
                        $('.one-count').html(response.countStarsOne);
                        // alert(response.count);
                    }
                });
            }

            // ================================ Review =====================================

            function fetchAllFiveStar() {
                var id = $("input[name=passingIdProduct]").val();
                $.ajax({
                    url: '/five-stars-reviews/' + id,
                    method: 'get',
                    success: function(response) {
                        $("#fiveStars").html(response);
                    }
                });
            }

            function fetchAllFourStar() {
                var id = $("input[name=passingIdProduct]").val();
                $.ajax({
                    url: '/four-stars-reviews/' + id,
                    method: 'get',
                    success: function(response) {
                        $("#fourStars").html(response);
                    }
                });
            }

            function fetchAllThreeStar() {
                var id = $("input[name=passingIdProduct]").val();
                $.ajax({
                    url: '/three-stars-reviews/' + id,
                    method: 'get',
                    success: function(response) {
                        $("#threeStars").html(response);
                    }
                });
            }

            function fetchAllTwoStar() {
                var id = $("input[name=passingIdProduct]").val();
                $.ajax({
                    url: '/two-stars-reviews/' + id,
                    method: 'get',
                    success: function(response) {
                        $("#twoStars").html(response);
                    }
                });
            }

            function fetchAllOneStar() {
                var id = $("input[name=passingIdProduct]").val();
                $.ajax({
                    url: '/one-stars-reviews/' + id,
                    method: 'get',
                    success: function(response) {
                        $("#oneStars").html(response);
                    }
                });
            }
        });

        $('.owl-carousel').owlCarousel({
            loop: false,
            responsiveClass: true,
            URLhashListener: true,
            autoplayHoverPause: true,
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

        const current = document.getElementById("current");
        const opacity = 0.6;
        const imgs = document.querySelectorAll(".img");
        imgs.forEach(img => {
            img.addEventListener("click", (e) => {
                //reset opacity
                imgs.forEach(img => {
                    img.style.opacity = 1;
                });
                current.src = e.target.src;
                //adding class
                //current.classList.add("fade-in");
                //opacity
                e.target.style.opacity = opacity;
            });
        });

        // add new employee ajax request
        $("#addChatForm").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $("#chatBtnDisabled").prop('disabled', true);
            $.ajax({
                url: '{{ route('produk.createChat') }}',
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        showError('message', response.messages.message);
                        $("#chatBtnDisabled").prop('disabled', false);
                    } else if (response.status == 200) {
                        window.location.reload();
                        $("#chatBtnDisabled").prop('disabled', false);
                    }
                }
            });
        });

        $(document).ready(function() {

            $('.increment-btn').click(function(e) {
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

            $('.decrement-btn').click(function(e) {
                e.preventDefault();

                var dec_value = $(this).closest('#product_data').find('.qty-input').val();

                var value = parseInt(dec_value, stoke);
                value = isNaN(value) ? stoke : value;
                if (value > 1) {
                    value--;
                    $(this).closest('#product_data').find('.qty-input').val(value);
                }
            });
        });

        $('body').on('click', '#chat-button', function() {
            sessionStorage.setItem('chat', JSON.stringify($(this).data('chat')))
        })

        // ====================================== Message Firebase ==========================================
        // const messaging = firebase.messaging();
        // messaging.usePublicVapidKey("BOPzmY3tl0kiX3fUSsQBfurfNxn86-jBjjPCbJxObhqxEMu-RFxwwhHNQ-dGRF0SDQMIEuCTi3BOQz_pUYYBvxs");

        // function sendTokenToServer(fcm_token)
        // {
        //     @auth
        //         const user_id = '{{ auth()->user()->id }}';
        //     @endauth
        //     axios.post('/api/save-token', {
        //         fcm_token, user_id
        //     })
        //     .then(res => {
        //         console.log(res);
        //     })
        // }

        // function retrieveToken() {
        //     messaging.getToken()
        //     .then((currentToken) => {
        //         if (currentToken) {
        //             console.log('Token Received : ' +  currentToken)
        //             sendTokenToServer(currentToken);
        //             // Track the token -> client mapping, by sending to backend server
        //             // show on the UI that permission is secured
        //         } else {
        //             alert('You should allow notification!');
        //             // console.log('No registration token available. Request permission to generate one.');
        //             // shows on the UI that permission is required
        //         }
        //     }).catch((err) => {
        //         console.log('An error occurred while retrieving token. ', err);
        //         // catch error while creating client token
        //     });
        // }

        // retrieveToken();

        // messaging.onTokenRefresh(() => {
        //     retrieveToken();
        // });

        // messaging.onMessage((payload)=>{
        //     console.log('Message received');
        //     console.log(payload);

        //     location.reload();
        // });
    </script>
@endsection
