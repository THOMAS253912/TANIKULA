<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            @php
                $support = App\Models\Support::where('user_id', auth()->user()->id)->first();
            @endphp
            @if ($support->image)
                <img src="{{ asset('../storage/profile/'. $support->image) }}" class="border rounded-circle border-white shadow-sm mr-1" style="width: 43px; height: 43px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;" alt="User Image">
            @else
                <img src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="img-circle elevation-2" alt="User Image">
            @endif
        </div>
        <div class="info">
            <a href="#" onclick="support_dashboard('{{ url('support') }}')" class="d-block">{{ auth()->user()->name }}</a>
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
                <a href="#" onclick="support_dashboard('{{ url('support') }}')" class="nav-link {{ Request::is('support') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-thin fa-gauge"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-header">Mengelola</li>
            <li class="nav-item">
                <a href="#" onclick="support_verifikasi_gapoktan('{{ url('support/verifikasi-gapoktan') }}')" class="nav-link {{ Request::is('support/verifikasi-gapoktan*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-user"></i>
                    <p>
                        Verifikasi Gapoktan
                        {{-- <span class="badge badge-info right">2</span> --}}
                    </p>
                </a>
            </li>
            <li class="nav-header">Profile Saya</li>
            <li class="nav-item">
                <a href="#" onclick="support_pengaturan('{{ url('support/pengaturan') }}')" class="nav-link {{ Request::is('support/pengaturan*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-gear"></i>
                    <p>Pengaturan</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
