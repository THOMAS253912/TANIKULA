<!-- ========================= JS here ========================= -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js"
        integrity="sha256-siqh9650JHbYFKyZeTEAhq+3jvkFCG8Iz+MHdr9eKrw=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/tiny-slider.js') }}"></script>
<script src="{{ asset('js/glightbox.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
@include('vendor.lara-izitoast.toast')
    <!-- Page Specific JS File -->
<script src="{{ asset('js/function.js') }}"></script>
{{-- <script src="{{ asset('js/market.js') }}"></script> --}}
@yield('script')
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script type="text/javascript">
    // Route Link
    // Home
    function home(url) {
        window.location = url;
    }
    // Hubungi Kami
    function hubungi_kami(url) {
        window.location = url;
    }
    // Pembeli Dashboard
    function pembeli(route) {
        window.location = route;
    }
    // Pembeli Dashboard
    function gapoktan(route) {
        window.location = route;
    }
    // Pembeli Dashboard
    function poktan(route) {
        window.location = route;
    }
    // Pembeli Dashboard
    function petani(route) {
        window.location = route;
    }
    // Admin Dashboard
    function admin(route) {
        window.location = route;
    }
    // Support Dashboard
    function support(route) {
        window.location = route;
    }
    // Login
    function login(url) {
        window.location = url;
    }
    // Register
    function register(url) {
        window.location = url;
    }
    // Register
    function registerGapoktan(url) {
        window.location = url;
    }
    // Max price new product
    function newproduct_maxPrice(url) {
        window.location = url;
    }
    // Min price new product
    function newproduct_minPrice(url) {
        window.location = url;
    }
    // Max price based search
    function basedSearch_maxPrice(url) {
        window.location = url;
    }
    // Min price based search
    function basedSearch_minPrice(url) {
        window.location = url;
    }
    // Max price all category
    function allCategory_maxPrice(url) {
        window.location = url;
    }
    // Min price all category
    function allCategory_minPrice(url) {
        window.location = url;
    }

    //========= Hero Slider
    tns({
        container: '.hero-slider',
        slideBy: 'page',
        autoplay: true,
        autoplayButtonOutput: false,
        mouseDrag: true,
        gutter: 0,
        items: 1,
        nav: false,
        controls: true,
        controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
    });

    //======== Brand Slider
    tns({
        container: '.brands-logo-carousel',
        autoplay: true,
        autoplayButtonOutput: false,
        mouseDrag: true,
        gutter: 15,
        nav: false,
        controls: false,
        responsive: {
            0: {
                items: 1,
            },
            540: {
                items: 3,
            },
            768: {
                items: 5,
            },
            992: {
                items: 6,
            }
        }
    });
</script>
{{-- <script>
    $(document).ready(function () {

        $('#dynamic_content').html(make_skeleton())

        // jalankan fungsi load content setelah 2 detik
        setTimeout(function(){
            load_content()
        }, 2000);

        function make_skeleton() {
            var output = '';
            for (var count = 0; count < 6; count++) {
                output += '<div class="col-4">';
                output += '<div class="ph-item">';
                output += '<div class="ph-col-12">';
                output += '<div class="ph-picture"></div>';
                output += '<div class="ph-row">';
                output += '<div class="ph-col-6 big"></div>';
                output += '<div class="ph-col-4 empty big"></div>';
                output += '<div class="ph-col-12"></div>'
                output += '<div class="ph-col-12"></div>'
                output += '</div>';
                output += '</div>';
                output += '</div>';
                output += '</div>';
            }
            return output;
        }

        //membuat fungsi load data dari data.php
        function load_content(limit){
            $.ajax({
                url: 'data.php',
                method: 'POST',
                data:{limit:limit},

                //jika sukses maka gantilah skeleton loader dengan data.php
                success:function(data){
                    $('#dynamic_content').html(data);
                }
            });
        }
    });
</script> --}}
<script>
    var path = "{{ route('productListAjax')  }}";
    $('input.typeaheadProduct').typeahead({
        source: function (query, process) {
            return $.get(path, {
                term: query
            }, function (data) {
                return process(data);
            });
        }
    });

    // var availableTags = [];
    // $.ajax({
    //     url: "/product-list",
    //     method: "GET",
    //     success: function (response) {
    //         // console.log(response);
    //         startAutoComplete(response);
    //     }
    // });

    // function startAutoComplete(availableTags) {
    //     $("#search_product").autocomplete({
    //         source: availableTags
    //     });
    // }
</script>
<script>
    $(document).ready(function () {

    LoadNotif();
    LoadCart();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function LoadCart()
    {
        $.ajax({
            method: "GET",
            url: "/load-cart",
            success: function (response) {
                $('.cart-count').html('');
                $('.cart-count').html(response.count);
                // alert(response.count);
            }
        });
    }

    function LoadNotif()
    {
        $.ajax({
            method: "GET",
            url: "/load-notifications",
            success: function (response) {
                $('.notif-count').html('');
                $('.notif-count').html(response.count);
                // alert(response.count);
            }
        });
    }

    $('#addToCartBtn').click(function (e) {
        e.preventDefault();

        var product_id = $(this).closest('#product_data').find('#prod_id').val();
        var product_qty = $(this).closest('#product_data').find('.qty-input').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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

    $('#addToWishlistBtn').click(function (e) {
        e.preventDefault();

        var product_id = $(this).closest('#product_data').find('#prod_id').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#addToWishlistBtn").prop('disabled', true);
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
                    // window.location.reload();
                    $("#addToWishlistBtn").prop('disabled', false);
                    iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                        title: 'Berhasil',
                        message: response.status,
                        position: 'topRight'
                    });
                }
            }
        });
    });

    // $('#idNotif').click(function (e) {
    //     e.preventDefault();

    //     // var id = $("input[name=passingIdNotif]").val();
    //     var id = $(this).closest('#style-1').find('#passingIdNotif').val();

    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });

    //     $.ajax({
    //         method: "POST",
    //         url: '/read-notif-data',
    //         data: {
    //             'id': id,
    //         },
    //         success: function (response) {
    //             window.setTimeout(function(){location.reload()},1000)
    //         }
    //     });
    // });

    // add new employee ajax request
    $("#readNotif").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '{{ route('read.all.notif') }}',
            method: 'get',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 200){
                    window.setTimeout(function(){location.reload()},1000)
                }
            }
        });
    });

    $('.delete-cart-item').click(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var product_id = $(this).closest('#product_data').find('#prod_id').val();

        $.ajax({
            method: "POST",
            url: "delete-cart-item",
            data: {
                'product_id': product_id,
            },
            success: function (response) {
                LoadCart();
                iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                    title: 'Berhasil',
                    message: response.status,
                    position: 'topRight'
                });
                window.setTimeout(function(){location.reload()},1000)
            }
        });
    });

    $('.delete-out-of-stock-product').click(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var prod_id_outof_stock = $(this).closest('#product_outof_stock').find('#prod_id_outof_stock').val();

        $.ajax({
            method: "POST",
            url: "delete-out-of-stock-product",
            data: {
                'prod_id_outof_stock': prod_id_outof_stock,
            },
            success: function (response) {
                LoadCart();
                iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                    title: 'Berhasil',
                    message: response.status,
                    position: 'topRight'
                });
                window.setTimeout(function(){location.reload()},1000)
            }
        });
    });

    $('.changeQuantity').click(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var product_id = $(this).closest('#product_data').find('#prod_id').val();
        var qty = $(this).closest('#product_data').find('.qty-input').val();

        $.ajax({
            method: "POST",
            url: "update-cart-item",
            data: {
                'product_id': product_id,
                'product_qty': qty,
            },
            success: function (response) {
                window.location.reload();
            }
        });
    });

    $('.navbarCheckProductCart').click( function()
        {
            var totalCheckboxes = $("input#navbarCheckProductCart:checked").length;
            var sum = 0;
            var total = 0;
            if (totalCheckboxes) {
                var checkedInputs = $("input#navbarCheckProductCart:checked");
                var sum_qty = 0;
                var total_price = 0;
                $.each(checkedInputs, function(i, val) {
                    var qty = $(this).closest('.navbarCheckProductCart').find("input[name=navbar_cart_qty]").val();
                    var price = $(this).closest('.navbarCheckProductCart').find("input[name=navbar_cart_total]").val();
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
                url: "/navbar-keranjang",
                data: {
                    'totalCheckboxes': totalCheckboxes,
                    'sum': sum,
                    'total': total
                },
                success: function (response)
                {
                    $('.navbar-beli-keranjang-count').html('');
                    $('.navbar-beli-keranjang-count').html(response.countCart);

                    $('.navbar-count-product').html('');
                    $('.navbar-count-product').html(response.countQty);

                    $('.navbar-total-price').html('');
                    $('.navbar-total-price').html(response.totalPrice);
                }
            });
        });
});
</script>
