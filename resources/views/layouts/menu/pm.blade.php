@php
    use Illuminate\Support\Str;

    $activeRoute = request()->path();

@endphp
<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">
            <li class="nav-item {{ $activeRoute === 'home' ? 'active' : '' }}">
                <a href="{{ url('home') }}">
                    <i class="fas fa-home"></i>
                    <p>หน้าแรก</p>
                </a>
            </li>

            <li class="nav-item {{ $activeRoute === 'assign-work' ? 'active' : '' }}">
                <a href="{{ url('assign-work') }}">
                    <i class="fa-solid fa-briefcase"></i>
                    <p>มอบหมายงาน</p>
                </a>
            </li>
            <li class="nav-item {{ $activeRoute === 'check-work' ? 'active' : '' }}">
                <a href="{{ url('check-work') }}">
                    <i class="fa-solid fa-list-check"></i>
                    <p>ตรวจสอบงาน</p>
                </a>
            </li>

            <li class="nav-item  {{ $activeRoute === 'home-all' ? 'active' : '' }}">
                <a href="{{ url('home-all') }}">
                    <i class="fa-solid fa-list"></i>
                    <p>โครงการทั้งหมด</p>
                </a>
            </li>
            <li class="nav-item {{ $activeRoute === 'schedule' ? 'active' : '' }}">
                <a href="{{ url('schedule') }}">
                    <i class="fa-solid fa-calendar"></i>
                    <p>ตารางงาน</p>
                </a>
            </li>
        </ul>
    </div>
</div>
