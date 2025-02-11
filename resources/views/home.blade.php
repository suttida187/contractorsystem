@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">อัพเดตสถานะ</div>
                </div>
                <div class="card-body">
                    @foreach ($data as $da)
                        <div class="row">
                            <div class="project-box">
                                <span class="project-title">{{ $da->project_name }}</span>
                                <br>
                                <span>{{ \Carbon\Carbon::parse($da->updated_at)->format('d/m/') . (\Carbon\Carbon::parse($da->updated_at)->year + 543) . ' ' . \Carbon\Carbon::parse($da->updated_at)->format('H:i') }}</span>


                            </div>

                            <div class="project-status">
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
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
