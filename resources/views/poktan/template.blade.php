{{-- Header --}}
@include('components.poktan.header')

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>

            {{-- Navbar --}}
            @include('components.poktan.navbar')


            <div class="main-sidebar">

                {{-- Sidebar --}}
                @include('components.poktan.sidebar')


            </div>

            @yield('content')

            {{-- Footer --}}
            @include('components.poktan.footer')


        </div>
    </div>

    {{-- Footer JS --}}
    @include('components.poktan.footerJS')


</body>

</html>
