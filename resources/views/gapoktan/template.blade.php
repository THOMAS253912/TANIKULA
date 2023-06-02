{{-- Header --}}
@include('components.gapoktan.header')

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>

            {{-- Navbar --}}
            @include('components.gapoktan.navbar')


            <div class="main-sidebar">

                {{-- Sidebar --}}
                @include('components.gapoktan.sidebar')


            </div>

            @yield('content')

            {{-- Footer --}}
            @include('components.gapoktan.footer')


        </div>
    </div>

    {{-- Footer JS --}}
    @include('components.gapoktan.footerJS')


</body>

</html>
