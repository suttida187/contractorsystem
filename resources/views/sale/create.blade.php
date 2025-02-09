@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <form method="POST" action="{{ route('create-project-store') }}" style="padding:16px;">
                    @csrf
                    <div class="row">
                        <!-- ข้อมูลพื้นฐาน -->
                        <h5 class="col-12 mt-3 mb-3 text-primary"><strong>ข้อมูลรายละเอียดงาน</strong></h5>

                        <div class="mb-3">
                            <label class="form-label">ชื่อโปรเจกต์: </label>
                            <input name="project_name" type="text" value="{{ old('project_name') }}"
                                class="form-control @error('project_name') is-invalid @enderror">
                            @error('project_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">ประเภทงาน: </label>
                            <select name="work_type" id="work_typeSelect"
                                class="form-select @error('work_type') is-invalid @enderror">
                                <option disabled selected>เลือกประเภทงาน</option>
                                @foreach ($work_types as $type)
                                    <option value="{{ $type->name }}"
                                        {{ old('work_type') == $type->name ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('work_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <!-- แสดงช่องกรอกข้อมูลเมื่อเลือก "Other" -->

                            <div class="mt-2 d-none" id="otherWork_typeDiv">
                                <label class="form-label">โปรดระบุประเภทงาน:</label>
                                <input name="other_work_type" type="text" value="{{ old('other_work_type') }}"
                                    class="form-control @error('other_work_type') is-invalid @enderror">
                                @error('other_work_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Solution: </label>
                            <select name="solution" id="solutionSelect"
                                class="form-select @error('solution') is-invalid @enderror">
                                <option disabled selected>เลือก Solution</option>
                                @foreach ($solutions as $sol)
                                    <option value="{{ $sol->name }}"
                                        {{ old('solution') == $sol->name ? 'selected' : '' }}>
                                        {{ $sol->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('solution')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <!-- แสดงช่องกรอกข้อมูลเมื่อเลือก "Other" -->

                            <div class="mt-2 d-none" id="otherSolutionDiv">
                                <label class="form-label">โปรดระบุ Solution:</label>
                                <input name="other_solution" type="text" value="{{ old('other_solution') }}"
                                    class="form-control @error('other_solution') is-invalid @enderror">
                                @error('other_solution')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="mb-3">
                            <label class="form-label">คำอธิบายงาน: </label>
                            <input name="work_description" type="text" value="{{ old('work_description') }}"
                                class="form-control @error('work_description') is-invalid @enderror">
                            @error('work_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">วันที่นัดหมาย: </label>
                            <input name="meeting_date" type="date" value="{{ old('meeting_date') }}"
                                class="form-control @error('meeting_date') is-invalid @enderror">
                            @error('meeting_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">เวลานัดหมาย: </label>
                            <input name="meeting_time" type="time" value="{{ old('meeting_time') }}"
                                class="form-control @error('meeting_time') is-invalid @enderror">
                            @error('meeting_time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">วันที่สิ้นสุดงาน: </label>
                            <input name="end_date" type="date" value="{{ old('end_date') }}"
                                class="form-control @error('end_date') is-invalid @enderror">
                            @error('end_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <h5 class="col-12 mt-3 mb-3 text-primary"><strong>ข้อมูลลูกค้า</strong></h5>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">ชื่อบริษัท/นิติบุคคล: </label>
                            <input name="company_name" type="text" value="{{ old('company_name') }}"
                                class="form-control @error('company_name') is-invalid @enderror">
                            @error('company_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">ชื่อผู้ติดต่อ: </label>
                            <input name="contact_name" type="text" value="{{ old('contact_name') }}"
                                class="form-control @error('contact_name') is-invalid @enderror">
                            @error('contact_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">เบอร์ติดต่อ: </label>
                            <input name="contact_phone" type="text" value="{{ old('contact_phone') }}"
                                class="form-control @error('contact_phone') is-invalid @enderror" maxlength="10"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                            @error('contact_phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ตำแหน่งของผู้ติดต่อ: </label>
                            <input name="contact_position" type="text" value="{{ old('contact_position') }}"
                                class="form-control @error('contact_position') is-invalid @enderror">
                            @error('contact_position')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">พิกัด (ลิงก์จาก Google Map): </label>
                            <input name="location" type="url" value="{{ old('location') }}"
                                class="form-control @error('location') is-invalid @enderror">
                            @error('location')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <h5 class="col-12 mt-3 mb-3 text-primary"><strong>รายละเอียดเพิ่มเติมเกี่ยวกับงาน</strong></h5>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">การรับประกัน: </label>
                            <select name="warranty" class="form-select @error('warranty') is-invalid @enderror">
                                <option disabled selected>
                                    เลือกการรับประกัน</option>
                                @foreach ($warranty_options as $option)
                                    <option value="{{ $option->name }}"
                                        {{ old('warranty') == $option->name ? 'selected' : '' }}>
                                        {{ $option->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('warranty')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">หมายเหตุ/คำแนะนำเพิ่มเติม: </label>
                            <textarea name="additional_notes" class="form-control @error('additional_notes') is-invalid @enderror">{{ old('additional_notes') }}</textarea>
                            @error('additional_notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ต้องการเอกสารส่งหรือไม่: </label>
                            <select name="needs_documents"
                                class="form-select @error('needs_documents') is-invalid @enderror">
                                <option disabled selected>เลือก</option>
                                <option value="ต้องการ" {{ old('needs_documents') == 'ต้องการ' ? 'selected' : '' }}>
                                    ต้องการ</option>
                                <option value="ไม่ต้องการ" {{ old('needs_documents') == 'ไม่ต้องการ' ? 'selected' : '' }}>
                                    ไม่ต้องการ</option>
                            </select>
                            @error('needs_documents')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end">
                        <button wire:navigate href="/sale-list-project" class="btn btn-secondary">ย้อนกลับ</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var solutionSelect = document.getElementById("solutionSelect");
            var workTypeSelect = document.getElementById("work_typeSelect");

            var otherSolutionDiv = document.getElementById("otherSolutionDiv");
            var otherWorkTypeDiv = document.getElementById("otherWork_typeDiv");

            // เช็คค่าที่ถูกเลือกตอนโหลดหน้า (ถ้ามี "Other" ให้แสดง input)
            if (solutionSelect.value === "Other") {
                otherSolutionDiv.classList.remove("d-none");
            }

            if (workTypeSelect.value === "Other") {
                otherWorkTypeDiv.classList.remove("d-none");
            }

            // Event Listener เมื่อเปลี่ยนค่า
            solutionSelect.addEventListener("change", function() {
                if (this.value === "Other") {
                    otherSolutionDiv.classList.remove("d-none");
                } else {
                    otherSolutionDiv.classList.add("d-none");
                }
            });

            workTypeSelect.addEventListener("change", function() {
                if (this.value === "Other") {
                    otherWorkTypeDiv.classList.remove("d-none");
                } else {
                    otherWorkTypeDiv.classList.add("d-none");
                }
            });
        });
    </script>
@endsection
