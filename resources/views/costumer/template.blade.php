<!-- Header -->
@include('components.costumer.header')

<body class="g-sidenav-show bg-gray-100">

    {{-- Sidebar  --}}
    @include('components.costumer.sidebar')

    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

        <!-- Navbar -->
        @include('components.costumer.navbar')

        @yield('content')

    </div>

    <!-- Footer JS -->
    @include('components.costumer.footerJS')

</body>

</html>
