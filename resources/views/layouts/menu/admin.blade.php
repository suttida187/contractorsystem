@php
    use Illuminate\Support\Str;

    $activeRoute = request()->path();

    // กลุ่ม Route ที่มีเมนูย่อย
    $submenuRoutes = [
        'register' => ['register-admin', 'register-contractor'],
        'list' => ['list-sale-pm-admin', 'list-contractor', 'list-edit-contractor/*', 'list-edit-admin/*'],
    ];

    // กำหนด active & show สำหรับแต่ละเมนูย่อย
    $submenuStates = [];
    foreach ($submenuRoutes as $key => $routes) {
        $submenuStates[$key] = collect($routes)->contains(fn($route) => Str::is($route, $activeRoute))
            ? 'active open submenu'
            : '';

        $submenuStates[$key . '_show'] = collect($routes)->contains(fn($route) => Str::is($route, $activeRoute))
            ? 'show'
            : '';
    }

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

            <!-- เมนูลงทะเบียน -->
            <li class="nav-item {{ $submenuStates['register'] }}">
                <a data-bs-toggle="collapse" href="#registered">
                    <i class="far fa-registered"></i>
                    <p>ลงทะเบียน</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse {{ $submenuStates['register_show'] }}" id="registered">
                    <ul class="nav nav-collapse">
                        <li class="{{ $activeRoute === 'register-admin' ? 'active' : '' }}">
                            <a href="{{ url('register-admin') }}">
                                <span class="sub-item">ลงทะเบียน Sale/Pm/Admin</span>
                            </a>
                        </li>
                        <li class="{{ $activeRoute === 'register-contractor' ? 'active' : '' }}">
                            <a href="{{ url('register-contractor') }}">
                                <span class="sub-item">ลงทะเบียนผู้รับเหมา</span>
                            </a>
                        </li>
                    </ul>
                </div>
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

            <!-- เมนูรายชื่อ -->
            <li class="nav-item {{ $submenuStates['list'] }}">
                <a data-bs-toggle="collapse" href="#base">
                    <i class="fas fa-users"></i>
                    <p>รายชื่อ</p>
                    <span class="caret"></span>
                </a>

                <div class="collapse {{ $submenuStates['list_show'] }}" id="base">
                    <ul class="nav nav-collapse">
                        <li
                            class="{{ Str::is(['list-sale-pm-admin', 'list-edit-admin/*'], $activeRoute) ? 'active' : '' }}">
                            <a href="{{ url('list-sale-pm-admin') }}">
                                <span class="sub-item">รายชื่อ Sale/Pm/Admin</span>
                            </a>
                        </li>
                        <li
                            class="{{ Str::is(['list-contractor', 'list-edit-contractor/*'], $activeRoute) ? 'active' : '' }}">
                            <a href="{{ url('list-contractor') }}">
                                <span class="sub-item">รายชื่อผู้รับเหมา</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
