@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">รายชื่อทั้งหมด</div>

                        <!-- Select Dropdown สำหรับเลือกประเภท -->

                        <div class="d-flex align-items-center">
                            <div class="col-md-6 col-lg-6" {{ $routeActive == 'list-contractor' ? 'hidden' : '' }}>
                                <div class="mt-3 d-flex align-items-center">
                                    <label class="form-label me-3">เลือกประเภท:</label>
                                    <div class="flex-grow-1">
                                        <select id="roleFilter" class="form-select w-100">
                                            <option selected>กรุณาเลือกประเภท</option>
                                            <option value="admin">admin</option>
                                            <option value="sale">sale</option>
                                            <option value="pm">pm</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ใช้ ms-auto เพื่อให้ปุ่มชิดขวา -->
                            <a href="{{ $routeActive == 'list-contractor' ? url('register-contractor') : url('register-admin') }}"
                                class="btn btn-primary ms-auto">เพิ่มรายชื่อ</a>
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
                                            <td>{{ implode(' ', [$user->prefix, $user->first_name, $user->last_name]) }}
                                            </td>
                                            <td>{{ $user->role }}</td>
                                            <td>
                                                <a class="icon-action view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal" data-user='@json($user)'>
                                                    <i class="fas fa-eye"></i>
                                                </a>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <!-- ส่วนที่ 1: ข้อมูลพื้นฐาน -->
                        <h5 class="col-12 mt-3 mb-3 text-primary"><strong>
                                @if ($routeActive == 'list-sale-pm-admin')
                                    ลงทะเบียน Sale / PM / Admin
                                @else
                                    ลงทะเบียนผู้รับเหมา
                                @endif
                            </strong></h5>


                        @if ($routeActive == 'list-sale-pm-admin')
                            <div class="mb-3">
                                <label class="form-label">เลือกประเภท: </label>
                                {{--   <select name="role" id="modalRole"
                                    class="form-select @error('role') is-invalid @enderror" value="{{ old('email') }}">
                                    <option disabled selected>กรุณาเลือกประเภท</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>admin</option>
                                    <option value="sale" {{ old('role') == 'sale' ? 'selected' : '' }}>sale</option>
                                    <option value="pm" {{ old('role') == 'pm' ? 'selected' : '' }}>pm</option>
                                </select>
                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror --}}
                                <input name="role" id="modalRole" type="text" class="form-control">
                            </div>
                        @else
                            <input name="role" type="text" class="form-control" value="contractor" hidden>
                        @endif


                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email: </label>
                            <input name="email" id="modalEmail" type="email" class="form-control">

                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username: </label>
                            <input name="username" type="text" id="modalUsername"
                                class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="form-label">คำนำหน้า: </label>
                            {{--  <select name="prefix" class="form-select" id="modalPrefix">
                                <option disabled selected>เลือกคำนำหน้า</option>
                                <option value="นาย" {{ old('prefix') == 'นาย' ? 'selected' : '' }}>นาย</option>
                                <option value="นาง" {{ old('prefix') == 'นาง' ? 'selected' : '' }}>นาง</option>
                                <option value="นางสาว" {{ old('prefix') == 'นางสาว' ? 'selected' : '' }}>นางสาว
                                </option>
                            </select> --}}
                            <input name="prefix" id="modalPrefix" type="text" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">ชื่อ: </label>
                            <input name="first_name" type="text" id="modalFirst_name"
                                class="form-control  @error('first_name') is-invalid @enderror">
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">นามสกุล: </label>
                            <input name="last_name" type="text" id="modalLast_name"
                                class="form-control @error('last_name') is-invalid @enderror">
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <h5 class="col-12 mt-3 mb-3 text-primary"><strong>ข้อมูลเกี่ยวกับบริษัท</strong></h5>


                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">ชื่อบริษัท: </label>
                                <input name="company_name" type="text" id="modalCompany_name"
                                    class="form-control @error('company_name') is-invalid @enderror"
                                    value="{{ old('company_name') }}">
                                @error('company_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3" @if ($routeActive != 'list-contractor') hidden @endif>
                                <label class="form-label">เลขประจําตัวผู้เสียภาษี: </label>
                                <input name="tax_id" type="text" id="modalTax_id"
                                    class="form-control @error('tax_id')is-invalid @enderror" value="{{ old('tax_id') }}"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="13">
                                @error('tax_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ที่อยู่: </label>
                                <input name="address" type="text" id="modalAddress"
                                    class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">ซอย/ถนน: </label>
                                <input name="street" type="text" id="modalStreet"
                                    class="form-control @error('street') is-invalid @enderror"
                                    value="{{ old('street') }}">
                                @error('street')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">ตำบล/แขวง: </label>
                                <input name="sub_district" type="text" id="modalSub_district"
                                    class="form-control @error('sub_district') is-invalid @enderror"
                                    value="{{ old('sub_district') }}">
                                @error('sub_district')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">อำเภอ/เขต: </label>
                                <input name="district" type="text" id="modalDistrict"
                                    class="form-control @error('district') is-invalid @enderror"
                                    value="{{ old('district') }}">
                                @error('district')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">จังหวัด: </label>
                                <input name="province" type="text" id="modalProvince"
                                    class="form-control @error('province') is-invalid @enderror"
                                    value="{{ old('province') }}">
                                @error('province')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">รหัสไปรษณีย์: </label>
                                <input name="postal_code" type="text" id="modalPostal_code"
                                    class="form-control @error('postal_code') is-invalid @enderror"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="5"
                                    value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">เบอร์โทรศัพท์: </label>
                                <input name="phone" type="text" id="modalPhone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="10"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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


        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".icon-action.view").forEach(function(btn) {
                btn.addEventListener("click", function() {
                    // ดึงค่า JSON จาก `data-user`
                    var userData = JSON.parse(this.getAttribute("data-user"));

                    console.log("userData", userData);


                    // ใส่ข้อมูลลงใน Modal
                    if (userData.role != 'contractor') {
                        document.getElementById("modalRole").value = userData.role || "";
                    }
                    document.getElementById("modalEmail").value = userData.email || "";
                    document.getElementById("modalUsername").value = userData.username || "";
                    document.getElementById("modalPrefix").value = userData.prefix || "";
                    document.getElementById("modalFirst_name").value = userData.first_name || "";
                    document.getElementById("modalLast_name").value = userData.last_name || "";
                    document.getElementById("modalCompany_name").value = userData.company_name ||
                        "";
                    document.getElementById("modalTax_id").value = userData.tax_id || "";
                    document.getElementById("modalAddress").value = userData.address || "";
                    document.getElementById("modalStreet").value = userData.street || "";
                    document.getElementById("modalSub_district").value = userData.sub_district ||
                        "";
                    document.getElementById("modalDistrict").value = userData.district || "";
                    document.getElementById("modalDistrict").value = userData.district || "";
                    document.getElementById("modalProvince").value = userData.province || "";
                    document.getElementById("modalPostal_code").value = userData.postal_code || "";
                    document.getElementById("modalPhone").value = userData.phone || "";


                });
            });
        });
    </script>
@endsection
