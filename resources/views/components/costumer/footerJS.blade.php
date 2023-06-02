{{-- Js --}}
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<!--   Core JS Files   -->
<script src="/costumer/assets/js/core/popper.min.js"></script>
<script src="/costumer/assets/js/core/bootstrap.min.js"></script>
<script src="/costumer/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/costumer/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="/costumer/assets/js/material-dashboard.min.js?v=3.0.0"></script>
{{-- <script src="{{ asset('js/market.js') }}"></script> --}}
<script src="{{ asset('js/function.js') }}"></script>
@yield('script')

<script>
    // <-- Route Link -->
    // Pengaturan
    function pembeli_dashboard(url) {
        window.location = url;
    }
    // Halaman Wishlist
    function pembeli_wishlist(url) {
        window.location = url;
    }
    // Halaman Daftar Transaksi
    function pembeli_daftar_transaksi(url) {
        window.location = url;
    }
    // Halaman Menunggu Pembayaran
    function pembeli_menunggu_pembayaran(url) {
        window.location = url;
    }
    // Halaman Ulasan
    function pembeli_ulasan(url) {
        window.location = url;
    }
    // Halaman Chat
    function pembeli_chat(url) {
        window.location = url;
    }
    // Halaman Alamat
    function pembeli_alamat(url) {
        window.location = url;
    }
    // Halaman Pemberitahuan
    function pembeli_pemberitahuan(url) {
        window.location = url;
    }

    $(function() {
        // delete employee ajax request
        $(document).on('click', '.deletePhoto', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
            title: 'Hapus Foto Profil',
            text: "Apa kamu yakin Ingin menghapus foto profil?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Cancel!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url: '{{ route('pembeli.delete.profile') }}',
                method: 'delete',
                data: {
                    id: id,
                    _token: csrf
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire(
                    'Berhasil!',
                    'Foto profil telah dihapus!',
                    'success'
                    )
                    window.setTimeout(function(){location.reload()},1000);
                }
                });
            }
            })
        });
    });
</script>
