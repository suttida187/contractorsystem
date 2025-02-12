<div class="progress-container d-flex justify-content-between align-items-center position-relative">
    @php
        // กำหนดสเต็ปของสถานะ
        $responsibleSteps = [
            'admin' => !is_null($da->responsible_admin) ? 1 : 0,
            'pm' => !is_null($da->responsible_admin) && !is_null($da->responsible_pm) ? 2 : 0,
            'contractor' =>
                !is_null($da->responsible_admin) &&
                !is_null($da->responsible_pm) &&
                !is_null($da->responsible_contractor)
                    ? 3
                    : 0,
        ];

        // กำหนดสเต็ปปัจจุบัน
        $currentStep = max($responsibleSteps);
    @endphp


    <div class="progress-line  step-1 @if ($currentStep >= 2) active @else dashed-line @endif"></div>
    <div class="progress-line step-2 @if ($currentStep >= 3) active @else dashed-line @endif"></div>
    <div class="progress-line  step-3 @if ($currentStep >= 4) active @else dashed-line @endif"></div>

    <!-- สเต็ป 1 -->
    <div class="text-center">
        <div class="progress-step @if ($currentStep >= 1) active @endif">1</div>
        <div class="progress-text">Sale กำลังดำเนินงาน</div>
    </div>

    <!-- สเต็ป 2 -->
    <div class="text-center">
        <div class="progress-step @if ($currentStep >= 2) active @endif">2</div>
        <div class="progress-text">รอ Admin ดำเนินการ</div>
    </div>

    <!-- สเต็ป 3 -->
    <div class="text-center">
        <div class="progress-step @if ($currentStep >= 3) active @endif">3</div>
        <div class="progress-text">รอ PM ดำเนินการ</div>
    </div>

    <!-- สเต็ป 4 -->
    <div class="text-center">
        <div class="progress-step @if ($currentStep >= 4) active @endif">4</div>
        <div class="progress-text">รอผู้รับเหมาดำเนินงาน</div>
    </div>
</div>
