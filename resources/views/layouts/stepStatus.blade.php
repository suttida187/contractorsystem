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
    <div class="progress-line @if ($currentStep >= 1) active @endif"></div>
    <div class="progress-line dashed-line @if ($currentStep >= 2) active @endif"></div>
    <div class="progress-line @if ($currentStep >= 1) active @endif"></div>
    <div class="progress-line dashed-line @if ($currentStep >= 2) active @endif"></div>

    <!-- สเต็ป 1 -->
    <div class="text-center">
        <div class="progress-step @if ($currentStep >= 1) active @endif">1</div>
        <div class="progress-text">ผู้รับเหมาส่งมอบงาน</div>
    </div>

    <!-- สเต็ป 2 -->
    <div class="text-center">
        <div class="progress-step @if ($currentStep >= 2) active @endif">2</div>
        <div class="progress-text">PM ตรวจสอบ</div>
    </div>

    <!-- สเต็ป 3 -->
    <div class="text-center">
        <div class="progress-step @if ($currentStep >= 3) active @endif">3</div>
        <div class="progress-text">แอดมินตรวจสอบ</div>
    </div>

    <!-- สเต็ป 4 -->
    <div class="text-center">
        <div class="progress-step @if ($currentStep >= 4) active @endif">4</div>
        <div class="progress-text">เสร็จสมบูรณ์</div>
    </div>
</div>
