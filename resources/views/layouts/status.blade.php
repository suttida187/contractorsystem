@if (is_null($da->status))
    @if (is_null($da->responsible_admin) && is_null($da->responsible_pm) && is_null($da->responsible_contractor))
        รอ Admin ดำเนินการ
    @elseif (!is_null($da->responsible_admin) && !is_null($da->responsible_pm) && is_null($da->responsible_contractor))
        รอ PM ดำเนินการ
    @elseif (!is_null($da->responsible_admin) && !is_null($da->responsible_pm) && !is_null($da->responsible_contractor))
        รอผู้รับเหมาดำเนินงาน
    @endif
@else
    @switch($da->status)
        @case('waiting_contractor')
            ผู้รับเหมาส่งมอบงาน
        @break

        @case('waiting_admin_review')
            รอ Admin ตรวจสอบ
        @break

        @case('waiting_pm_review')
            รอ PM ตรวจสอบ
        @break

        @case('completed')
            เสร็จสมบูรณ์
        @break

        @default
            สถานะไม่ระบุ
    @endswitch
@endif
