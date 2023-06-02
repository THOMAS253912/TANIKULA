<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            @php
                $admin = App\Models\Admin::where('user_id', auth()->user()->id)->first();
            @endphp
            @if ($admin->image)
                <img src="../storage/profile/{{ $admin->image }}" class="border rounded-circle border-white shadow-sm mr-1" style="width: 43px; height: 43px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="User Image">
            @else
                <img src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="img-circle elevation-2" alt="User Image">
            @endif
        </div>
        <div class="info">
            <a href="#" onclick="admin_dashboard('{{ url('admin') }}')" class="d-block">{{ auth()->user()->name }}</a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="#" onclick="admin_dashboard('{{ url('admin') }}')" class="nav-link {{ Request::is('admin') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-thin fa-gauge"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" onclick="admin_hero('{{ url('admin/hero') }}')" class="nav-link {{ Request::is('admin/hero*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-panorama"></i>
                    <p>
                        Hero
                    </p>
                </a>
            </li>
            <li class="nav-header">PESANAN MASUK</li>
            <li class="nav-item">
                <a href="#" onclick="admin_reply_ulasan('{{ url('admin/reply-ulasan') }}')" class="nav-link {{ Request::is('admin/reply-ulasan*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-star"></i>
                    <p>
                        Reply Ulasan <span class="badge badge-warning float-right review-count">0</span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" onclick="admin_pesanan('{{ url('admin/pesanan') }}')" class="nav-link {{ Request::is('admin/pesanan*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-shop"></i>
                    <p>
                        Pesanan <span class="badge badge-warning float-right order-count">0</span>
                    </p>
                </a>
            </li>
            <li class="nav-header">MANAJEMEN</li>
            <li class="nav-item">
                <a href="#" class="nav-link {{ Request::is('admin/kategori*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-bookmark"></i>
                    <p>
                        Kategori
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" onclick="admin_kategori_produk('{{ url('admin/kategori-produk') }}')" class="nav-link {{ Request::is('admin/kategori-produk*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Produk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" onclick="admin_kategori_edukasi('{{ url('admin/kategori-edukasi') }}')" class="nav-link {{ Request::is('admin/kategori-edukasi*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Edukasi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" onclick="admin_kategori_kegiatan('{{ url('admin/kategori-kegiatan') }}')" class="nav-link {{ Request::is('admin/kategori-kegiatan*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kegiatan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" onclick="admin_kategori_lahan('{{ url('admin/kategori-lahan') }}')" class="nav-link {{ Request::is('admin/kategori-lahan*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Lahan</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" onclick="admin_produk('{{ url('admin/produk') }}')" class="nav-link {{ Request::is('admin/produk*') ? 'active' : '' }}">
                    <i class="nav-icon mdi mdi-shopping"></i>
                    <p>
                        Produk
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" onclick="admin_edukasi('{{ url('admin/edukasi') }}')" class="nav-link {{ Request::is('admin/edukasi*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-clapperboard"></i>
                    <p>
                        Edukasi
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" onclick="admin_kegiatan('{{ url('admin/kegiatan') }}')" class="nav-link {{ Request::is('admin/kegiatan*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-clipboard"></i>
                    <p>
                        Kegiatan
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" onclick="admin_lahan('{{ url('admin/lahan') }}')" class="nav-link {{ Request::is('admin/lahan*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-water"></i>
                    <p>
                        Lahan
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link {{ Request::is('admin/daftar*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-user"></i>
                    <p>
                        Akun
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" onclick="admin_daftar_gapoktan('{{ url('admin/daftar-gapoktan') }}')" class="nav-link {{ Request::is('admin/daftar-gapoktan*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Gapoktan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" onclick="admin_daftar_poktan('{{ url('admin/daftar-poktan') }}')" class="nav-link {{ Request::is('admin/daftar-poktan*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Poktan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" onclick="admin_daftar_petani('{{ url('admin/daftar-petani') }}')" class="nav-link {{ Request::is('admin/daftar-petani*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Petani</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-header">Laporan</li>
            <li class="nav-item">
                <a href="#" onclick="admin_tandur('{{ url('admin/tandur') }}')" class="nav-link {{ Request::is('admin/tandur*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-calendar-days"></i>
                    <p>
                        Tandur
                        {{-- <span class="badge badge-info right">2</span> --}}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" onclick="admin_panen('{{ url('admin/panen') }}')" class="nav-link {{ Request::is('admin/panen*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-calendar-check"></i>
                    <p>
                        Panen
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" onclick="admin_riwayat_penanam('{{ url('admin/riwayat-penanam') }}')" class="nav-link {{ Request::is('admin/riwayat-penanam*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-clock"></i>
                    <p>
                        Riwayat Penanam
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" onclick="admin_rekap_penjualan('{{ url('admin/rekap-penjualan') }}')" class="nav-link {{ Request::is('admin/rekap-penjualan*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-chart-line"></i>
                    <p>
                        Rekap Penjualan
                    </p>
                </a>
            </li>
            <li class="nav-header">Profile Saya</li>
            <li class="nav-item">
                <a href="#" onclick="admin_pengaturan('{{ url('admin/pengaturan') }}')" class="nav-link {{ Request::is('admin/pengaturan*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-gear"></i>
                    <p>Pengaturan</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
