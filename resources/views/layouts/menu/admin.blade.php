<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                    <i class="fas fa-home"></i>
                    <p>หน้าแรก</p>

                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                    <i class="fas fa-layer-group"></i>
                    <p>ลงทะเบียน</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="{{ url('register-admin') }}">
                                <span class="sub-item">ลงทะเบียน Sale/Pm/Admin</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('register-contractor') }}">
                                <span class="sub-item">ลงทะเบียนผู้รับเหมา</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                    <i class="fas fa-layer-group"></i>
                    <p>มอบหมายงาน</p>

                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="{{ url('assign.work') }}">
                    <i class="fas fa-layer-group"></i>
                    <p>ตรวจสอบงาน</p>

                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="{{ url('all.projects') }}">
                    <i class="fas fa-layer-group"></i>
                    <p>โครงการทั้งหมด</p>

                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="{{ url('schedule') }}">
                    <i class="fas fa-layer-group"></i>
                    <p>ตารางงาน</p>
                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                    <i class="fas fa-layer-group"></i>
                    <p>รายชื่อ</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="{{ url('list.sale') }}">
                                <span class="sub-item">รายชื่อ Sale/Pm/Admin</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('list.contractor') }}">
                                <span class="sub-item">รายชื่อผู้รับเหมา</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
