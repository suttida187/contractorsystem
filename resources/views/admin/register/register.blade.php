@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <form wire:submit.prevent="save" style="padding:16px;">
                    <div class="row">
                        <!-- ส่วนที่ 1: ข้อมูลพื้นฐาน -->
                        <h5 class="col-12 mt-3 mb-3 text-primary"><strong>ข้อมูลส่วนบุคคล</strong></h5>
                        <div class="mb-3">
                            <label class="form-label">เลือกประเภท: </label>
                            <select wire:model="role" class="form-select @error('role') is-invalid @enderror">
                                <option value="" disabled selected>กรุณาเลือกประเภท</option>
                                <option value="admin">admin</option>
                                <option value="sale">sale</option>
                                <option value="pm">pm</option>
                            </select>
                            @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email: </label>
                            <input wire:model="email" type="email"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username: </label>
                            <input wire:model="username" type="text"
                                class="form-control @error('username') is-invalid @enderror">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password: </label>
                            <input wire:model="password" type="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm-Password: </label>
                            <input wire:model="password_confirmation" type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">คำนำหน้า: </label>
                            <select wire:model="prefix" class="form-select @error('prefix') is-invalid @enderror">
                                <option value="" disabled selected>เลือกคำนำหน้า</option>
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                            </select>
                            @error('prefix')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">ชื่อ: </label>
                            <input wire:model="first_name" type="text"
                                class="form-control @error('first_name') is-invalid @enderror">
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">นามสกุล: </label>
                            <input wire:model="last_name" type="text"
                                class="form-control @error('last_name') is-invalid @enderror">
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <h5 class="col-12 mt-3 mb-3 text-primary"><strong>ข้อมูลเกี่ยวกับบริษัท</strong></h5>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">ชื่อบริษัท: </label>
                            <input wire:model="company_name" type="text"
                                class="form-control @error('company_name') is-invalid @enderror">
                            @error('company_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ที่อยู่: </label>
                            <input wire:model="address" type="text"
                                class="form-control @error('address') is-invalid @enderror">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">ซอย/ถนน: </label>
                            <input wire:model="street" type="text"
                                class="form-control @error('street') is-invalid @enderror">
                            @error('street')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">ตำบล/แขวง: </label>
                            <input wire:model="sub_district" type="text"
                                class="form-control @error('sub_district') is-invalid @enderror">
                            @error('sub_district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">อำเภอ/เขต: </label>
                            <input wire:model="district" type="text"
                                class="form-control @error('district') is-invalid @enderror">
                            @error('district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">จังหวัด: </label>
                            <input wire:model="province" type="text"
                                class="form-control @error('province') is-invalid @enderror">
                            @error('province')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">รหัสไปรษณีย์: </label>
                            <input wire:model="postal_code" type="text"
                                class="form-control @error('postal_code') is-invalid @enderror"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="5">
                            @error('postal_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">เบอร์โทรศัพท์: </label>
                            <input wire:model="phone" type="text"
                                class="form-control @error('phone') is-invalid @enderror"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="10">
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
