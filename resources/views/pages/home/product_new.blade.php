@extends('pages.template1')
@section('title', 'Produk Terbaru')
@section('breadcrumb-title', 'Produk')
@section('breadcrumb-subTitle', 'Terbaru')

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
    {{-- {{ url('product-category/'.$item->product_category->slug) }} --}}
    <!-- Start Trending Product Area -->
    <script>
        var countProductNew = '{{ $countProduct }}';
    </script>
    <section class="section">
        <div class="container">
            <div class="row mx-4 mx-sm-0" id="show_all_employees">
                {{-- Content --}}
            </div>
        </div>
    </section>
    <!-- End Trending Product Area -->
@endsection

@section('script')
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
        // fetchAllEmployees();

        var displayProduct = countProductNew;
        $('#show_all_employees').html(createSkeleton(displayProduct));

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
            fetchAllEmployees(displayProduct);
        }, 2000);

        function fetchAllEmployees(max_price = 'max_price' , min_price = 'min_price') {
            $.ajax({
                url: '{{ route('fetchAllNewProduct') }}',
                data:{
                    max_price:max_price,
                    min_price:min_price,
                },
                method: 'get',
                success: function(response) {
                    $("#show_all_employees").html(response);
                }
            });
        }

        $('#max_price_btn').click(function(){
            var max_price = $('#max_price').val();
            if(max_price == 'max_price')
            {
                $('table').DataTable().destroy();
                fetchAllEmployees(max_price = 'max_price');
            }
            else
            {
                fetchAllEmployees();
            }
        });

        $('#min_price_btn').click(function(){
            var min_price = $('#min_price').val();
            if(min_price == 'min_price')
            {
                $('table').DataTable().destroy();
                fetchAllEmployees(min_price = 'min_price');
            }
            else
            {
                fetchAllEmployees();
            }
        });
    });
</script>
@endsection
