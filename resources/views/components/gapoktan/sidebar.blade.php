<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">Tanikula</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('home') }}">TK</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="nav-item dropdown {{ Request::is('gapoktan') ? 'active' : '' }}">
            <a href="#" onclick="gapoktan_dashboard('{{ url('gapoktan') }}')" class="nav-link">
                <i class="fas fa-thin fa-gauge"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="menu-header">Pesanan Masuk</li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/reply-ulasan*') ? 'active' : '' }}">
            <a href="#" onclick="gapoktan_reply_ulasan('{{ url('gapoktan/reply-ulasan') }}')" class="nav-link">
                <i class="fas fa-solid fa-star"></i>
                <span>Reply Ulasan <p class="badge badge-warning m-1 review-count">0</p></span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/pesanan*') ? 'active' : '' }}">
            <a href="#" onclick="gapoktan_pesanan('{{ url('gapoktan/pesanan') }}')" class="nav-link">
                <i class="fas fa-solid fa-shop"></i>
                <span>Pesanan <p class="badge badge-warning m-1 order-count">0</p></span>
            </a>
        </li>
        <li class="menu-header">Kotak Masuk</li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/chat*') ? 'active' : '' }}">
            <a href="#" onclick="gapoktan_chat('{{ url('gapoktan/chat') }}')" class="nav-link">
                <i class="fas fa-solid fa-comment-dots"></i>
                <span>Chat</span>
            </a>
        </li>
        <li class="menu-header">Manajemen</li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/kategori*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown bg-white" data-toggle="dropdown">
                <i class="fas fa-solid fa-bookmark"></i>
                <span>Kategori</span>
            </a>
            <ul class="dropdown-menu">
                <li class="{{ Request::is('gapoktan/kategori-produk*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('gapoktan/kategori-produk*') ? '' : 'bg-white' }}" href="#" onclick="gapoktan_kategori_produk('{{ url('gapoktan/kategori-produk') }}')">
                        Kategori Produk
                    </a>
                </li>
                <li class="{{ Request::is('gapoktan/kategori-edukasi*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('gapoktan/kategori-edukasi*') ? '' : 'bg-white' }}" href="#" onclick="gapoktan_kategori_edukasi('{{ url('gapoktan/kategori-edukasi') }}')">
                        Kategori Edukasi
                    </a>
                </li>
                <li class="{{ Request::is('gapoktan/kategori-kegiatan*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('gapoktan/kategori-kegiatan*') ? '' : 'bg-white' }}" href="#" onclick="gapoktan_kategori_kegiatan('{{ url('gapoktan/kategori-kegiatan') }}')">
                        Kategori Kegiatan
                    </a>
                </li>
                <li class="{{ Request::is('gapoktan/kategori-lahan*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('gapoktan/kategori-lahan*') ? '' : 'bg-white' }}" href="#" onclick="gapoktan_kategori_lahan('{{ url('gapoktan/kategori-lahan') }}')">
                        Kategori Lahan
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/produk*') ? 'active' : '' }}">
            <a href="#" onclick="gapoktan_produk('{{ url('gapoktan/produk') }}')" class="nav-link ">
                <i class="fas fa-solid fa-cart-plus"></i>
                <span>Produk</span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/edukasi*') ? 'active' : '' }}">
            <a href="#" onclick="gapoktan_edukasi('{{ url('gapoktan/edukasi') }}')" class="nav-link ">
                <i class="fas fa-solid fa-clapperboard"></i>
                <span>Edukasi</span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/kegiatan*') ? 'active' : '' }}">
            <a href="#" onclick="gapoktan_kegiatan('{{ url('gapoktan/kegiatan') }}')" class="nav-link ">
                <i class="fas fa-solid fa-clipboard"></i>
                <span>Kegiatan</span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/lahan*') ? 'active' : '' }}">
            <a href="#" onclick="gapoktan_lahan('{{ url('gapoktan/lahan') }}')" class="nav-link">
                <i class="fas fa-solid fa-water"></i>
                <span>Lahan</span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/daftar*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown bg-white" data-toggle="dropdown">
                <i class="fas fa-solid fa-user"></i>
                <span>Akun</span>
            </a>
            <ul class="dropdown-menu">
                <li class="{{ Request::is('gapoktan/daftar-poktan*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('gapoktan/daftar-poktan*') ? '' : 'bg-white' }}" href="#" onclick="gapoktan_daftar_poktan('{{ url('gapoktan/daftar-poktan') }}')">
                        Daftar Poktan
                    </a>
                </li>
                <li class="{{ Request::is('gapoktan/daftar-petani*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('gapoktan/daftar-petani*') ? '' : 'bg-white' }}" href="#" onclick="gapoktan_daftar_petani('{{ url('gapoktan/daftar-petani') }}')">
                        Daftar Petani
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-header">Laporan</li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/tandur*') ? 'active' : '' }}">
            <a href="#" onclick="gapoktan_tandur('{{ url('gapoktan/tandur') }}')" class="nav-link">
                <i class="fas fa-solid fa-calendar-days"></i>
                <span>Tandur</span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/panen*') ? 'active' : '' }}">
            <a href="#" onclick="gapoktan_panen('{{ url('gapoktan/panen') }}')" class="nav-link">
                <i class="fas fa-solid fa-calendar-check"></i>
                <span>Panen</span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/riwayat-penanam*') ? 'active' : '' }}">
            <a href="#" onclick="gapoktan_riwayat_penanam('{{ url('gapoktan/riwayat-penanam') }}')" class="nav-link">
                <i class="fas fa-solid fa-clock"></i>
                <span>Riwayat Penanam</span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/rekap-penjualan*') ? 'active' : '' }}">
            <a href="#" onclick="gapoktan_rekap_penjualan('{{ url('gapoktan/rekap-penjualan') }}')" class="nav-link">
                <i class="fas fa-solid fa-chart-line"></i>
                <span>Rekap Penjualan</span>
            </a>
        </li>
        <li class="menu-header">Profile Saya</li>
        <li class="nav-item dropdown {{ Request::is('gapoktan/pengaturan*') ? 'active' : '' }}">
            <a href="#" onclick="gapoktan_pengaturan('{{ url('gapoktan/pengaturan') }}')" class="nav-link">
                <i class="fas fa-solid fa-gear"></i>
                <span>Pengaturan</span>
            </a>
        </li>
    </ul>
</aside>
