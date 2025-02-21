@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">โครงการทั้งหมด</h2>

                    <div class="filter-container justify-content-center mt-3">
                        <!-- ฟอร์มค้นหา + ตัวกรอง -->

                        <form method="POST" action="{{ route('search_query-project') }}" style="padding:16px;">
                            @csrf
                            <!-- ช่องค้นหา -->
                            <div class="d-flex justify-content-center mb-3 flex-wrap filter-container">
                                <div class="search-box">
                                    <input type="text" id="search-input" name="search_query" value="{{ $searchQuery }}"
                                        placeholder="ค้นหา...">
                                    <button type="submit"><i class="fas fa-search"></i> ค้นหา</button>
                                </div>
                                <input type="hidden" id="filter-input" name="filter_status" value="projectAll">

                                <!-- ปุ่มกรองโครงการ -->
                                <div class="filter-button-group">
                                    <button type="submit"
                                        class="filter-btn  {{ $filterStatus == 'projectAll' ? 'active' : '' }}"
                                        data-value="projectAll">โครงการทั้งหมด</button>
                                    <button type="submit"
                                        class="filter-btn    {{ $filterStatus == 'waiting_contractor' ? 'active' : '' }}"
                                        data-value="waiting_contractor">รอผู้รับเหมาส่งงาน</button>
                                    <button type="submit"
                                        class="filter-btn    {{ $filterStatus == 'waiting_pm_review' ? 'active' : '' }}"
                                        data-value="waiting_pm_review">รอ PM ตรวจสอบ</button>
                                    <button type="submit"
                                        class="filter-btn  {{ $filterStatus == 'waiting_admin_review' ? 'active' : '' }}"
                                        data-value="waiting_admin_review">รอแอดมินตรวจสอบ</button>
                                    <button type="submit"
                                        class="filter-btn   {{ $filterStatus == 'completed' ? 'active' : '' }}"
                                        data-value="completed">เสร็จสมบูรณ์</button>
                                </div>
                            </div>

                            <!-- ปุ่มตัวกรอง -->

                        </form>
                    </div>



                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ชื่อโครงการ</th>
                                    <th scope="col">สถานะ</th>
                                    <th scope="col">เซลล์</th>
                                    <th scope="col">แอดมิน</th>
                                    <th scope="col">ผู้จัดการโครงการ</th>
                                    <th scope="col">ผู้รับเหมา</th>
                                    <th scope="col">วันที่เริ่มโครงการ</th>
                                    <th scope="col">วันที่สิ้นสุดโครงการ</th>
                                    <th scope="col">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody id="userTable">
                                @php $i = 1; @endphp
                                @foreach ($data as $da)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $da->project_name }}</td>
                                        <td>
                                            @if ($da->status == null)
                                                @if (is_null($da->responsible_admin) && is_null($da->responsible_pm) && is_null($da->responsible_contractor))
                                                    Sale กำลังดำเนินงาน
                                                @elseif (!is_null($da->responsible_admin) && is_null($da->responsible_pm) && is_null($da->responsible_contractor))
                                                    รอ Admin ดำเนินการ
                                                @elseif (!is_null($da->responsible_admin) && !is_null($da->responsible_pm) && is_null($da->responsible_contractor))
                                                    รอ PM ดำเนินการ
                                                @elseif (!is_null($da->responsible_admin) && !is_null($da->responsible_pm) && !is_null($da->responsible_contractor))
                                                    รอผู้รับเหมาดำเนินงาน
                                                @endif
                                            @else
                                                @if ($da->status == 'waiting_contractor')
                                                    ผู้รับเหมาส่งมอบงาน
                                                @elseif ($da->status == 'waiting_pm_review')
                                                    PM ตรวจสอบ
                                                @elseif ($da->status == 'waiting_admin_review')
                                                    แอดมินตรวจสอบ
                                                @elseif ($da->status == 'completed')
                                                    เสร็จสมบูรณ์
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            {{ $da->sale_prefix }} {{ $da->sale_first_name }} {{ $da->sale_last_name }}
                                        </td>
                                        <td>
                                            {{ $da->admin_prefix }} {{ $da->admin_first_name }}
                                            {{ $da->admin_last_name }}
                                        </td>
                                        <td>
                                            {{ $da->pm_prefix }} {{ $da->pm_first_name }} {{ $da->pm_last_name }}
                                        </td>
                                        <td> {{ $da->contractor_prefix }} {{ $da->contractor_first_name }}
                                            {{ $da->contractor_last_name }}</td>

                                        <td> {{ \Carbon\Carbon::parse($da->meeting_date)->format('d/m/') . (\Carbon\Carbon::parse($da->meeting_date)->year + 543) }}
                                        </td>

                                        <td> {{ \Carbon\Carbon::parse($da->end_date)->format('d/m/') . (\Carbon\Carbon::parse($da->end_date)->year + 543) }}
                                        </td>
                                        <td>
                                            <a class="icon-action view" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" data-user='@json($da)'>
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-3">
                        {{ $data->links() }}
                    </div>
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
                    <div class="text-end">
                        <a id="id-pdf"></a>

                    </div>

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
            document.querySelectorAll(".icon-action.view").forEach(function(btn) { // ✅ แก้ selector
                btn.addEventListener("click", function() {
                    let userDataAttr = this.getAttribute("data-user"); // ✅ ตรวจสอบก่อน parse

                    if (userDataAttr) {
                        try {
                            let userData = JSON.parse(userDataAttr);
                            console.log("userData", userData);

                            // เรียกฟังก์ชัน (ถ้าต้องการ)
                            userDataFuc(userData);
                            userImageFuc(userData)

                            if (window.Laravel && window.Laravel.role == 'admin' && userData
                                .status == 'completed') {
                                const pdfContainer = document.getElementById("id-pdf");
                                if (pdfContainer) {
                                    pdfContainer.outerHTML =
                                        `<a href="export-pdf/${userData.id}" class="btn btn-primary" target="_blank" rel="noopener noreferrer">PDF</a>`;
                                }
                            }


                        } catch (error) {
                            console.error("JSON parse error:", error);
                        }
                    } else {
                        console.warn("Attribute data-user is missing");
                    }
                });
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            let filterButtons = document.querySelectorAll(".filter-btn");
            let filterInput = document.getElementById("filter-input");

            filterButtons.forEach(button => {
                button.addEventListener("click", function(event) {
                    event.preventDefault(); // ป้องกันการโหลดหน้าใหม่ก่อนส่งค่า
                    filterInput.value = this.getAttribute("data-value"); // เปลี่ยนค่าที่ส่ง
                    this.closest("form").submit(); // ส่งฟอร์ม
                });
            });
        });

        function userImageFuc(userData) {




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
                        ${userData.statusImage != 'success' ? `<button class="edit-btn btn-sm" data-index="${item.index}">แก้ไข</button>` : ""}
                        <div class="images">
                            ${item.images.map(img => `<img src="${basePath}${img}" alt="Image">`).join("")}
                        </div>
                        <p><strong>Details:</strong> ${item.details}</p>
                        <p><strong>Status:</strong> ${item.statusImage}</p>
                        ${userData.message_admin ? `<p><strong>Message Admin:</strong> ${userData.message_admin}</p>` : ""}
                        ${userData.message_pm ? `<p><strong>Message PM:</strong> ${userData.message_pm}</p>` : ""}

                        <!-- Form (ซ่อนก่อน) -->
                        <form method="POST" action="{{ route('edit-upload-image') }}" enctype="multipart/form-data"
                            class="form-group-home" id="form-${item.index}">
                            @csrf
                            <label>รายละเอียด (ลำดับที่ <span class="form-index">${item.index}</span>)</label>
                            <input type="hidden" name="id" value="${userData.deliverWorkId}">
                            <input type="hidden" name="indexes[]" value="${item.index}">
                            <textarea class="form-control" name="details[]" rows="3">${item.details}</textarea>

                            <label>อัปโหลดรูปภาพ</label>
                            <input type="file" name="images[]" class="image-upload form-control" multiple accept=".jpg,.jpeg,.png,.gif,.pdf">


                            <div class="extra-fields"></div>

                            <button type="submit"  class="btn btn-primary mt-3 btn-sm">บันทึก</button>
                        </form>
                        `;


                    outputDiv.appendChild(div);
                });
            } else {

                outputDiv.classList.remove("container"); // 🔴 ลบ class ถ้าไม่มีข้อมูล

            }
            document.querySelectorAll(".edit-btn").forEach(button => {
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
