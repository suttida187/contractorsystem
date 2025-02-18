@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <div class="card-title text-center">ตารางงาน</div>
                </div>
                <div class="card-body">



                    <div class="input-group mb-3">
                        <label for="roleSelect">เลือกประเภท:</label>
                        <select id="roleSelect" class="form-select">
                            <option selected disabled>เลือกประเภท</option>
                            <option value="pm">PM</option>
                            <option value="contractor">ผู้รับเหมา</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <label for="userSelect" id="userSelectName">เลือกผู้จัดการโครงการ:</label>
                        <select id="userSelect" class="form-select">
                            <option disabled selected>เลือกผู้จัดการ</option>
                        </select>
                    </div>



                    </select>
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



    <script>
        $(document).ready(function() {
            $('#roleSelect').change(function() {
                var selectedValue = $(this).val(); // รับค่าที่เลือก

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
            });
        });

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
                    const eventData = events.find(event => event.start_date <= eventDate && event.end_date >=
                        eventDate);

                    if (eventData) {
                        cell.classList.add("event-day");
                        cell.style.backgroundColor = "red"; // สีแดงแสดงว่ามี event

                        // ตัดข้อความหากยาวเกินไป
                        let truncatedText = eventData.project_name.length > 10 ? eventData.project_name
                            .substring(0, 10) + "..." : eventData.project_name;

                        // เพิ่ม project_name ในกล่อง
                        const projectLabel = document.createElement("div");
                        projectLabel.textContent = `- ${truncatedText}`;
                        projectLabel.classList.add("project-label");
                        cell.appendChild(projectLabel);

                        // คลิกเพื่อส่ง idProject
                        cell.addEventListener("click", function() {
                            handleEventClick(eventData.id);
                        });
                    }

                    row.appendChild(cell);

                    if ((firstDay + day) % 7 === 0) {
                        calendar.appendChild(row);
                        row = document.createElement("tr");
                    }
                }

                calendar.appendChild(row);
            }


            function handleEventClick(idProject) {
                console.log(`Event Clicked: Project ID ${idProject}`);
                // เพิ่มโค้ดเรียกใช้ฟังก์ชันอื่นที่ต้องการใช้
                alert(`คุณคลิกที่โปรเจค ID: ${idProject}`);
                // สามารถเปลี่ยนเป็นเรียก AJAX หรือฟังก์ชันอื่นได้
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

            await fetchEvents(roleSelect.value);
            renderCalendar(currentMonth, currentYear);
        });
    </script>
@endsection
