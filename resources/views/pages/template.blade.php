@include('components.pages.header')

<body>
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

    <!-- Preloader -->
    {{-- <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div> --}}
    <!-- /End Preloader -->

    @include('components.pages.navbar')

    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 custom-padding-right">

                    @include('components.pages.slider')

                </div>
                {{-- <div class="col-lg-4 col-12">
                    <div class="row">

                        @include('components.pages.banner')

                    </div>
                </div> --}}
            </div>
        </div>
    </section>
    <!-- End Hero Area -->

    @yield('content')

    @include('components.pages.footer')

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top border border-white">
        <i class="lni lni-chevron-up"></i>
    </a>

    @include('components.pages.footerJS')
</body>

</html>
