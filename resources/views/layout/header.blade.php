 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
     <!-- Sidebar Toggle (Topbar) -->
     <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
         <i class="fa fa-bars"></i>
     </button>

     <!-- Topbar Search -->
     {{-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
         <div class="input-group">
             <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                 aria-label="Search" aria-describedby="basic-addon2">
             <div class="input-group-append">
                 <button class="btn btn-primary" type="button">
                     <i class="fas fa-search fa-sm"></i>
                 </button>
             </div>
         </div>
     </form> --}}

     <!-- Topbar Navbar -->
     <ul class="navbar-nav ml-auto">
         @auth
             @if (Auth::user()->role == 'admin')
                 <!-- Nav Item - Alerts -->
                 <li class="nav-item dropdown no-arrow mx-1">
                     <a class="nav-link dropdown-toggle nav-fixed" href="#" id="alertsDropdown" role="button"
                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fas fa-bell fa-fw"></i>
                         <!-- Counter - Alerts -->
                         <span
                             class="badge badge-danger badge-counter">{{ Auth::user()->unreadNotifications->count() }}</span>
                     </a>
                     <!-- Dropdown - Alerts -->
                     <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in overflow-auto"
                         style="height: 180px" aria-labelledby="alertsDropdown">
                         <h6 class="dropdown-header">Ada {{ Auth::user()->unreadNotifications->count() }} Notifikasi</h6>
                         @foreach (Auth::user()->unreadNotifications as $item)
                             <a class="dropdown-item d-flex align-items-center"
                                 href="{{ route('pemesanan.detail', $item->data['id']) }}">
                                 <div class="mr-3">
                                     @if ($item->data['status'] == 'selesai')
                                         <div class="icon-circle bg-danger">
                                             <i class="fas fa-check-circle text-white"></i>
                                         </div>
                                     @else
                                         <div class="icon-circle bg-primary">
                                             <i class="fas fa-plus-circle text-white"></i>
                                         </div>
                                     @endif
                                 </div>
                                 <div>
                                     <div class="small text-gray-500">
                                         {{ \Carbon\Carbon::parse($item->created_at)->format('j F, Y H:i:s') }}</div>
                                     <span class="font-weight-bold">{{ $item->data['data'] }}</span>
                                 </div>
                             </a>
                         @endforeach
                         <a class="dropdown-item text-center small text-gray-500"
                             href="{{ route('pemesanan.index') }}">Lihat
                             Semua Pesanan</a>
                     </div>
                 </li>
             @endif
         @endauth

         <div class="topbar-divider d-none d-sm-block"></div>

         <!-- Nav Item - User Information -->
         <li class="nav-item dropdown no-arrow">
             <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false">
                 <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                     @auth
                         {{ Auth::user()->name }}
                     @endauth
                 </span>
                 {{-- <img class="img-profile rounded-circle" src="img/undraw_profile.svg"> --}}
                 <div class="icon-circle bg-primary">
                     <i class="fas fa-user-circle text-white"></i>
                 </div>
             </a>
             <!-- Dropdown - User Information -->
             <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                 @guest
                     <a class="dropdown-item" href="{{ route('login') }}">
                         <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                         Login
                     </a>
                 @endguest
                 @auth
                     <a class="dropdown-item" href="{{ route('user.edit', Auth::user()->id_user) }}">
                         <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                         Profile
                     </a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                         <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                         Logout
                     </a>
                 @endauth
             </div>
         </li>

     </ul>

 </nav>
