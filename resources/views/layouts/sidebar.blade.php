   <!-- Sidebar -->
   <div class="sidebar" data-background-color="dark">
       <div class="sidebar-logo">
           <!-- Logo Header -->
           <div class="logo-header" data-background-color="dark">
               <a href="index.html" class="logo">
                   <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
               </a>
               <div class="nav-toggle">
                   <button class="btn btn-toggle toggle-sidebar">
                       <i class="gg-menu-right"></i>
                   </button>
                   <button class="btn btn-toggle sidenav-toggler">
                       <i class="gg-menu-left"></i>
                   </button>
               </div>
               <button class="topbar-toggler more">
                   <i class="gg-more-vertical-alt"></i>
               </button>
           </div>
           <!-- End Logo Header -->
       </div>
       @if (Auth::user()->role == 'sale')
           @include('layouts.menu.sale')
       @endif

       @if (Auth::user()->role == 'admin')
           @include('layouts.menu.admin')
       @endif

       @if (Auth::user()->role == 'pm')
           @include('layouts.menu.pm')
       @endif

       @if (Auth::user()->role == 'contractor')
           @include('layouts.menu.contractor')
       @endif
   </div>
   <!-- End Sidebar -->
