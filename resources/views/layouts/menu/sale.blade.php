<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">
            @php
                use Illuminate\Support\Str;

                $activeRoute = request()->path();

            @endphp

            <li class="nav-item {{ $activeRoute === 'home' ? 'active' : '' }}">
                <a href="{{ url('home') }}">
                    <i class="fas fa-home"></i>
                    <p>หน้าแรก</p>

                </a>

            </li>
            <li class="nav-item  {{ $activeRoute === 'create-form' ? 'active' : '' }}">
                <a href="{{ url('create-form') }}">
                    <i class="fa-solid fa-square-plus"></i>
                    <p>เเบบฟอร์มขอคิวงาน</p>
                </a>
            </li>
            <li class="nav-item  {{ $activeRoute === 'home-all' ? 'active' : '' }}">
                <a href="{{ url('home-all') }}">
                    <i class="fa-solid fa-list"></i>
                    <p>โครงการทั้งหมด</p>
                </a>
            </li>
        </ul>
    </div>
</div>
