<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">Tanikula</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('home') }}">TK</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="nav-item dropdown {{ Request::is('poktan') ? 'active' : '' }}">
            <a href="#" onclick="poktan_dashboard('{{ url('poktan') }}')" class="nav-link">
                <i class="fas fa-thin fa-gauge"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="menu-header">Manajemen</li>
        <li class="nav-item dropdown {{ Request::is('poktan/edukasi*') ? 'active' : '' }}">
            <a href="#" onclick="poktan_edukasi('{{ url('poktan/edukasi') }}')" class="nav-link ">
                <i class="fas fa-solid fa-clapperboard"></i>
                <span>Edukasi</span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('poktan/kegiatan*') ? 'active' : '' }}">
            <a href="#" onclick="poktan_kegiatan('{{ url('poktan/kegiatan') }}')" class="nav-link ">
                <i class="fas fa-solid fa-clipboard"></i>
                <span>Kegiatan</span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('poktan/daftar-petani*') ? 'active' : '' }}">
            <a href="#" onclick="poktan_daftar_petani('{{ url('poktan/daftar-petani') }}')" class="nav-link ">
                <i class="fas fa-solid fa-user"></i>
                <span>Akun Petani</span>
            </a>
        </li>
        <li class="menu-header">Laporan</li>
        <li class="nav-item dropdown {{ Request::is('poktan/tandur*') ? 'active' : '' }}">
            <a href="#" onclick="poktan_tandur('{{ url('poktan/tandur') }}')" class="nav-link">
                <i class="fas fa-solid fa-calendar-days"></i>
                <span>Tandur</span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('poktan/panen*') ? 'active' : '' }}">
            <a href="#" onclick="poktan_panen('{{ url('poktan/panen') }}')" class="nav-link">
                <i class="fas fa-solid fa-calendar-check"></i>
                <span>Panen</span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('poktan/riwayat-penanam*') ? 'active' : '' }}">
            <a href="#" onclick="poktan_riwayat_penanam('{{ url('poktan/riwayat-penanam') }}')" class="nav-link">
                <i class="fas fa-solid fa-clock"></i>
                <span>Riwayat Penanam</span>
            </a>
        </li>
        <li class="menu-header">Profile Saya</li>
        <li class="nav-item dropdown {{ Request::is('poktan/pengaturan*') ? 'active' : '' }}">
            <a href="#" onclick="poktan_pengaturan('{{ url('poktan/pengaturan') }}')" class="nav-link">
                <i class="fas fa-solid fa-gear"></i>
                <span>Pengaturan</span>
            </a>
        </li>

    </ul>

    {{-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
            <i class="fas fa-rocket"></i> Documentation
        </a>
    </div> --}}
</aside>
