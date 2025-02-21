<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>ContractorSystem</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ URL::asset('/assets/img/icon.jpg') }}" type="image/x-icon" />

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="th" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


    <meta http-equiv="Content-Language" content="th" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('/assets/img/icons/icon-2.png') }}" />

    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Date dd/mm/yyyy -->
    <style>
        /* General styles */


        body {
            font-family: 'Sarabun', sans-serif;
            line-height: 1;


        }

        /* Header */
        .pdf-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .pdf-header img {
            width: 100px;
            /* Adjust the logo size */
        }

        .pdf-header .date-time {
            font-size: 12px;
            text-align: right;
        }

        /* Title */
        .pdf-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* Form Inputs */
        .form-group {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Section Headers */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #007bff;
            margin-top: 15px;
            border-bottom: 1px solid #007bff;
            padding-bottom: 5px;
        }

        /* Image Display */
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .image-gallery img {
            width: 120px;
            /* Adjust image size */
            height: auto;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 5px;
        }

        /* Page Layout */
        .page-break {
            page-break-before: always;
        }
    </style>


</head>

<body>
    <div class="pdf-body">
        <div class="row">

            <!-- Header -->
            <div class="pdf-header">
                <img src="{{ public_path('/assets/img/logo.jpg') }}" alt="Company Logo">
                <div class="date-time">
                    {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
                </div>
            </div>


            <h1 class="pdf-title">รายงานการส่งมอบงาน</h1>
            <div class="mb-3" hidden>
                <label class="form-label">โปรเจกต์ id: </label>
                <input name="project_id" type="text" id="project_id" class="form-control no-edit">
            </div>
            <div class="mb-3">
                <label class="form-label">ชื่อโปรเจกต์: </label>
                <input name="project_name" type="text" id="project_name" value="{{ $data->project_name }}"
                    class="form-control no-edit">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">ประเภทงาน: </label>
                <input name="work_type" type="text" id="work_type" value="{{ $data->work_type }}"
                    class="form-control no-edit">

                <!-- แสดงช่องกรอกข้อมูลเมื่อเลือก "Other" -->

                <div class="mt-2 d-none" id="otherWork_typeDiv">
                    <label class="form-label">โปรดระบุประเภทงาน:</label>
                    <input name="other_work_type" type="text" id="other_work_type"
                        value="{{ $data->other_work_type }}" class="form-control no-edit">
                </div>
            </div>

            <div class="col-md-6
                        mb-3">
                <label class="form-label">Solution: </label>
                <input name="solution" type="text" id="solution" value="{{ $data->solution }}"
                    class="form-control no-edit">
                <!-- แสดงช่องกรอกข้อมูลเมื่อเลือก "Other" -->
                <div class="mt-2 d-none" id="otherSolutionDiv">
                    <label class="form-label">โปรดระบุ Solution:</label>
                    <input name="other_solution" type="text" id="other_solution" value="{{ $data->other_solution }}"
                        class="form-control no-edit">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">คำอธิบายงาน: </label>
                <input name="work_description" type="text" id="work_description"
                    value="{{ $data->work_description }}" class="form-control no-edit">

            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">วันที่นัดหมาย: </label>
                <input name="meeting_date" type="date" id="meeting_date" value="{{ $data->meeting_date }}"
                    class="form-control no-edit">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">เวลานัดหมาย: </label>
                <input name="meeting_time" type="time" id="meeting_time" value="{{ $data->meeting_time }}"
                    class="form-control no-edit">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">วันที่สิ้นสุดงาน: </label>
                <input name="end_date" type="date" id="end_date" value="{{ $data->end_date }}"
                    class="form-control no-edit">
            </div>
        </div>

        <h5 class="col-12 mt-3 mb-3 text-primary"><strong>ข้อมูลลูกค้า</strong></h5>
        <div class="row">
            <div class="mb-3">
                <label class="form-label">ชื่อบริษัท/นิติบุคคล: </label>
                <input name="company_name" type="text" id="company_name" value="{{ $data->company_name }}"
                    class="form-control no-edit">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">ชื่อผู้ติดต่อ: </label>
                <input name="contact_name" type="text" id="contact_name" value="{{ $data->contact_name }}"
                    class="form-control no-edit">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">เบอร์ติดต่อ: </label>
                <input name="contact_phone" type="text" id="contact_phone" value="{{ $data->contact_phone }}"
                    class="form-control no-edit">

            </div>

            <div class="mb-3">
                <label class="form-label">ตำแหน่งของผู้ติดต่อ: </label>
                <input name="contact_position" type="text" id="contact_position"
                    value="{{ $data->contact_position }}" class="form-control no-edit">
            </div>

            <div class="mb-3">
                <label class="form-label">พิกัด (ลิงก์จาก Google Map): </label>
                <input name="location" type="url" id="location" class="form-control"
                    value="{{ $data->location }}">

            </div>

        </div>

        <h5 class="col-12 mt-3 mb-3 text-primary"><strong>รายละเอียดเพิ่มเติมเกี่ยวกับงาน</strong></h5>
        <div class="row">
            <div class="mb-3">
                <label class="form-label">การรับประกัน: </label>
                <input name="warranty" type="text" id="warranty" value="{{ $data->warranty }}"
                    class="form-control no-edit">

            </div>

            <div class="mb-3">
                <label class="form-label">หมายเหตุ/คำแนะนำเพิ่มเติม: </label>
                <textarea name="additional_notes" class="form-control no-edit" id="additional_notes">{{ $data->additional_notes }}</textarea>

            </div>

            <div class="mb-3">
                <label class="form-label">ต้องการเอกสารส่งหรือไม่: </label>
                <input name="needs_documents" type="text" value="{{ $data->needs_documents }}"
                    id="needs_documents" class="form-control no-edit">
            </div>
        </div>


        <h5 class="col-12 mt-3 mb-3 text-primary"><strong>รายละเอียดผู้ดูเเล</strong></h5>
        <div class="row">
            <div class="col-md-8 mb-3">
                <label class="form-label">Sale: </label>
                <input name="caretaker_sale" type="text" id="caretaker_sale"
                    value="{{ $data->sale_prefix . ' ' . $data->sale_first_name . ' ' . $data->sale_last_name }}"
                    class="form-control no-edit">

            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">เบอร์ติดต่อ: </label>
                <input name="caretaker_sale_phone" type="text" id="caretaker_sale_phone"
                    value="{{ $data->sale_phone }}" class="form-control no-edit">
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mb-3">
                <label class="form-label">Admin: </label>
                <input name="caretaker_admin"
                    value="{{ $data->admin_prefix . ' ' . $data->admin_first_name . ' ' . $data->admin_last_name }}"
                    type="text" id="caretaker_admin" class="form-control no-edit">

            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">เบอร์ติดต่อ: </label>
                <input name="caretaker_admin_phone" value="{{ $data->admin_phone }}" type="text"
                    id="caretaker_admin_phone" class="form-control no-edit">
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mb-3">
                <label class="form-label">ผู้จัดการโครงการ: </label>
                <input name="caretaker_pm_phone" type="text" id="caretaker_pm"
                    value="{{ $data->pm_prefix . ' ' . $data->pm_first_name . ' ' . $data->pm_last_name }}"
                    class="form-control no-edit">

            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">เบอร์ติดต่อ: </label>
                <input name="caretaker_pm_phone" type="text" value="{{ $data->pm_phone }}"
                    id="caretaker_pm_phone" class="form-control no-edit">
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mb-3">
                <label class="form-label">ผู้รับเหมา: </label>
                <input name="caretaker_contractor" type="text"
                    value="{{ $data->contractor_prefix . ' ' . $data->contractor_first_name . ' ' . $data->contractor_last_name }}"
                    id="caretaker_contractor" class="form-control no-edit">

            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">เบอร์ติดต่อ: </label>
                <input name="caretaker_contractor_phone" type="text" id="caretaker_contractor_phone"
                    value="{{ $data->contractor_phone }}" class="form-control no-edit">
            </div>
        </div>
        @php
            $image = json_decode($data->images, true);
        @endphp

        <div class="col-md-8 mb-5">
            @if (!empty($image))
                @foreach ($image as $item)
                    <div class="mb-4">
                        <p><strong>Details:</strong> {{ implode(', ', $item['details']) }}</p>

                        <div class="d-flex flex-wrap gap-2"> <!-- ✅ Make images display in a row -->
                            @if (!empty($item['images']) && is_array($item['images']))
                                @foreach ($item['images'] as $img)
                                    <img src="{{ asset('storage/uploads/' . $img) }}" alt="Image"
                                        class="img-fluid" style="width: 250px; height: auto;">
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>


</body>

</html>
