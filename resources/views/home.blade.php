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
                            <div class="project-status">รอ PM ตรวจสอบ</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
