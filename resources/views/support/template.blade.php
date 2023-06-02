<!-- Header -->
@include('components.support.header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('plus-admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div> --}}

        <!-- Navbar -->
        @include('components.support.navbar')

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ asset('img/Logo TaniKula.svg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Tanikula</span>
            </a>

            <!-- Sidebar -->
            @include('components.support.sidebar')

        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        {{-- <div class="col-sm-6">
                            <h1 class="m-0">@yield('title')</h1>
                        </div> --}}
                        <div class="col-sm-12">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="">Support</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @yield('content')
        </div>

        <!-- Footer -->
        @include('components.support.footer')


        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <!-- Footer JS -->
    @include('components.support.footerJS')


</body>

</html>
