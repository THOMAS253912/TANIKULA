<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a>
            </li>
        </ul>
        <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            {{-- <div class="search-result">
                <div class="search-header">
                    Histories
                </div>
                <div class="search-item">
                    <a href="#">How to hack NASA using CSS</a>
                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                </div>
                <div class="search-item">
                    <a href="#">Kodinger.com</a>
                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                </div>
                <div class="search-item">
                    <a href="#">#Stisla</a>
                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                </div>
                <div class="search-header">
                    Result
                </div>
                <div class="search-item">
                    <a href="#">
                        <img class="mr-3 rounded" width="30" src="{{ asset('assets/img/products/product-3-50.png') }}"
                            alt="product">
                        oPhone S9 Limited Edition
                    </a>
                </div>
                <div class="search-item">
                    <a href="#">
                        <img class="mr-3 rounded" width="30" src="{{ asset('assets/img/products/product-2-50.png') }}"
                            alt="product">
                        Drone X2 New Gen-7
                    </a>
                </div>
                <div class="search-item">
                    <a href="#">
                        <img class="mr-3 rounded" width="30" src="{{ asset('assets/img/products/product-1-50.png') }}"
                            alt="product">
                        Headphone Blitz
                    </a>
                </div>
                <div class="search-header">
                    Projects
                </div>
                <div class="search-item">
                    <a href="#">
                        <div class="search-icon bg-danger text-white mr-3">
                            <i class="fas fa-code"></i>
                        </div>
                        Stisla Admin Template
                    </a>
                </div>
                <div class="search-item">
                    <a href="#">
                        <div class="search-icon bg-primary text-white mr-3">
                            <i class="fas fa-laptop"></i>
                        </div>
                        Create a new Homepage Design
                    </a>
                </div>
            </div> --}}
        </div>
    </form>
    <ul class="navbar-nav navbar-right">
        {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Messages
                    <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-message">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                                class="rounded-circle') }}">
                            <div class="is-online"></div>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Kusnaedi</b>
                            <p>Hello, Bro!</p>
                            <div class="time">10 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="{{ asset('assets/img/avatar/avatar-2.png') }}"
                                class="rounded-circle') }}">
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Dedik Sugiharto</b>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                            <div class="time">12 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="{{ asset('assets/img/avatar/avatar-3.png') }}"
                                class="rounded-circle') }}">
                            <div class="is-online"></div>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Agung Ardiansyah</b>
                            <p>Sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            <div class="time">12 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="{{ asset('assets/img/avatar/avatar-4.png') }}"
                                class="rounded-circle') }}">
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Ardian Rahardiansyah</b>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                            <div class="time">16 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="{{ asset('assets/img/avatar/avatar-5.png') }}"
                                class="rounded-circle') }}">
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Alfa Zulkarnain</b>
                            <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                            <div class="time">Yesterday</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li> --}}
        @php
            $poktan = App\Models\Poktan::join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                ->join('users', 'poktans.user_id', '=', 'users.id')
                ->select('poktans.*', 'users.name as name')
                ->where('gapoktans.user_id', auth()->user()->id)
                ->orderBy('poktans.updated_at', 'desc')
                ->get();
            foreach($poktan as $poktan){
                $userIdPoktan = $poktan['user_id'];
                $checkPosted[] = $userIdPoktan;
            }
            $checkPosted[] = auth()->user()->id;
            // dd($checkPosted);
            $authorizedRoles = ['Kegiatan Terbaru', 'Edukasi Terbaru'];
            $countNotificationActivity = App\Models\PushNotification::where(static function ($query) use ($checkPosted) {
                return $query->whereIn('user_id', $checkPosted);
            })->where(static function ($query) use ($authorizedRoles) {
                return $query->whereIn('title', $authorizedRoles);
            })->count();
        @endphp
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg {{ $countNotificationActivity == null ? '' : 'beep' }}"><i class="far fa-bell"></i><span class="position-absolute">{{ $countNotificationActivity }}</span></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifikasi
                    {{-- <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div> --}}
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @php
                        $poktan = App\Models\Poktan::join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                            ->join('users', 'poktans.user_id', '=', 'users.id')
                            ->select('poktans.*', 'users.name as name')
                            ->where('gapoktans.user_id', auth()->user()->id)
                            ->orderBy('poktans.updated_at', 'desc')
                            ->get();
                        foreach($poktan as $poktan){
                            $userIdPoktan = $poktan['user_id'];
                            $checkPosted[] = $userIdPoktan;
                        }
                        $checkPosted[] = auth()->user()->id;
                        $authorizedRoles = ['Kegiatan Terbaru', 'Edukasi Terbaru'];
                        $notificationActivity = App\Models\PushNotification::where(static function ($query) use ($checkPosted) {
                            return $query->whereIn('user_id', $checkPosted);
                        })->where(static function ($query) use ($authorizedRoles) {
                            return $query->whereIn('title', $authorizedRoles);
                        })->latest()->get();
                    @endphp

                    @if ($notificationActivity->count() > 0)

                    @foreach ($notificationActivity as $item)
                        <div class="dropdown-item {{ $item->read_at == null ? 'dropdown-item-unread' : '' }}">
                            <div class="dropdown-item-icon bg-info text-white">
                                <i class="{{ $item->img }}"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                <b>{{ $item->title }}</b> {{ $item->body }}.
                                <div class="time">{{$item->created_at->diffForHumans()}}</div>
                                {{-- <a href="#" id="{{ $item->id }}" class="notifActivity float-right mx-1">Lihat</a> --}}
                            </div>
                        </div>
                    @endforeach

                    @else
                        <div id="app">
                            <section class="section">
                                <div class="container">
                                    <div class="page-error-notification">
                                        <div class="page-inner-notification">
                                            <img src="{{ asset('img/undraw_empty_re_opql.svg') }}" alt="">
                                            <div class="page-description-notification pb-5">
                                                Tidak ada notifikasi!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    @endif
                </div>
                {{-- <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div> --}}
            </div>
        </li>
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                @php
                    $gapoktan = App\Models\Gapoktan::where('user_id', auth()->user()->id)->first();
                @endphp
                @if ($gapoktan->image)
                    <img alt="image" src="../storage/profile/{{ $gapoktan->image }}"
                        class="border rounded-circle border-white shadow-sm mr-1" style="width: 43px; height: 43px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                @else
                    <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                        class="rounded-circle mr-1">
                @endif
                <div class="d-sm-none d-lg-inline-block">{{ strtok(Auth::user()->name, ' ') }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                {{-- <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="features-profile.html" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="features-activities.html" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Activities
                </a> --}}
                <a href="{{ url('gapoktan/pengaturan') }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout-gapoktan') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Keluar

                    <form id="logout-form" action="{{ route('logout-gapoktan') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </a>
            </div>
        </li>
    </ul>
</nav>
