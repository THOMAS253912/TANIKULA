<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="description" content="Free open source Tailwind CSS Store template">
    <meta name="keywords"
        content="tailwind,tailwindcss,tailwind css,css,starter template,free template,store template, shop layout, minimal, monochrome, minimalistic, theme, nordic">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">

    <style>
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .text-green-gapoktan {
            color: #16A085;
        }

        .hover-text-green-gapoktan:hover {
            color: #16A085;
        }

        .bg-green-gapoktan {
            background-color: #16A085;
        }

        .work-sans {
            font-family: 'Work Sans', sans-serif;
        }

        #menu-toggle:checked+#menu {
            display: block;
        }

        .hover\:grow {
            transition: all 0.3s;
            transform: scale(1);
        }

        .hover\:grow:hover {
            transform: scale(1.02);
        }

        .text-green-desa {
            color: #16A085;
        }

        .hover-text-green-desa:hover {
            color: #16A085;
        }

        .bg-green-desa {
            background-color: #16A085;
        }

        .no-spinners {
            -moz-appearance: textfield;
        }

        .no-spinners::-webkit-outer-spin-button,
        .no-spinners::-webkit-inner-spin-button {
            margin: 0;
            -webkit-appearance: none;
        }
    </style>
</head>

<body class="leading-normal tracking-normal text-gray-600" style="font-family: 'Source Sans Pro', sans-serif;">

    <div class="pb-14">

        {{-- Navbar --}}
        <div class="fixed bg-white z-50 w-full shadow mx-auto py-2 px-6 md:px-14">
            <div class="w-full flex items-center justify-between">
                <a class="flex items-center text-green-gapoktan no-underline hover:no-underline font-bold text-2xl lg:text-4xl"
                    href="#">
                    <img class="w-7 mr-2" src="{{ asset('img/farmer.svg') }}" alt="">
                    <p class="flex">
                    GAPOKTAN <span class="flex text-sm">Edukasi</span>
                    </p>
                </a>

                <div class="flex w-1/2 justify-end content-center">
                    {{-- <a class="inline-block text-green-gapoktan no-underline hover:text-green-800 hover:text-underline text-center h-10 p-2 md:h-auto md:p-4"
                        data-tippy-content="@twitter_handle" href="https://twitter.com/intent/tweet?url=#">
                        <svg class="fill-current h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24">
                            <path
                                d="M21,7H7.462L5.91,3.586C5.748,3.229,5.392,3,5,3H2v2h2.356L9.09,15.414C9.252,15.771,9.608,16,10,16h8 c0.4,0,0.762-0.238,0.919-0.606l3-7c0.133-0.309,0.101-0.663-0.084-0.944C21.649,7.169,21.336,7,21,7z M17.341,14h-6.697L8.371,9 h11.112L17.341,14z" />
                            <circle cx="10.5" cy="18.5" r="1.5" />
                            <circle cx="17.5" cy="18.5" r="1.5" />
                        </svg>
                    </a> --}}
                    <a class="inline-block text-green-gapoktan no-underline hover:text-green-800 hover:text-underline text-center h-10 p-2 md:h-auto md:p-4 text-lg"
                        href="{{ route('login') }}">
                        Andri Firmansyah
                    </a>
                </div>

            </div>
        </div>

        <!--Main-->
        <div class="container px-6 mx-auto">

            {{-- Konten --}}
            @yield('content')

            <!--Footer-->
            @include('components.pages.footer')

        </div>

    </div>

</body>

</html>