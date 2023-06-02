<!DOCTYPE html>
<html class="no-js" lang="zxx" lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free" xmlns="http://www.w3.org/1999/xhtml">

<head runat="server">
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>TaniKula | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/Logo TaniKula.svg') }}" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
        integrity="sha256-pODNVtK3uOhL8FUNWWvFQK0QoQoV3YA9wGGng6mbZ0E=" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/LineIcons.3.0.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
    <link rel="stylesheet" href="{{ asset('css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />

    @yield('style')

    <style>
        /* 4.3 Page */
        .page-error-notification {
            height: 100%;
            width: 100%;
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

        /* ======================== */
                /* Pencarian */
                /* =========================== */
        .header .main-menu-search-mobile .navbar-search-mobile {
            position: relative;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .header .main-menu-search-mobile .search-input-mobile {
            width: 100%;
        }

        .header .main-menu-search-mobile .search-input-mobile input {
            width: 100%;
            height: 45px;
            border: 1px solid #e2e2e2;
            background-color: #fff;
            color: #000;
            border-radius: 0;
            padding: 0 15px;
            -webkit-transition: all 0.3s linear;
            transition: all 0.3s linear;
            font-size: 14px;
        }

        .header .main-menu-search-mobile .search-btn-mobile button {
            background-color: #16A085;
            color: #fff;
            width: 45px;
            height: 45px;
            padding: 0;
            font-size: 20px;
            border: 0;
            border-radius: 0 4px 4px 0;
            margin-left: -2px;
            -webkit-transition: all 0.4s ease;
            transition: all 0.4s ease;
            font-size: 18px;
        }

        .header .main-menu-search-mobile .search-btn-mobile button:hover {
            color: #fff;
            background-color: #081828;
        }

        /* ======================== */
                /* Error */
                /* =========================== */

        .page-error-notification .page-description-notification {
            padding-top: 30px;
            font-size: 18px;
            font-weight: 400;
            color: color: var(--primary);;
        }

        /* ======================== */
                /* Notifikasi Pemberitahuan */
                /* =========================== */

        #style-1::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px #16A085;
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        #style-1::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }

        #style-1::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px #16A085;
            background-color: #16A085;
        }

        .header .navbar-cart .notification-items {
            margin-right: 12px;
            position: relative;
        }

        .header .navbar-cart .notification-items:hover .main-btn {
            color: #fff;
            background-color: #16A085;
            border-color: transparent;
        }

        .header .navbar-cart .notification-items .main-btn {
            height: 40px;
            width: 40px;
            line-height: 40px;
            display: inline-block;
            border-radius: 50%;
            border: 1px solid #eee;
            color: #555;
            font-size: 18px;
            text-align: center;
            position: relative;
        }

        .header .navbar-cart .notification-items .main-btn .total-items {
            position: absolute;
            right: -6px;
            top: -5px;
            height: 19px;
            width: 19px;
            line-height: 19px;
            background-color: #081828;
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            border-radius: 50%;
        }

        .header .navbar-cart .notification-items:hover .shopping-item {
            opacity: 1;
            visibility: visible;
        }

        .header .navbar-cart .notification-items .shopping-item {
            position: absolute;
            top: 72px;
            right: 0;
            width: 300px;
            background: #fff;
            padding: 20px 25px;
            -webkit-transition: all 0.3s ease 0s;
            transition: all 0.3s ease 0s;
            z-index: 99;
            border-radius: 4px;
            -webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.137);
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.137);
            opacity: 0;
            visibility: hidden;
        }

        @media (max-width: 767px) {
            .header .navbar-cart .notification-items .shopping-item {
                width: 285px;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .header .navbar-cart .notification-items .shopping-item {
                top: 68px;
            }
        }

        @media (max-width: 767px) {
            .header .navbar-cart .notification-items .shopping-item {
                top: 66px;
            }
        }

        .header .navbar-cart .notification-items .shopping-item .dropdown-cart-header {
            padding-bottom: 10px;
            margin-bottom: 15px;
            border-bottom: 1px solid #e6e6e6;
        }

        .header .navbar-cart .notification-items .shopping-item .dropdown-cart-header span {
            text-transform: capitalize;
            color: #222;
            font-size: 14px;
            font-weight: 600;
        }

        .header .navbar-cart .notification-items .shopping-item .dropdown-cart-header a {
            float: right;
            text-transform: capitalize;
            color: #222;
            font-size: 14px;
            font-weight: 600;
        }

        .header .navbar-cart .notification-items .shopping-item .dropdown-cart-header a:hover {
            color: #16A085;
        }

        .header .navbar-cart .notification-items .shopping-item .shopping-list {
            overflow-y: auto;
            max-height: 230px;
        }

        .header .navbar-cart .notification-items .shopping-item .shopping-list li {
            overflow: hidden;
            margin-bottom: 15px;
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .header .navbar-cart .notification-items .shopping-item .shopping-list li .remove {
            position: absolute;
            right: 0;
            top: 0;
            height: 18px;
            width: 18px;
            line-height: 16px;
            text-align: center;
            background: #fff;
            color: #222;
            border-radius: 50%;
            font-size: 8px;
            border: 1px solid #ededed;
            padding-left: 1px;
        }

        .header .navbar-cart .notification-items .shopping-item .shopping-list li .remove:hover {
            border-color: transparent;
            color: #fff;
            background-color: #16A085;
        }

        .header .navbar-cart .notification-items .shopping-item .shopping-list li .cart-img-head {
            width: 40%;
        }

        @media (max-width: 767px) {
            .header .navbar-cart .notification-items .shopping-item .shopping-list li .cart-img-head {
                width: 30%;
                margin-right: 12px;
            }
        }

        .header .navbar-cart .notification-items .shopping-item .shopping-list li .cart-img {
            border: 1px solid #ededed;
            overflow: hidden;
            height: 80px;
            width: 80px;
            border-radius: 4px;
            float: left;
            margin-right: 20px;
        }

        @media (max-width: 767px) {
            .header .navbar-cart .notification-items .shopping-item .shopping-list li .cart-img {
                height: 60px;
                width: 60px;
                margin-right: 10px;
            }
        }

        .header .navbar-cart .notification-items .shopping-item .shopping-list li .content {
            padding-right: 25px;
            width: 60%;
        }

        @media (max-width: 767px) {
            .header .navbar-cart .notification-items .shopping-item .shopping-list li .content {
                width: 70%;
            }
        }

        .header .navbar-cart .notification-items .shopping-item .shopping-list li .content h4 {
            margin-bottom: 5px;
        }

        .header .navbar-cart .notification-items .shopping-item .shopping-list li .content h4 a {
            font-size: 13px;
            font-weight: 600;
            color: #081828;
        }

        @media (max-width: 767px) {
            .header .navbar-cart .notification-items .shopping-item .shopping-list li .content h4 a {
                font-size: 13px;
            }
        }

        .header .navbar-cart .notification-items .shopping-item .shopping-list li .content h4 a:hover {
            color: #16A085;
        }

        .header .navbar-cart .notification-items .shopping-item .shopping-list li .content .quantity {
            line-height: 22px;
            font-size: 14px;
        }

        .header .navbar-cart .notification-items .shopping-item .bottom {
            text-align: center;
        }

        .header .navbar-cart .notification-items .shopping-item .bottom .total {
            overflow: hidden;
            display: block;
            padding-bottom: 10px;
        }

        .header .navbar-cart .notification-items .shopping-item .bottom .total span {
            text-transform: capitalize;
            color: #222;
            font-size: 14px;
            font-weight: 600;
            float: left;
        }

        .header .navbar-cart .notification-items .shopping-item .bottom .total .total-amount {
            float: right;
            font-size: 14px;
        }

        .header .navbar-cart .notification-items .shopping-item .bottom .button {
            margin-top: 10px;
            width: 100%;
        }

        .header .navbar-cart .notification-items .shopping-item .bottom .button .btn {
            width: 100%;
        }
    </style>

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
    @if (Request::is('cart/shipment*'))
        <script language='javascript' type='text/javascript'>
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function () {
                window.location = '{{ route('home') }}';
            };
            // function DisableBackButton() {
            //     window.history.forward()
            // }
            // DisableBackButton();
            // window.onload = DisableBackButton;
            // window.onpageshow = function(evt) { if (evt.persisted) DisableBackButton() }
            // window.onunload = function() { void (0) }
        </script>
    @elseif (Request::is('buy-now'))
        <script language='javascript' type='text/javascript'>
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function () {
                window.location = '{{ route('home') }}';
            };
        </script>
    @endif
</head>
