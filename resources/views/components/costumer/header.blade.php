<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ auth()->user()->id }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/Logo TaniKula.svg') }}" />
    {{-- <link rel="apple-touch-icon" sizes="76x76" href="{{asset('../costumer/assets/img/apple-icon.png')}}"> --}}
    {{-- <link rel="icon" type="image/png" href="{{asset('../costumer/assets/img/favicon.png')}}"> --}}
    <title>
        TaniKula | @yield('title')
    </title>

    @yield('style')
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('../costumer/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('../costumer/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('css/LineIcons.3.0.css') }}" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('../costumer/assets/css/material-dashboard.css?v=3.0.') }}" rel="stylesheet" />

    {{-- <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyB_V08q4UmDxg0folXvu52K2pyWrCu1cRE",
            authDomain: "gapoktanapp.firebaseapp.com",
            projectId: "gapoktanapp",
            storageBucket: "gapoktanapp.appspot.com",
            messagingSenderId: "314161819154",
            appId: "1:314161819154:web:02ffebe39462bd7b8232cb",
            measurementId: "G-D6KMVM4LJ8"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
    </script> --}}
</head>
