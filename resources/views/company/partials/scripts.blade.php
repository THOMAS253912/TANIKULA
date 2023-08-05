<!-- JavaScript Libraries -->
<script src="{{ asset('assets/company/lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/company/lib/jquery/jquery-migrate.min.js') }}"></script>
<script src="{{ asset('assets/company/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/company/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('assets/company/lib/superfish/hoverIntent.js') }}"></script>
<script src="{{ asset('assets/company/lib/superfish/superfish.min.js') }}"></script>
<script src="{{ asset('assets/company/lib/wow/wow.min.js') }}"></script>
<script src="{{ asset('assets/company/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/company/lib/magnific-popup/magnific-popup.min.js') }}"></script>
{{-- <script src="{{ asset('assets/company/lib/sticky/sticky.js') }}"></script> --}}
<!-- Template Main Javascript File -->
<script src="{{ asset('assets/company/js/main.js') }}"></script>

<script>
    $('.img-portofolio').on('error', function() {
        $(this).prop('src', '/assets/company/banner/slider3.jpg')
    })
</script>
