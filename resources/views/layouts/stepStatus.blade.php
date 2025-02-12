<div class="progress-container d-flex justify-content-between align-items-center position-relative">
    @php
        $statusSteps = [
            'waiting_contractor' => 1,
            'waiting_pm_review' => 2,
            'waiting_admin_review' => 3,
            'completed' => 4,
        ];
        $currentStep = $statusSteps[$da->status] ?? 0;
    @endphp

    <!-- เส้น Progress -->
    <div
        class="progress-line-check step-1 @if ($currentStep >= 2) active @else dashed-line-check step-1 @endif">
    </div>
    <div
        class="progress-line-check step-2 @if ($currentStep >= 3) active @else dashed-line-check step-2 @endif">
    </div>
    <div
        class="progress-line-check step-3 @if ($currentStep >= 4) active @else dashed-line-check step-3 @endif">
    </div>

    <!-- สเต็ป 1 -->
    <div class="text-center">
        <div class="progress-step-check @if ($currentStep >= 1) active @endif">1</div>
        <div class="progress-text-check">ผู้รับเหมาส่งมอบงาน</div>
    </div>

    <!-- สเต็ป 2 -->
    <div class="text-center">
        <div class="progress-step-check @if ($currentStep >= 2) active @endif">2</div>
        <div class="progress-text-check">PM ตรวจสอบ</div>
    </div>

    <!-- สเต็ป 3 -->
    <div class="text-center">
        <div class="progress-step-check @if ($currentStep >= 3) active @endif">3</div>
        <div class="progress-text-check">แอดมินตรวจสอบ</div>
    </div>

    <!-- สเต็ป 4 -->
    <div class="text-center">
        <div class="progress-step-check @if ($currentStep >= 4) active @endif">4</div>
        <div class="progress-text-check">เสร็จสมบูรณ์</div>
    </div>


</div>
