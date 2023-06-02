$(document).ready(function () {

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

    $('#addToCartBtn').click(function (e) {
        e.preventDefault();

        var product_id = $(this).closest('#product_data').find('#prod_id').val();
        var product_qty = $(this).closest('#product_data').find('.qty-input').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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
                    window.location.reload();
                    iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                        title: 'Berhasil',
                        message: response.status,
                        position: 'topRight'
                    });
                }
            }
        });
    });

    // $('#delete-cart-wishlistItem').click(function (e) {
        // $(document).on('click', '#delete-cart-wishlistItem', function (e) {
        //     e.preventDefault();

        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });

        //     var product_id = $(this).closest('#product_data').find('#prod_id').val();

        //     $.ajax({
        //         method: "POST",
        //         url: "/delete-cart-wishlist",
        //         data: {
        //             'product_id': product_id,
        //         },
        //         success: function (response) {
        //             window.location.reload();
        //             // $('.WishlistItems').load(location.href + '.WishlistItems');
        //             iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
        //                 title: 'Berhasil',
        //                 message: response.status,
        //                 position: 'topRight'
        //             });
        //         }
        //     });
        // });

    $('#addToWishlistBtn').click(function (e) {
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
                    // window.location.reload();
                    iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                        title: 'Berhasil',
                        message: response.status,
                        position: 'topRight'
                    });
                }
            }
        });
    });

    $('.increment-btn').click(function (e) {
    // $(document).on('click', '.increment-btn', function (e) {
        e.preventDefault();

        // var inc_value = $('.qty-input').val();

        var inc_value = $(this).closest('#product_data').find('.qty-input').val();
        var value = parseInt(inc_value, 10);
        value = isNaN(value) ? 0 : value;
        if (value < 10) {
            value++;
            // $('.qty-input').val(value);
            $(this).closest('#product_data').find('.qty-input').val(value);
        }
    });

    $('.decrement-btn').click(function (e) {
    // $(document).on('click', '.decrement-btn', function (e) {
        e.preventDefault();

        // var dec_value = $('.qty-input').val();
        var dec_value = $(this).closest('#product_data').find('.qty-input').val();

        var value = parseInt(dec_value, 10);
        value = isNaN(value) ? 0 : value;
        if (value > 1) {
            value--;
            // $('.qty-input').val(value);
            $(this).closest('#product_data').find('.qty-input').val(value);
        }
    });

    $('.delete-cart-item').click(function (e) {
    // $(document).on('click', '.delete-cart-item', function (e) {
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
                window.location.reload();
                // $('.CartItems').load(location.href + '.CartItems');

                iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                    title: 'Berhasil',
                    message: response.status,
                    position: 'topRight'
                });
            }
        });
    });

    $('.changeQuantity').click(function (e) {
    // $(document).on('click', '.changeQuantity', function (e) {
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
                // $('.CartItems').load(location.href + '.CartItems');
            }
        });
    });
});
