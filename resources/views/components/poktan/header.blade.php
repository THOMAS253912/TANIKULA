<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Poktan | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/Logo TaniKula.svg') }}" />

    @yield('style')

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> --}}

    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="../node_modules/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="../node_modules/weathericons/css/weather-icons.min.css">
    <link rel="stylesheet" href="../node_modules/weathericons/css/weather-icons-wind.min.css">
    <link rel="stylesheet" href="../node_modules/summernote/dist/summernote-bs4.css"> --}}

    <style>
        /* 4.3 Page */
        .page-error-notification {
            height: 100%;
            width: 100%;
            padding-top: 60px;
            text-align: center;
            display: table;
        }

        .page-error-notification .page-inner-notification {
            display: table-cell;
            width: 100%;
            vertical-align: middle;
        }

        .page-error-notification img {
            width: 10rem;
        }

        .page-error-notification .page-description-notification {
            padding-top: 30px;
            font-size: 18px;
            font-weight: 400;
            color: color: var(--primary);;
        }

        @media (max-width: 575.98px) {
            .page-error-notification {
                padding-top: 0px;
            }
        }
    </style>

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
</head>
