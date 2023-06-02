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

    @yield('content')

    @include('components.pages.footer')

    <!-- ========================= scroll-top ========================= -->
    @if (!Request::is('cart'))
    <a href="#" class="scroll-top border border-white">
        <i class="lni lni-chevron-up"></i>
    </a>
    @endif

    @include('components.pages.footerJS')
</body>

</html>
