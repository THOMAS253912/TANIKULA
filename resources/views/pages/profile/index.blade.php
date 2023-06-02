@extends('pages.template1')
@section('title', 'Profile')
@section('breadcrumb-title', 'Profile')
@section('breadcrumb-subTitle', $name)

@section('style')
{{-- Style --}}
<link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
@php
    $koleksiProduk = App\Models\Product::with('photo_product', 'review')
        ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
        ->join('users', 'products.user_id', '=', 'users.id')
        ->select('products.*', 'product_categories.name as category_name')
        ->where('product_categories.is_active', '=', 1)
        ->where('products.is_active', '=', 1)
        ->where('user_id', $gapoktan->user_id)
        ->count();

    $penilaianProduk = App\Models\Review::with('user', 'product', 'order')
        ->join('users', 'reviews.user_id', '=', 'users.id')
        ->join('products', 'reviews.product_id', '=', 'products.id')
        ->select('reviews.*', 'users.name as name_reviewer')
        ->where('products.user_id', '=', $gapoktan->user_id)
        ->count();
@endphp
<script>
    var countProductPenjual = '{{ $koleksiProduk }}';
</script>
<input type="hidden" name="passingIdPenjualProduct" value="{{ $name }}">
<section class="">
    <div class="container">
        <div class="">
            <div class="">
                <div class="row">
                    <div class="col-12">
                        <div class="card-body row align-items-center">
                            <div class="rounded-top text-white d-flex flex-row"
                                style="background-color: #16A085; height:200px;">
                                <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                                    @if ($gapoktan->image)
                                    <div class="mt-4 mb-2" style="z-index: 1">
                                        <img src="{{ asset('../storage/profile/'.$gapoktan->image) }}"
                                            alt="Generic placeholder image" class="border rounded-circle border-white img-fluid"
                                            style="width: 150px; height: 150px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                    </div>
                                    @else
                                        <img src="../assets/img/avatar/avatar-1.png"
                                            alt="Generic placeholder image" class="border rounded-circle border-white shadow-sm mt-4 mb-2"
                                            style="width: 150px; z-index: 1; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                    @endif
                                </div>
                                <div class="ms-3" style="margin-top: 130px;">
                                    <h6 style="font-weight: bold">{{ $gapoktan->user->name }}</h6>
                                    <p><i class="bi bi-geo-alt me-1"></i>
                                        @if ($gapoktan->city_id)
                                            {{ $gapoktan->city->name }}
                                        @else
                                            Lokasi tidak terdefinisi
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="p-4 text-black" style="background-color: #f8f9fa;">
                                <div class="d-flex justify-content-end text-center py-1">
                                    <div>
                                        <p class="mb-1 h5" style="color: #16A085">{{ $koleksiProduk }}</p>
                                        <p class="small text-muted mb-0">Produk</p>
                                    </div>
                                    <div class="px-3">
                                        @php
                                        $rateNum = number_format($ratingValue)
                                        @endphp
                                        <p class="mb-1 h5" style="color: #16A085">@if ( $penilaianProduk < 1000)
                                            <i class="lni lni-star-filled" style="color: #f0d800"></i> {{ $rateNum }} ({{ $penilaianProduk }} Penilaian)
                                        @elseif ($penilaianProduk === 1000 || 2000 || 3000 || 4000 || 5000 || 6000 || 7000 || 8000 || 9000 || 10000)
                                            <i class="lni lni-star-filled"></i> {{ $rateNum }} ({{ substr($penilaianProduk, 0, 1) }}RB Penilaian)
                                        @endif</p>
                                        <p class="small text-muted mb-0">Penilaian</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="lead fw-bold mb-0" style="color: #16A085">Produk</p>
                                    <div class="dropdown dropstart">
                                        <button class="btn btn-light dropdown-toggle" style="color:#16A085;" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Filter Berdasarkan
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <input type="hidden" name="max_price" id="max_price" value="max_price">
                                                <button type="button" id="max_price_btn" class="dropdown-item">Harga Tertinggi</button>
                                            </li>
                                            <li>
                                                <input type="hidden" name="min_price" id="min_price" value="min_price">
                                                <button type="button" id="min_price_btn" class="dropdown-item">Harga Terendah</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row mx-4 mx-sm-0" id="produkGapoktan">
                                    {{-- Content --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
{{-- Script --}}
<!-- LIBARARY JS -->
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- AKHIR LIBARARY JS -->
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $(function() {
        // fetch all employees ajax request
        var displayProduct = countProductPenjual;
        $('#produkGapoktan').html(createSkeleton(displayProduct));

        // jalankan fungsi load content setelah 2 detik
        function createSkeleton(limit)
        {
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
            fetchallprodukGapoktan(displayProduct);
        }, 2000);

        function fetchallprodukGapoktan(max_price = 'max_price' , min_price = 'min_price') {
            var id = $("input[name=passingIdPenjualProduct]").val();
            $.ajax({
                url: '/fetchall-produk-gapoktan/' + id,
                data:{
                    max_price:max_price,
                    min_price:min_price,
                },
                method: 'get',
                success: function(response) {
                    $("#produkGapoktan").html(response);
                }
            });
        }

        $('#max_price_btn').click(function(){
            var max_price = $('#max_price').val();
            if(max_price == 'max_price')
            {
                $('table').DataTable().destroy();
                fetchallprodukGapoktan(max_price = 'max_price');
            }
            else
            {
                fetchallprodukGapoktan();
            }
        });

        $('#min_price_btn').click(function(){
            var min_price = $('#min_price').val();
            if(min_price == 'min_price')
            {
                $('table').DataTable().destroy();
                fetchallprodukGapoktan(min_price = 'min_price');
            }
            else
            {
                fetchallprodukGapoktan();
            }
        });
    });
</script>
@endsection
