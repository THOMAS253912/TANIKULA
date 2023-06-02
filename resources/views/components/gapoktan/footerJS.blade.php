<!-- General JS Scripts -->
{{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> --}}
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="{{ asset('js/stisla.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>

<!-- Page Specific JS File -->
{{-- <script src="{{ asset('js/page/index-0.js') }}"></script> --}}

<script src="{{ asset('js/function.js') }}"></script>

@yield('script')

<script>
    // <-- Route Link -->
    // Dashboard
    function gapoktan_dashboard(url) {
        window.location = url;
    }
    // Chat
    function gapoktan_chat(url) {
        window.location = url;
    }
    // Kategori Produk
    function gapoktan_kategori_produk(url) {
        window.location = url;
    }
    // Kategori Edukasi
    function gapoktan_kategori_edukasi(url) {
        window.location = url;
    }
    // Kategori Kegiatan
    function gapoktan_kategori_kegiatan(url) {
        window.location = url;
    }
    // Produk
    function gapoktan_produk(url) {
        window.location = url;
    }
    // Edukasi
    function gapoktan_edukasi(url) {
        window.location = url;
    }
    // Reply Pesanan
    function gapoktan_reply_ulasan(url) {
        window.location = url;
    }
    // Pesanan
    function gapoktan_pesanan(url) {
        window.location = url;
    }
    // Kategori Lahan
    function gapoktan_kategori_lahan(url) {
        window.location = url;
    }
    // Lahan
    function gapoktan_lahan(url) {
        window.location = url;
    }
    // Kegiatan
    function gapoktan_kegiatan(url) {
        window.location = url;
    }
    // Akun Poktan
    function gapoktan_daftar_poktan(url) {
        window.location = url;
    }
    // Akun Petani
    function gapoktan_daftar_petani(url) {
        window.location = url;
    }
    // Tandur
    function gapoktan_tandur(url) {
        window.location = url;
    }
    // Panen
    function gapoktan_panen(url) {
        window.location = url;
    }
    // Riwayat Penanam
    function gapoktan_riwayat_penanam(url) {
        window.location = url;
    }
    // Rekap Penjualan
    function gapoktan_rekap_penjualan(url) {
        window.location = url;
    }
    // Pengaturan
    function gapoktan_pengaturan(url) {
        window.location = url;
    }

    $(document).ready(function () 
    {
        LoadReview();
        LoadOrder();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            function LoadReview()
            {
                $.ajax({
                    method: "GET",
                    url: "/load-review",
                    success: function (response) {
                        $('.review-count').html('');
                        $('.review-count').html(response.count);
                        // alert(response.count);
                    }
                });
            }

            function LoadOrder()
            {
                $.ajax({
                    method: "GET",
                    url: "/load-order",
                    success: function (response) {
                        $('.order-count').html('');
                        $('.order-count').html(response.count);
                        // alert(response.count);
                    }
                });
            }

            $(document).on('click', '.notifUser', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                    $.ajax({
                    url: '{{ route('gapoktan.markas.read.user') }}',
                    method: 'POST',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        window.location = '{{ route('gapoktan-poktan') }}';
                    }
                });
            });

            $(document).on('click', '.notifPlant', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                    $.ajax({
                    url: '{{ route('gapoktan.markas.read.plant') }}',
                    method: 'POST',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        window.location = '{{ route('gapoktan-tandur') }}';
                    }
                });
            });

            $(document).on('click', '.notifHarvest', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                    $.ajax({
                    url: '{{ route('gapoktan.markas.read.harvest') }}',
                    method: 'POST',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        window.location = '{{ route('gapoktan-panen') }}';
                    }
                });
            });
    });
</script>
