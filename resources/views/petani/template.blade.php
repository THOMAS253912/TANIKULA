{{-- Header --}}
@include('components.petani.header')

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>

            {{-- Navbar --}}
            @include('components.petani.navbar')


            <div class="main-sidebar">

                {{-- Sidebar --}}
                @include('components.petani.sidebar')


            </div>

            @yield('content')

            {{-- Footer --}}
            @include('components.petani.footer')


        </div>
    </div>

    {{-- Footer JS --}}
    @include('components.petani.footerJS')


</body>

</html>
