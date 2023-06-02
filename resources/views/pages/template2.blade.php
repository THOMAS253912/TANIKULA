@include('components.pages.header')

<body>
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

    <!-- Start Header Area -->
    <header class="header navbar-area">
        <!-- Start Header Middle -->
        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-7">
                        <!-- Start Header Logo -->
                        <a class="navbar-brand" href="{{ url('edukasi') }}">
                            <h3> <span style="color: #16A085">Edukasi</span>Petani</h3>
                        </a>
                        <!-- End Header Logo -->
                    </div>
                    <div class="col-lg-5 col-md-5 d-xs-none">
                    </div>
                    <div class="col-lg-4 col-md-3 col-5">
                        <div class="middle-right-area">
                            <div class="user">
                            </div>
                            <ul class="d-flex p-3 user-login">
                                <li>
                                    <a style="color: var(--primary); font-weight: bold; font-size: 15px" href="{{ url('petani') }}" class="text-capitalize d-block d-sm-none">
                                        <i class="fas fa-solid fa-house"></i> Dasbor {{ Illuminate\Support\Str::limit(auth()->user()->name, '1') }}
                                    </a>
                                    <a style="color: var(--primary); font-weight: bold; font-size: 15px" href="{{ url('petani') }}" class="text-capitalize d-none d-sm-block">
                                        <i class="fas fa-solid fa-house"></i> Dasbor {{ strtok(auth()->user()->name, ' ') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Middle -->
    </header>
    <!-- End Header Area -->


    @yield('content')

    <!-- Start Footer Area -->
    <footer class="footer" style="border-top: 1px solid #eee;">
        <!-- Start Footer Middle -->
        <div class="footer-middle">
            <div class="container">
                <div class="bottom-inner">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Social Media</h3>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)" class="mx-1"><i class="bi bi-facebook h4"></i></a>
                                        <a href="javascript:void(0)" class="mx-1"><i class="bi bi-instagram h4"></i></a>
                                        <a href="javascript:void(0)" class="mx-1"><i class="bi bi-whatsapp h4"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-contact">
                                <h3>Hubungi Kami</h3>
                                <p class="phone">Sri Makmur, Desa Krasak</p>
                                <p class="phone">Kec Jatibarang, Kab Indramayu,</p>
                                <p class="phone">Provinsi Jawa Barat.</p>
                                <ul>
                                    <li>
                                        <p class="mail"><a href="mailto:support@shopgrids.com">srimakmur@gmail.com</a></p>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer our-app">
                                <h3 style="font-size: 32px"> <span style="color: #16A085">Edukasi</span>Petani</h3>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Middle -->
    </footer>
    <!--/ End Footer Area -->


    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top border border-white">
        <i class="lni lni-chevron-up"></i>
    </a>

    @include('components.pages.footerJS')
</body>

</html>
