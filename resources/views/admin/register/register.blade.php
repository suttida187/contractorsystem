@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <form method="POST" action="{{ route('register-store') }}" style="padding:16px;">
                    @csrf

                    <div class="row">
                        <!-- ส่วนที่ 1: ข้อมูลพื้นฐาน -->
                        <h5 class="col-12 mt-3 mb-3 text-primary"><strong>
                                @if ($status_name == 0)
                                    ลงทะเบียน Sale / PM / Admin
                                @else
                                    ลงทะเบียนผู้รับเหมา
                                @endif
                            </strong></h5>


                        @if ($status_name == 0)
                            <div class="mb-3">
                                <label class="form-label">เลือกประเภท: </label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror"
                                    value="{{ old('email') }}">
                                    <option disabled selected>กรุณาเลือกประเภท</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>admin</option>
                                    <option value="sale" {{ old('role') == 'sale' ? 'selected' : '' }}>sale</option>
                                    <option value="pm" {{ old('role') == 'pm' ? 'selected' : '' }}>pm</option>
                                </select>
                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @else
                            <input name="role" type="text" class="form-control" value="contractor" hidden>
                        @endif


                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email: </label>
                            <input name="email" type="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username: </label>
                            <input name="username" type="text"
                                class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password: </label>
                            <input name="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm-Password: </label>
                            <input name="password_confirmation" type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">คำนำหน้า: </label>
                            <select name="prefix" class="form-select @error('prefix') is-invalid @enderror">
                                <option disabled selected>เลือกคำนำหน้า</option>
                                <option value="นาย" {{ old('prefix') == 'นาย' ? 'selected' : '' }}>นาย</option>
                                <option value="นาง" {{ old('prefix') == 'นาง' ? 'selected' : '' }}>นาง</option>
                                <option value="นางสาว" {{ old('prefix') == 'นางสาว' ? 'selected' : '' }}>นางสาว</option>
                            </select>
                            @error('prefix')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">ชื่อ: </label>
                            <input name="first_name" type="text"
                                class="form-control @error('first_name') is-invalid @enderror"
                                value="{{ old('first_name') }}">
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">นามสกุล: </label>
                            <input name="last_name" type="text"
                                class="form-control @error('last_name') is-invalid @enderror"
                                value="{{ old('last_name') }}">
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <h5 class="col-12 mt-3 mb-3 text-primary"><strong>ข้อมูลเกี่ยวกับบริษัท</strong></h5>


                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">ชื่อบริษัท: </label>
                            <input name="company_name" type="text"
                                class="form-control @error('company_name') is-invalid @enderror"
                                value="{{ old('company_name') }}">
                            @error('company_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3" @if ($status_name == 0) hidden @endif>
                            <label class="form-label">เลขประจําตัวผู้เสียภาษี: </label>
                            <input name="tax_id" type="text" class="form-control @error('tax_id')is-invalid @enderror"
                                value="{{ old('tax_id') }}" oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                maxlength="13">
                            @error('tax_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ที่อยู่: </label>
                            <input name="address" type="text"
                                class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">ซอย/ถนน: </label>
                            <input name="street" type="text"
                                class="form-control @error('street') is-invalid @enderror" value="{{ old('street') }}">
                            @error('street')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">ตำบล/แขวง: </label>
                            <input name="sub_district" type="text"
                                class="form-control @error('sub_district') is-invalid @enderror"
                                value="{{ old('sub_district') }}">
                            @error('sub_district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">อำเภอ/เขต: </label>
                            <input name="district" type="text"
                                class="form-control @error('district') is-invalid @enderror"
                                value="{{ old('district') }}">
                            @error('district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">จังหวัด: </label>
                            <input name="province" type="text"
                                class="form-control @error('province') is-invalid @enderror"
                                value="{{ old('province') }}">
                            @error('province')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">รหัสไปรษณีย์: </label>
                            <input name="postal_code" type="text"
                                class="form-control @error('postal_code') is-invalid @enderror"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="5"
                                value="{{ old('postal_code') }}">
                            @error('postal_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">เบอร์โทรศัพท์: </label>
                            <input name="phone" type="text"
                                class="form-control @error('phone') is-invalid @enderror"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="10"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
