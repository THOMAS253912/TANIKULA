<!-- Header -->
@include('components.admin.header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('plus-admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div> --}}

        <!-- Navbar -->
        @include('components.admin.navbar')

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ asset('img/Logo TaniKula.svg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Tanikula</span>
            </a>

            <!-- Sidebar -->
            @include('components.admin.sidebar')

        </aside>

        <div class="content-wrapper">

            @yield('content')

        </div>

        <!-- Footer -->
        @include('components.admin.footer')


        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <!-- Footer JS -->
    @include('components.admin.footerJS')


</body>

</html>
