@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <div class="card-title text-center" style="font-size: 30px; font-weight: bold;">รายชื่อทั้งหมด</div>
                </div>

                <div class="col-md-12">
                    <div class="card-body">                        
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
                                <table class="table table-bordered">
                                    <thead>
                                        <tr style="text-align: center; vertical-align: middle;">
                                            <th scope="col">ลำดับ</th>
                                            <th scope="col">บริษัท</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">ชื่อ-นามสกุล</th>
                                            <th scope="col">สถานะ</th>
                                            <th scope="col" class="col-2">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userTable">
                                        @php $i = 1; @endphp
                                        @foreach ($users as $user)
                                            <tr>
                                                <td style="text-align: center; vertical-align: middle;">{{ $i++ }}</td>
                                                <td>{{ $user->company_name }}</td>
                                                <td style="text-align: center; vertical-align: middle;">{{ $user->email }}</td>
                                                <td style="text-align: center; vertical-align: middle;">{{ implode(' ', [$user->prefix, $user->first_name, $user->last_name]) }}
                                                </td>
                                                <td style="text-align: center; vertical-align: middle;">{{ $user->role }}</td>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    <a class="icon-action view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal" data-user='@json($user)'>
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ $routeActive == 'list-contractor' ? url('list-edit-contractor', $user->id) : url('list-edit-admin', $user->id) }}"
                                                        class="icon-action edit"><i class="far fa-edit"></i></a>
                                                    <a href="javascript:void(0);" class="icon-action delete"
                                                        data-email="{{ $user->email }}" data-user-id="{{ $user->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">รายละเอียด</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                <p class="text-center">รูปโปรไฟล์</p>

                    <div class="col-md-12 text-center mb-3">
                        <img src="/assets/img/profile.jpg"
                            alt="image profile" class="profile-me" id="profile-me">

                    </div>
                    
                    <div class="row">
                        @if ($routeActive == 'list-sale-pm-admin')
                            <div class="mb-3">
                                <label class="form-label">ประเภท: </label>
                                <input name="role" id="modalRole" type="text" class="form-control  no-edit">
                            </div>
                        @else
                            <input name="role" type="text" class="form-control" value="contractor" hidden>
                        @endif


                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email: </label>
                            <input name="email" id="modalEmail" type="email" class="form-control no-edit">

                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username: </label>
                            <input name="username" type="text" id="modalUsername"
                                class="form-control  no-edit @error('username') is-invalid @enderror"
                                value="{{ old('username') }}">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">คำนำหน้า: </label>
                            <input name="prefix" id="modalPrefix" type="text" class="form-control  no-edit">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">ชื่อ: </label>
                            <input name="first_name" type="text" id="modalFirst_name"
                                class="form-control  no-edit  @error('first_name') is-invalid @enderror">
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">นามสกุล: </label>
                            <input name="last_name" type="text" id="modalLast_name"
                                class="form-control  no-edit @error('last_name') is-invalid @enderror">
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <h5 class="col-12 mt-3 mb-3 text-primary"><strong>ข้อมูลเกี่ยวกับบริษัท</strong></h5>


                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">ชื่อบริษัท: </label>
                                <input name="company_name" type="text" id="modalCompany_name"
                                    class="form-control  no-edit @error('company_name') is-invalid @enderror"
                                    value="{{ old('company_name') }}">
                                @error('company_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3" @if ($routeActive != 'list-contractor') hidden @endif>
                                <label class="form-label">เลขประจําตัวผู้เสียภาษี: </label>
                                <input name="tax_id" type="text" id="modalTax_id"
                                    class="form-control  no-edit @error('tax_id')is-invalid @enderror"
                                    value="{{ old('tax_id') }}" oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                    maxlength="13">
                                @error('tax_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ที่อยู่: </label>
                                <input name="address" type="text" id="modalAddress"
                                    class="form-control  no-edit @error('address') is-invalid @enderror"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">ซอย/ถนน: </label>
                                <input name="street" type="text" id="modalStreet"
                                    class="form-control  no-edit @error('street') is-invalid @enderror"
                                    value="{{ old('street') }}">
                                @error('street')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">ตำบล/แขวง: </label>
                                <input name="sub_district" type="text" id="modalSub_district"
                                    class="form-control  no-edit @error('sub_district') is-invalid @enderror"
                                    value="{{ old('sub_district') }}">
                                @error('sub_district')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">อำเภอ/เขต: </label>
                                <input name="district" type="text" id="modalDistrict"
                                    class="form-control  no-edit @error('district') is-invalid @enderror"
                                    value="{{ old('district') }}">
                                @error('district')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">จังหวัด: </label>
                                <input name="province" type="text" id="modalProvince"
                                    class="form-control  no-edit @error('province') is-invalid @enderror"
                                    value="{{ old('province') }}">
                                @error('province')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">รหัสไปรษณีย์: </label>
                                <input name="postal_code" type="text" id="modalPostal_code"
                                    class="form-control  no-edit @error('postal_code') is-invalid @enderror"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="5"
                                    value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">เบอร์โทรศัพท์: </label>
                                <input name="phone" type="text" id="modalPhone"
                                    class="form-control  no-edit @error('phone') is-invalid @enderror"
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
        document.addEventListener("DOMContentLoaded", function() {
            let typingTimer;
            let doneTypingInterval = 500; // หน่วงเวลา 0.5 วินาที

            function filterTable() {
                let selectedRole = document.getElementById("roleFilter").value.toLowerCase().trim();
                let searchText = document.getElementById("searchInput").value.toLowerCase().trim();

                document.querySelectorAll("#userTable tr").forEach(function(row) {
                    let role = row.children[4].textContent.toLowerCase().trim(); // คอลัมน์ที่ 5 = สถานะ
                    let rowText = row.textContent.toLowerCase();

                    let matchesRole = selectedRole == "" || selectedRole == "กรุณาเลือกประเภท"
                        .toLowerCase() || role === selectedRole;
                    let matchesSearch = searchText == "" || rowText.includes(searchText);

                    // แสดงเฉพาะแถวที่ตรงเงื่อนไข
                    row.style.display = matchesRole && matchesSearch ? "" : "none";
                });
            }

            // เมื่อเลือกประเภทใน Select ให้กรองทันที
            document.getElementById("roleFilter").addEventListener("change", filterTable);

            // เมื่อพิมพ์ในช่องค้นหา รอ 0.5 วินาที ก่อนกรอง
            document.getElementById("searchInput").addEventListener("input", function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(filterTable, doneTypingInterval);
            });

            document.getElementById("searchInput").addEventListener("keydown", function(event) {
                if (event.key === "Backspace" && this.value.length === 1) {
                    setTimeout(filterTable, 50);
                }
            });


            // รีเซ็ตเวลา ถ้ายังพิมพ์อยู่
            document.getElementById("searchInput").addEventListener("keydown", function() {
                clearTimeout(typingTimer);
            });

            // แสดงข้อมูลทั้งหมดเมื่อโหลดหน้า
            filterTable();
        });



        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".icon-action.view").forEach(function(btn) {
                btn.addEventListener("click", function() {
                    // ดึงค่า JSON จาก `data-user`
                    var userData = JSON.parse(this.getAttribute("data-user"));

                    console.log("userData", userData);
                    document.getElementById("profile-me").src = userData.images ? '/storage/uploads/' + userData.images : "/assets/img/profile.jpg";


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
