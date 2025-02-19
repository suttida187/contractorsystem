@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <div class="card-title text-center">ตารางงาน</div>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3" {{ Auth::user()->role == 'contractor' ? 'hidden' : '' }}>
                        <label for="roleSelect">เลือกประเภท:</label>
                        <select id="roleSelect" class="form-select">
                            <option selected disabled>เลือกประเภท</option>
                            @if (Auth::user()->role == 'admin')
                                <option value="pm">PM</option>
                            @endif

                            <option value="contractor">ผู้รับเหมา</option>
                        </select>
                    </div>

                    <div class="input-group mb-3" {{ Auth::user()->role == 'contractor' ? 'hidden' : '' }}>
                        <label for="userSelect" id="userSelectName">
                            @if (Auth::user()->role == 'admin')
                                เลือกผู้จัดการโครงการ:
                            @else
                                เลือกผู้รับเหมา:
                            @endif
                        </label>
                        <select id="userSelect" class="form-select">
                            <option disabled selected>
                                @if (Auth::user()->role == 'admin')
                                    เลือกผู้จัดการ
                                @else
                                    เลือกผู้รับเหมา
                                @endif

                            </option>
                        </select>
                    </div>

                    <div class="calendar-container">
                        <div class="nav-buttons">
                            <button id="prevMonth">◀</button>
                            <span id="monthYear"></span>
                            <button id="nextMonth">▶</button>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>อา</th>
                                    <th>จ</th>
                                    <th>อ</th>
                                    <th>พ</th>
                                    <th>พฤ</th>
                                    <th>ศ</th>
                                    <th>ส</th>
                                </tr>
                            </thead>
                            <tbody id="calendar"></tbody>
                        </table>
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

                        <div id="stepStatusNull" style="display: none">
                            @include('layouts.stepStatusNull')
                        </div>
                        <div id="stepStatus" style="display: none">
                            @include('layouts.stepStatus')
                        </div>



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
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" id="exampleModalAutoDate"
        data-bs-target="#exampleModalDate" style="display: none">
        Launch demo modal
    </button>

    <div class="modal fade" id="exampleModalDate" tabindex="-1" aria-labelledby="exampleModalLabelCalendars"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabelCalendars">{{-- รายละเอียดงาน --}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('create-calendars') }}" style="padding:16px;">
                        @csrf
                        <div class="row">
                            <h1 class="text-center-project" id="exampleModalLabelCalendarsName">ลง Calendars </h1>
                            <div class="mb-3">
                                <label class="form-label">วันที่ลง: </label>
                                <input name="date" type="text" id="id-date" class="form-control no-edit">
                                <input name="idCalendars" type="text" id="id-calendars" class="form-control" hidden>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">รายละเอียด: </label>
                                <textarea class="form-control" name="message" id="message-id" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="submit-calendars">ยืนยัน</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>


    <script>
        window.Laravel = {!! json_encode([
            'isLoggedIn' => Auth::check(),
            'role' => Auth::check() ? Auth::user()->role : null,
            'idUser' => Auth::check() ? Auth::user()->id : null,
        ]) !!}





        $(document).ready(function() {
            $('#roleSelect').change(function() {
                var selectedValue = $(this).val(); // รับค่าที่เลือก
                userEndpoint(selectedValue);
            });
        });



        function userEndpoint(selectedValue) {
            $.ajax({
                url: `user-endpoint/${selectedValue}`, // เปลี่ยนเป็น URL ที่ต้องการส่งค่าไป
                type: 'GET', // เปลี่ยนจาก 'POST' เป็น 'GET'
                success: function(response) {
                    $('#userSelect').empty(); // ล้างค่าตัวเลือกเก่า
                    $('#userSelectName').html(''); // เคลียร์ Label

                    // ตรวจสอบค่าที่เลือก และอัปเดต Label
                    if (selectedValue == 'pm') {
                        $('#userSelectName').html(
                            '<label for="userSelect">เลือกผู้จัดการโครงการ:</label>');
                        $('#userSelect').append(
                            '<option disabled selected>เลือกผู้จัดการ</option>');
                    } else {
                        $('#userSelectName').html(
                            '<label for="userSelect">เลือกผู้รับเหมา:</label>');
                        $('#userSelect').append(
                            '<option disabled selected>เลือกผู้รับเหมา</option>');
                    }

                    // เพิ่มตัวเลือกเริ่มต้น


                    // ตรวจสอบว่ามีข้อมูลใน response หรือไม่
                    if (response.length > 0) {
                        // วนลูปเพิ่ม option ตามข้อมูลที่ได้รับ
                        response.forEach(function(user) {
                            $('#userSelect').append(
                                `<option value="${user.id}">${user.prefix}  ${user.first_name} ${user.last_name} </option>`
                            );
                        });
                    } else {
                        // กรณีไม่มีข้อมูล
                        $('#userSelect').append('<option disabled>ไม่มีข้อมูล</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        document.addEventListener("DOMContentLoaded", async function() {
            const calendar = document.getElementById("calendar");
            const monthYear = document.getElementById("monthYear");
            const prevBtn = document.getElementById("prevMonth");
            const nextBtn = document.getElementById("nextMonth");
            const roleSelect = document.getElementById("userSelect");


            let date = new Date();
            let currentMonth = date.getMonth();
            let currentYear = date.getFullYear();
            let events = [];

            async function fetchEvents(role) {
                try {

                    const response = await fetch(`getSchedule/${role}`);
                    events = await response.json();



                    renderCalendar(currentMonth, currentYear);
                } catch (error) {
                    console.error("Error fetching events:", error);
                }
            }

            function renderCalendar(month, year) {
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                calendar.innerHTML = "";
                monthYear.textContent =
                    `${new Date(year, month).toLocaleString("default", { month: "long" })} ${year}`;

                let row = document.createElement("tr");
                for (let i = 0; i < firstDay; i++) {
                    let cell = document.createElement("td");
                    row.appendChild(cell);
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    let cell = document.createElement("td");
                    cell.textContent = day;
                    cell.style.position = "relative";


                    const eventDate =
                        `${year}-${(month + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                    const eventData = events.find(event => {



                        if (event.projectId === null) {
                            return event.start_date === eventDate && event.end_date === eventDate;
                        }
                        return event.start_date <= eventDate && event.end_date >= eventDate;
                    });




                    if (eventData) {



                        cell.classList.add("event-day");
                        cell.style.backgroundColor = "red"; // สีแดงแสดงว่ามี event

                        let truncatedText;
                        if (eventData.projectId != null) {
                            truncatedText = eventData.project_name.length > 10 ? eventData.project_name
                                .substring(0, 10) + "..." : eventData.project_name;
                        } else {
                            truncatedText = eventData.message.length > 10 ? eventData.message
                                .substring(0, 10) + "..." : eventData.message;
                        }
                        // ตัดข้อความหากยาวเกินไป


                        // เพิ่ม project_name ในกล่อง
                        const projectLabel = document.createElement("div");
                        projectLabel.textContent = `- ${truncatedText}`;
                        projectLabel.classList.add("project-label");
                        cell.appendChild(projectLabel);

                        // คลิกเพื่อส่ง idProject


                        cell.addEventListener("click", function() {
                            if (eventData.projectId != null) {
                                handleEventClick(eventData.projectId);
                            } else {
                                month = String(month + 1).padStart(2, '0'); // ทำให้เดือนเป็น 2 หลัก
                                day = String(day).padStart(2, '0');
                                document.getElementById("id-date").value = `${year}-${month}-${day}`;
                                document.getElementById("message-id").value = eventData.message;
                                let submitCalendars = document.getElementById("submit-calendars");
                                // เปลี่ยนข้อความปุ่มเป็น "ยืนยัน"
                                submitCalendars.textContent = 'ลบ';
                                // เพิ่มคลาส btn-primary
                                submitCalendars.classList.add("btn-danger");

                                let calendarsName = document.getElementById(
                                    "exampleModalLabelCalendarsName");
                                // เปลี่ยนข้อความปุ่มเป็น "ยืนยัน"
                                calendarsName.textContent = 'Calendars';
                                // เพิ่มคลาส btn-primary
                                document.getElementById("id-calendars").value = eventData.id;
                                document.getElementById("exampleModalAutoDate").click();
                            }

                        });
                    } else {


                        if (window.Laravel.role == 'contractor') {
                            cell.style.cursor = "pointer";
                            cell.addEventListener("click", function() {

                                month = String(month + 1).padStart(2, '0'); // ทำให้เดือนเป็น 2 หลัก
                                day = String(day).padStart(2, '0'); // ทำให้วันเป็น 2 หลัก

                                document.getElementById("id-date").value =
                                    `${year}-${month}-${day}`;
                                document.getElementById("id-calendars").value = null;

                                let submitCalendars = document.getElementById("submit-calendars");
                                // เปลี่ยนข้อความปุ่มเป็น "ยืนยัน"
                                submitCalendars.textContent = 'ยืนยัน';
                                // เพิ่มคลาส btn-primary
                                submitCalendars.classList.add("btn-primary");

                                let calendarsName = document.getElementById(
                                    "exampleModalLabelCalendarsName");
                                // เปลี่ยนข้อความปุ่มเป็น "ยืนยัน"
                                calendarsName.textContent = 'ลง Calendars';

                                document.getElementById("exampleModalAutoDate").click();


                            });
                        }

                    }



                    row.appendChild(cell);

                    if ((firstDay + day) % 7 === 0) {
                        calendar.appendChild(row);
                        row = document.createElement("tr");
                    }
                }

                calendar.appendChild(row);
            }


            async function handleEventClick(idProject) {
                try {
                    /*  console.log(`Event Clicked: Project ID ${idProject}`); */

                    // เรียก API ไปที่ `getProject/{idProject}`
                    const response = await fetch(`getProject/${idProject}`);
                    let date = await response.json();
                    document.getElementById("exampleModalAutoClick").click();
                    userDataFuc(date);
                    // ตรวจสอบว่าการตอบกลับสำเร็จหรือไม่
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                } catch (error) {
                    console.error("Error fetching project data:", error);
                }
            }


            prevBtn.addEventListener("click", function() {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar(currentMonth, currentYear);
            });

            nextBtn.addEventListener("click", function() {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                renderCalendar(currentMonth, currentYear);
            });


            roleSelect.addEventListener("change", function() {
                fetchEvents(roleSelect.value);
            });



            if (window.Laravel.role == 'contractor') {

                await fetchEvents(window.Laravel.idUser);
            } else {
                await fetchEvents(roleSelect.value);
            }



            renderCalendar(currentMonth, currentYear);
        });
    </script>
@endsection
