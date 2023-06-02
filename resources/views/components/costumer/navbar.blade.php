<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Dasbor</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">@yield('title')</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">@yield('title')</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group input-group-outline">
                    <label class="form-label">Type here...</label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    @php
                    $notificationsSum = App\Models\PushNotification::where('user_id',Auth::id())->sum('is_read', 0);
                    $notifications = App\Models\PushNotification::where('user_id', Auth::id())->latest()->get();
                    @endphp
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
                    <style>
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
                    </style>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton" id="style-1" style="overflow-y: scroll;
                        max-height: 230px;">
                        @if ($notifications->count())
                        @foreach ($notifications as $notif)
                        <li class="mb-2 rounded" style="overflow: hidden; {{ $notif->is_read == 0 ? 'background: antiquewhite' : '' }}"">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('img/'.$notif->img) }}"
                                            class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-0">
                                            {{ $notif->title }}
                                        </h6>
                                        <p class="text-xs text-secondary mb-1">{{ $notif->body }}</p>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            {{$notif->created_at->diffForHumans()}}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                        @else
                        <div id="app">
                            <div class="container">
                                <div class="page-error-notification">
                                    <div class="page-inner-notification">
                                        <img src="{{ asset('img/undraw_empty_re_opql.svg') }}" alt="">
                                        <div class="page-description-notification">
                                            Tidak ada pemberitahuan!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </ul>
                </li>
                <li class="nav-item ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body font-weight-bold px-0" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt me-sm-1"></i>
                        <span class="d-sm-inline d-none">Keluar</span>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
