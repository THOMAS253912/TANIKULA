<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">Tanikula</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('home') }}">TK</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="nav-item dropdown {{ Request::is('petani') ? 'active' : '' }}">
            <a href="#" onclick="petani_dashboard('{{ url('petani') }}')" class="nav-link">
                <i class="fas fa-thin fa-gauge"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="menu-header">Manajamen</li>
        <li class="nav-item dropdown {{ Request::is('edukasi*') ? 'active' : '' }}">
            <a href="#" onclick="petani_edukasi('{{ url('edukasi') }}')" class="nav-link">
                <i class="fas fa-solid fa-clapperboard"></i>
                <span>Edukasi</span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('petani/kegiatan*') ? 'active' : '' }}">
            <a href="#" onclick="petani_kegiatan('{{ url('petani/kegiatan') }}')" class="nav-link ">
                <i class="fas fa-solid fa-clipboard"></i>
                <span>Kegiatan</span>
            </a>
        </li>
        <li class="menu-header">Melaporkan</li>
        <li class="nav-item dropdown {{ Request::is('petani/tandur*') ? 'active' : '' }}">
            <a href="#" onclick="petani_tandur('{{ url('petani/tandur') }}')" class="nav-link">
                <i class="fas fa-solid fa-calendar-days"></i>
                <span>Tandur</span>
            </a>
        </li>
        <li class="nav-item dropdown {{ Request::is('petani/panen*') ? 'active' : '' }}">
            <a href="#" onclick="petani_panen('{{ url('petani/panen') }}')" class="nav-link">
                <i class="fas fa-solid fa-calendar-check"></i>
                <span>Panen</span>
            </a>
        </li>
        {{-- <li class="nav-item dropdown {{ Request::is('petani/riwayat-penanam*') ? 'active' : '' }}">
            <a href="#" onclick="petani_riwayat_penanam('{{ url('petani/riwayat-penanam') }}')" class="nav-link">
                <i class="fas fa-solid fa-clock"></i>
                <span>Riwayat Penanam</span>
            </a>
        </li> --}}
        <li class="menu-header">Profile Saya</li>
        <li class="nav-item dropdown {{ Request::is('petani/pengaturan*') ? 'active' : '' }}">
            <a href="#" onclick="petani_pengaturan('{{ url('petani/pengaturan') }}')" class="nav-link">
                <i class="fas fa-solid fa-gear"></i>
                <span>Pengaturan</span>
            </a>
        </li>

    </ul>
</aside>
