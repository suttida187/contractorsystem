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
                                <span>
                                    {{ \Carbon\Carbon::parse($da->updated_at)->format('d/m/Y') }}
                                    {{ ' ' . \Carbon\Carbon::parse($da->updated_at)->format('H:i:s') }}
                                </span>

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
                        <div class="mb-3" hidden>
                            <label class="form-label">โปรเจกต์ id: </label>
                            <input name="project_id" type="text" id="project_id" class="form-control no-edit">
                        </div>
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
                            <label class="form-label">Sale: </label>
                            <input name="caretaker_sale" type="text" id="caretaker_sale"
                                class="form-control no-edit">

                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">เบอร์ติดต่อ: </label>
                            <input name="caretaker_sale_phone" type="text" id="caretaker_sale_phone"
                                class="form-control no-edit">
                        </div>
                    </div>
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
                            <input name="caretaker_pm_phone" type="text" id="caretaker_pm"
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


                    <div id="output" class="container"></div>


                    @if (Auth::user()->role == 'contractor')
                        <div id="form-upload-image">
                            <h4 class="details-head">รายละเอียดงานที่ส่งมอบ</h4>
                            <form method="POST" action="{{ route('upload-image') }}" enctype="multipart/form-data"
                                style="padding:16px;">
                                @csrf
                                <div id="form-container">
                                    <input name="idProjectImage" type="text" id="project-id-image"
                                        class="form-control" hidden>
                                    <!-- ฟอร์มแรก -->
                                    <div class="form-container">
                                        <div class="form-group-home">
                                            <label>รายละเอียด (ลำดับที่ <span class="form-index">1</span>)</label>
                                            <input type="hidden" name="indexes[]" value="1">
                                            <textarea class="form-control" name="details[]" rows="3"></textarea>
                                        </div>
                                        <div class="form-group-home">
                                            <label>อัปโหลดรูปภาพ</label>
                                            <input type="file" name="images[1][]" class="image-upload form-control"
                                                multiple accept=".jpg,.jpeg,.png,.gif,.pdf">
                                        </div>
                                    </div>
                                </div>

                                <!-- ปุ่มเพิ่มรายละเอียด -->
                                <div class="d-flex justify-content-between button-top">
                                    <button id="add-form" type="button" class="btn btn-warning">+
                                        เพิ่มรายละเอียด</button>
                                    <button type="submit" class="btn btn-primary">ส่งมอบงาน</button>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>
            </div>

        </div>

    </div>

    <script>
        window.Laravel = {!! json_encode([
            'isLoggedIn' => Auth::check(),
            'role' => Auth::user() ? Auth::user()->role : null,
        ]) !!};



        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".project-box").forEach(function(btn) {
                btn.addEventListener("click", function() {
                    // ดึงค่า JSON จาก `data-user`
                    var userData = JSON.parse(this.getAttribute("data-user"));

                    console.log("userData", userData);


                    if (window.Laravel && window.Laravel.role && window.Laravel.role ===
                        'contractor') {
                        if (userData.images == null) {
                            document.getElementById("form-upload-image").style.display = "block";
                        } else {
                            document.getElementById("form-upload-image").style.display = "none";
                        }

                    }

                    // จำลองคลิกเพื่อโหลดข้อมูลตัวแรกเมื่อเปิดหน้า

                    userDataFuc(userData);
                    userImageFucHome(userData);

                });
            });
        });


        if (window.Laravel && window.Laravel.role && window.Laravel.role === 'contractor') {
            $(document).ready(function() {
                let index = 1; // เริ่มต้นที่ 1

                $("#add-form").click(function() {
                    index++; // เพิ่มลำดับ

                    let newForm = `
                    <div class="form-container">
                        <div class="form-group-work">
                            <label>รายละเอียด (ลำดับที่ <span class="form-index">${index}</span>)</label>
                            <input type="hidden" name="indexes[]" value="${index}">
                            <textarea class="form-control-work" name="details[]" rows="3" required></textarea>
                        </div>
                        <div class="form-group-work">
                            <label>อัปโหลดรูปภาพ</label>
                            <input type="file" name="images[${index}][]" class="image-upload form-control" multiple accept=".jpg,.jpeg,.png,.gif,.pdf" required>
                        </div>
                        <button type="button" class="remove-btn btn btn-danger btn-sm">ลบ</button>
                    </div>
                    `;
                    $("#form-container").append(newForm);
                });

                // ฟังก์ชันลบฟอร์มที่เพิ่มขึ้นมา
                $(document).on("click", ".remove-btn", function() {
                    $(this).closest(".form-container").remove();
                    updateIndexes(); // อัปเดตหมายเลขลำดับใหม่
                });

                // ฟังก์ชันอัปเดตหมายเลขลำดับ
                function updateIndexes() {
                    $(".form-container").each(function(i) {
                        let newIndex = i + 1;
                        $(this).find(".form-index").text(newIndex);
                        $(this).find("input[name='indexes[]']").val(newIndex);
                        $(this).find("input[type='file']").attr("name", `images[${newIndex}][]`);
                    });
                }
            });
        }

        function userImageFucHome(userData) {


            let data = [];
            if (typeof userData.images === "string") {
                data = JSON.parse(userData.images);
            }


            const outputDiv = document.getElementById("output");

            outputDiv.innerHTML = "";
            let basePath = "/storage/uploads/"; // ✅ ตั้งค่าพาธของรูป


            if (data.length > 0) {

                outputDiv.classList.add("container"); // ✅ เพิ่ม class="container" ถ้ามีข้อมูล

                data && data.forEach(item => {
                    const div = document.createElement("div");
                    div.classList.add("item");

                    div.innerHTML = `
                            ${window.location.pathname === "/home" && window.Laravel && window.Laravel.role === "contractor"
                                    && userData.statusImage === "edit_works" ? `<button class="edit-btn-work btn-sm" data-index="${item.index}">แก้ไข</button>` : ""}

                            <p><strong>Details:</strong> ${item.details}</p>

                            <div class="images-work">
                                ${item.images.map(img => `<img src="${basePath}${img}" alt="Image">`).join("")}
                            </div>

                            ${userData.message_admin ? `<p><strong>Message Admin:</strong> ${userData.message_admin}</p>` : ""}
                            ${userData.message_pm ? `<p><strong>Message PM:</strong> ${userData.message_pm}</p>` : ""}

                            <!-- Form (ซ่อนก่อน) -->
                            <form method="POST" action="{{ route('edit-upload-image') }}" enctype="multipart/form-data"
                                class="form-group-home-work" id="form-${item.index}">
                                @csrf
                                <label>รายละเอียด (ลำดับที่ <span class="form-index">${item.index}</span>)</label>
                                <input type="hidden" name="id" value="${userData.deliverWorkId || ''}">
                                <input type="hidden" name="indexes[]" value="${item.index}">
                            <div class="mb-3">
                                <textarea class="form-control"  name="details[]"  id="exampleFormControlTextarea1" rows="3"> ${item.details}</textarea>
                            </div>
                                <label>อัปโหลดรูปภาพ</label>
                                <input type="file" name="images[]" class="image-upload form-control" multiple accept=".jpg,.jpeg,.png,.gif,.pdf">

                                <div class="extra-fields"></div>

                                <button type="submit" class="btn btn-primary mt-3 btn-sm">บันทึก</button>
                            </form>
                                `;


                    outputDiv.appendChild(div);
                });
            } else {

                outputDiv.classList.remove("container"); // 🔴 ลบ class ถ้าไม่มีข้อมูล

            }
            document.querySelectorAll(".edit-btn-work").forEach(button => {
                button.addEventListener("click", function() {
                    let index = this.getAttribute("data-index");
                    let form = document.getElementById(`form-${index}`);

                    form.style.display = (form.style.display === "none" || form.style.display === "") ?
                        "block" : "none";
                });
            });

        }
    </script>
@endsection
