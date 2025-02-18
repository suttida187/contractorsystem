@extends('layouts.app')
@section('content')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        td,
        th {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .calendar-container {
            text-align: center;
            margin: 20px;
        }
    </style>
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">ตารางงาน</div>
                </div>
                <div class="card-body">
                    <div class="calendar-container">
                        <button id="prevMonth">◀</button>
                        <span id="monthYear"></span>
                        <button id="nextMonth">▶</button>
                        <table>
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
        document.addEventListener("DOMContentLoaded", function() {
            const calendar = document.getElementById("calendar");
            const monthYear = document.getElementById("monthYear");
            const prevBtn = document.getElementById("prevMonth");
            const nextBtn = document.getElementById("nextMonth");

            let date = new Date();
            let currentMonth = date.getMonth();
            let currentYear = date.getFullYear();

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
                    cell.addEventListener("click", function() {
                        alert(`คุณเลือกวันที่ ${day}/${month + 1}/${year}`);
                    });
                    row.appendChild(cell);

                    if ((firstDay + day) % 7 === 0) {
                        calendar.appendChild(row);
                        row = document.createElement("tr");
                    }
                }

                calendar.appendChild(row);
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

            renderCalendar(currentMonth, currentYear);
        });
    </script>
@endsection
