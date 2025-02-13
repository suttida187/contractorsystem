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
                            <div class="project-box" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                data-user='@json($da)'>
                                <span class="project-title">{{ $da->project_name }}</span>
                                <br>
                                <span>{{ \Carbon\Carbon::parse($da->updated_at)->format('d/m/') . (\Carbon\Carbon::parse($da->updated_at)->year + 543) . ' ' . \Carbon\Carbon::parse($da->updated_at)->format('H:i') }}</span>


                            </div>

                            <div class="project-status">
                                @include('layouts.status')
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" id="exampleModalAutoClick"
        data-bs-target="#exampleModal" style="display: none">
        Launch demo modal
    </button>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{-- รายละเอียดงาน --}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- ข้อมูลพื้นฐาน -->

                        @if ($data->count() > 0)
                            <div id="stepStatusNull" style="display: none">
                                @include('layouts.stepStatusNull')
                            </div>
                            <div id="stepStatus" style="display: none">
                                @include('layouts.stepStatus')
                            </div>
                        @endif


                        <h1 class="text-center-project" id="exampleModalLabel">รายละเอียดงาน</h1>

                        <div class="mb-3">
                            <label class="form-label">ชื่อโปรเจกต์: </label>
                            <input name="project_name" type="text" id="project_name" class="form-control no-edit">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">ประเภทงาน: </label>
                            <input name="work_type" type="text" id="work_type" class="form-control no-edit">

                            <!-- แสดงช่องกรอกข้อมูลเมื่อเลือก "Other" -->

                            <div class="mt-2 d-none" id="otherWork_typeDiv">
                                <label class="form-label">โปรดระบุประเภทงาน:</label>
                                <input name="other_work_type" type="text" id="other_work_type"
                                    class="form-control no-edit">
                            </div>
                        </div>

                        <div class="col-md-6
                                    mb-3">
                            <label class="form-label">Solution: </label>
                            <input name="solution" type="text" id="solution" class="form-control no-edit">
                            <!-- แสดงช่องกรอกข้อมูลเมื่อเลือก "Other" -->
                            <div class="mt-2 d-none" id="otherSolutionDiv">
                                <label class="form-label">โปรดระบุ Solution:</label>
                                <input name="other_solution" type="text" id="other_solution"
                                    class="form-control no-edit">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">คำอธิบายงาน: </label>
                            <input name="work_description" type="text" id="work_description"
                                class="form-control no-edit">

                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">วันที่นัดหมาย: </label>
                            <input name="meeting_date" type="date" id="meeting_date" class="form-control no-edit">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">เวลานัดหมาย: </label>
                            <input name="meeting_time" type="time" id="meeting_time" class="form-control no-edit">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">วันที่สิ้นสุดงาน: </label>
                            <input name="end_date" type="date" id="end_date" class="form-control no-edit">
                        </div>
                    </div>

                    <h5 class="col-12 mt-3 mb-3 text-primary"><strong>ข้อมูลลูกค้า</strong></h5>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">ชื่อบริษัท/นิติบุคคล: </label>
                            <input name="company_name" type="text" id="company_name" class="form-control no-edit">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">ชื่อผู้ติดต่อ: </label>
                            <input name="contact_name" type="text" id="contact_name" class="form-control no-edit">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">เบอร์ติดต่อ: </label>
                            <input name="contact_phone" type="text" id="contact_phone" class="form-control no-edit">

                        </div>

                        <div class="mb-3">
                            <label class="form-label">ตำแหน่งของผู้ติดต่อ: </label>
                            <input name="contact_position" type="text" id="contact_position"
                                class="form-control no-edit">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">พิกัด (ลิงก์จาก Google Map): </label>
                            <input name="location" type="url" id="location" class="form-control">
                            <a id="location_link" href="#" target="_blank" class="d-none mt-2 text-primary">เปิด
                                Google Maps</a>
                        </div>

                    </div>

                    <h5 class="col-12 mt-3 mb-3 text-primary"><strong>รายละเอียดเพิ่มเติมเกี่ยวกับงาน</strong></h5>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">การรับประกัน: </label>
                            <input name="warranty" type="text" id="warranty" class="form-control no-edit">

                        </div>

                        <div class="mb-3">
                            <label class="form-label">หมายเหตุ/คำแนะนำเพิ่มเติม: </label>
                            <textarea name="additional_notes" class="form-control no-edit" id="additional_notes"></textarea>

                        </div>

                        <div class="mb-3">
                            <label class="form-label">ต้องการเอกสารส่งหรือไม่: </label>
                            <input name="needs_documents" type="text" id="needs_documents"
                                class="form-control no-edit">
                        </div>
                    </div>

                    <h5 class="col-12 mt-3 mb-3 text-primary"><strong>รายละเอียดผู้ดูเเล</strong></h5>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Admin: </label>
                            <input name="caretaker_admin" type="text" id="caretaker_admin"
                                class="form-control no-edit">

                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">เบอร์ติดต่อ: </label>
                            <input name="caretaker_admin_phone" type="text" id="caretaker_admin_phone"
                                class="form-control no-edit">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">ผู้จัดการโครงการ: </label>
                            <input name="caretaker_pm_phone" type="text" id="caretaker_pm_phone"
                                class="form-control no-edit">

                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">เบอร์ติดต่อ: </label>
                            <input name="caretaker_pm_phone" type="text" id="caretaker_pm_phone"
                                class="form-control no-edit">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">ผู้รับเหมา: </label>
                            <input name="caretaker_contractor" type="text" id="caretaker_contractor"
                                class="form-control no-edit">

                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">เบอร์ติดต่อ: </label>
                            <input name="caretaker_contractor_phone" type="text" id="caretaker_contractor_phone"
                                class="form-control no-edit">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".project-box").forEach(function(btn) {
                btn.addEventListener("click", function() {
                    // ดึงค่า JSON จาก `data-user`
                    var userData = JSON.parse(this.getAttribute("data-user"));
                    userDataFuc(userData);

                });
            });
        });
    </script>
@endsection
