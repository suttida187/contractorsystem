@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mt-3 text-center">เเก้ไข profile</div>
                </div>
                <form method="POST" action="{{ route('register-update-user', $user->id) }}" style="padding:16px;"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3">
                            <!-- ส่วนที่ 1: ข้อมูลพื้นฐาน -->
                            <label class="form-label">Upload Image:</label>
                            <input name="image" type="file" accept="image/*"
                                class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email: </label>
                            <input name="email" type="email" value="{{ $user->email }}"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username: </label>
                            <input name="username" type="text"
                                class="form-control @error('username') is-invalid @enderror" value="{{ $user->username }}">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">คำนำหน้า: </label>
                            <select name="prefix" class="form-select @error('prefix') is-invalid @enderror">
                                <option disabled selected>เลือกคำนำหน้า</option>
                                <option value="นาย" {{ $user->prefix == 'นาย' ? 'selected' : '' }}>นาย</option>
                                <option value="นาง" {{ $user->prefix == 'นาง' ? 'selected' : '' }}>นาง</option>
                                <option value="นางสาว" {{ $user->prefix == 'นางสาว' ? 'selected' : '' }}>นางสาว</option>
                            </select>
                            @error('prefix')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">ชื่อ: </label>
                            <input name="first_name" type="text"
                                class="form-control @error('first_name') is-invalid @enderror"
                                value="{{ $user->first_name }}">
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">นามสกุล: </label>
                            <input name="last_name" type="text"
                                class="form-control @error('last_name') is-invalid @enderror"
                                value="{{ $user->last_name }}">
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">ชื่อบริษัท: </label>
                            <input name="company_name" type="text"
                                class="form-control @error('company_name') is-invalid @enderror"
                                value="{{ $user->company_name }}">
                            @error('company_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">ที่อยู่: </label>
                            <input name="address" type="text" class="form-control @error('address') is-invalid @enderror"
                                value="{{ $user->address }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">ซอย/ถนน: </label>
                            <input name="street" type="text" class="form-control @error('street') is-invalid @enderror"
                                value="{{ $user->street }}">
                            @error('street')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">ตำบล/แขวง: </label>
                            <input name="sub_district" type="text"
                                class="form-control @error('sub_district') is-invalid @enderror"
                                value="{{ $user->sub_district }}">
                            @error('sub_district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">อำเภอ/เขต: </label>
                            <input name="district" type="text"
                                class="form-control @error('district') is-invalid @enderror"
                                value="{{ $user->district }}">
                            @error('district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">จังหวัด: </label>
                            <input name="province" type="text"
                                class="form-control @error('province') is-invalid @enderror"
                                value="{{ $user->province }}">
                            @error('province')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">รหัสไปรษณีย์: </label>
                            <input name="postal_code" type="text"
                                class="form-control @error('postal_code') is-invalid @enderror"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="5"
                                value="{{ $user->postal_code }}">
                            @error('postal_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">เบอร์โทรศัพท์: </label>
                            <input name="phone" type="text"
                                class="form-control @error('phone') is-invalid @enderror"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="10"
                                value="{{ $user->phone }}">
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
