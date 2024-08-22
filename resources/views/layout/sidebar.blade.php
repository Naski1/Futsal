<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Futsal <sup>App</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    @auth
        {{-- @if (Auth::user()->role == 'costumer') --}}
        <!-- Heading -->
        <div class="sidebar-heading">
            Data Pemesanan
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ request()->is('pemesanan*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages1"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Data Pemesanan</span>
            </a>
            <div id="collapsePages1" class="collapse {{ request()->is('pemesanan*') ? 'show' : '' }}"
                aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pemesanan:</h6>
                    <a class="collapse-item {{ Route::currentRouteName() == 'pemesanan.index' ? 'active' : '' }}"
                        href="{{ route('pemesanan.index') }}">Data Pemesanan</a>
                    <a class="collapse-item {{ Route::currentRouteName() == 'pemesanan.create' || Route::currentRouteName() == 'pemesanan.search' ? 'active' : '' }}"
                        href="{{ route('pemesanan.search') }}">Tambah Pemesanan</a>
                    @if (Auth::user()->role == 'admin')
                        <a class="collapse-item {{ Route::currentRouteName() == 'pemesanan.harian' || Route::currentRouteName() == 'pemesanan.harian' ? 'active' : '' }}"
                            href="{{ route('pemesanan.harian') }}">Pemesanan Hari Ini</a>
                    @endif
                    <div class="collapse-divider"></div>
                    {{-- @if (Auth::user()->role == 'admin')
                        <h6 class="collapse-header">Laporan:</h6>
                        <a class="collapse-item" href="login.html">Data Pemesanan</a>
                    @endif --}}
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
        {{-- @endif --}}


        @if (Auth::user()->role == 'admin')
            <!-- Heading -->
            <div class="sidebar-heading">
                Data Master
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li
                class="nav-item {{ request()->is('user*') || request()->is('lapangan*') || request()->is('jam*') || request()->is('jadwal*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Data Master</span>
                </a>
                <div id="collapsePages"
                    class="collapse {{ request()->is('user*') || request()->is('lapangan*') || request()->is('jam*') || request()->is('jadwal*') ? 'show' : '' }}"
                    aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Costumer:</h6>
                        <a class="collapse-item {{ Route::currentRouteName() == 'user.index' ? 'active' : '' }}"
                            href="{{ route('user.index') }}">Data Costumer</a>
                        <a class="collapse-item {{ Route::currentRouteName() == 'user.create' ? 'active' : '' }}"
                            href="{{ route('user.create') }}">Tambah Costumer</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Lapangan:</h6>
                        <a class="collapse-item {{ Route::currentRouteName() == 'lapangan.index' ? 'active' : '' }}"
                            href="{{ route('lapangan.index') }}">Data Lapangan</a>
                        <a class="collapse-item {{ Route::currentRouteName() == 'lapangan.create' ? 'active' : '' }}"
                            href="{{ route('lapangan.create') }}">Tambah Lapangan</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Jam:</h6>
                        <a class="collapse-item {{ Route::currentRouteName() == 'jam.index' ? 'active' : '' }}"
                            href="{{ route('jam.index') }}">Data Jam</a>
                        <a class="collapse-item {{ Route::currentRouteName() == 'jam.create' ? 'active' : '' }}"
                            href="{{ route('jam.create') }}">Tambah Jam</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Jadwal:</h6>
                        <a class="collapse-item {{ Route::currentRouteName() == 'jadwal.index' ? 'active' : '' }}"
                            href="{{ route('jadwal.index') }}">Data Jadwal</a>
                        <a class="collapse-item {{ Route::currentRouteName() == 'jadwal.create' ? 'active' : '' }}"
                            href="{{ route('jadwal.create') }}">Tambah Jadwal</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
        @endif
    @endauth
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
