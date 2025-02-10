<div class="main-header">
    <div class="main-header-logo">
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
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                @if (session('message'))
                    <p class="message-text-color"> {{ session('message') }}</p>
                @endif
            </nav>

            @php
                $notifications = DB::table('notifications')->whereNull('read_at')->latest()->get();
            @endphp

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        @if ($notifications->count() > 0)
                            <span class="notification">{{ $notifications->count() }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">
                                คุณมี {{ $notifications->count() }} การแจ้งเตือนใหม่
                            </div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                    @foreach ($notifications as $notification)
                                        <a href="{{ route('notifications.markAsRead', $notification->id) }}">
                                            <div class="notif-icon notif-primary" style="width: 55px">
                                                <i class="fa fa-project-diagram"></i>
                                            </div>
                                            <div class="notif-content">
                                                <span
                                                    class="block">{{ json_decode($notification->data, true)['message'] }}</span>
                                                <span
                                                    class="time">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        <li>
                            {{--  <a class="see-all" href="{{ route('notifications.index') }}">ดูการแจ้งเตือนทั้งหมด</a> --}}
                        </li>
                    </ul>
                </li>


                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                        aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{ URL::asset('/assets/img/profile.jpg') }}" alt="..."
                                class="avatar-img rounded-circle" />
                        </div>
                        <span class="profile-username">

                            <span class="fw-bold">{{ Auth::user()->username }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <img src="{{ URL::asset('/assets/img/profile.jpg') }}" alt="image profile"
                                            class="avatar-img rounded" />
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ Auth::user()->username }}</h4>
                                        <p class="text-muted">{{ Auth::user()->email }}</p>
                                        <a href="profile.html" class="btn btn-xs btn-secondary btn-sm">View
                                            Profile</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">My Profile</a>
                                <a class="dropdown-item" href="#">My Balance</a>
                                <a class="dropdown-item" href="#">Inbox</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Account Setting</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
