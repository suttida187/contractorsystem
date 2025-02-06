@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">รายชื่อทั้งหมด</div>

                        <!-- Select Dropdown สำหรับเลือกประเภท -->

                        <div class="d-flex">
                            <div class="col-md-6 col-lg-6" {{ $routeActive == 'list-contractor' ? 'hidden' : '' }}>
                                <div class=" mt-3 d-flex align-items-center">
                                    <label class="form-label me-3">เลือกประเภท:</label>
                                    <div class="flex-grow-1">
                                        <select id="roleFilter" class="form-select w-100">
                                            <option value="" selected>กรุณาเลือกประเภท</option>
                                            <option value="admin">admin</option>
                                            <option value="sale">sale</option>
                                            <option value="pm">pm</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- ช่องค้นหาข้อมูล -->
                        <div class="mb-3 mt-3">
                            <input type="text" id="searchInput" placeholder="Search ..." class="form-control" />
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">บริษัท</th>
                                        <th scope="col">ชื่อ-นามสกุล</th>
                                        <th scope="col">สถานะ</th>
                                        <th scope="col" class="col-2">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody id="userTable">
                                    @php $i = 1; @endphp
                                    @foreach ($users as $user)
                                        <tr data-role="{{ $user->role }}">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $user->company_name }}</td>
                                            <td>{{ implode(' ', [$user->first_name, $user->last_name]) }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>
                                                <a href="#" class="icon-action view"><i class="fas fa-eye"></i></a>
                                                <a href="#" class="icon-action edit"><i class="far fa-edit"></i></a>
                                                <a href="#" class="icon-action delete"><i
                                                        class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            var typingTimer;
            var doneTypingInterval = 500; // กำหนดเวลาหน่วง (0.5 วินาที)

            // ฟังก์ชันกรองตาราง
            function filterTable() {
                var selectedRole = $("#roleFilter").val().toLowerCase();
                var searchText = $("#searchInput").val().toLowerCase();

                $("#userTable tr").each(function() {
                    var role = $(this).data("role").toLowerCase();
                    var textMatch = $(this).text().toLowerCase().indexOf(searchText) > -1;

                    if ((selectedRole === "" || role === selectedRole) && textMatch) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }

            // เมื่อเลือกประเภทใน Select ให้กรองทันที
            $("#roleFilter").change(function() {
                filterTable();
            });

            // เมื่อพิมพ์ในช่องค้นหา รอ 0.5 วินาที ก่อนกรอง
            $("#searchInput").on("input", function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(filterTable, doneTypingInterval);
            });

            // รีเซ็ตเวลา ถ้ายังพิมพ์อยู่
            $("#searchInput").on("keydown", function() {
                clearTimeout(typingTimer);
            });

        });
    </script>
@endsection
