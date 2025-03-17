<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="th" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>ContractorSystem</title>
    <meta http-equiv="Content-Language" content="th" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('/assets/img/logopdf.jpg') }}" />
    {{--   <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap" rel="stylesheet">
 --}}

    <!-- thai font -->

    <style>
        @page {
            size: A4 portrait;
            margin: 2cm;
        }

        @font-face {
            font-family: 'THSarabunRegular';
            src: url('{{ storage_path('fonts/THSarabunNew.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'THSarabunBold';
            src: url('{{ storage_path('fonts/THSarabunNew-Bold.ttf') }}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        body {
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* General styles */

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
            margin-bottom: 15px;
            font-family: 'THSarabunBold', sans-serif !important;
            font-weight: bold;
            font-size: 26px;
        }

        /* Form Inputs */
        .form-group {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            /* ลบขอบออกจาก .form-group */
            border: none;
        }

        .form-label {
            font-family: 'THSarabunBold', sans-serif !important;
            font-weight: bold;
            font-size: 18px;
        }

        .form-control {
            font-size: 16px;
            width: 100%;
            padding: 5px;
            /* ลบขอบออกจาก .form-control */
            border: none;
            font-family: 'THSarabunRegular', sans-serif !important;
        }

        /* Section Headers */
        .section-title {
            font-size: 20px;
            font-family: 'THSarabunBold', sans-serif !important;
            font-weight: bold;
            color: #007bff;
            margin-top: 15px;
            border-bottom: 1px solid #007bff;

        }

        /* จัดกลุ่มรูปภาพแต่ละชุด */
        .image-group {
            margin-bottom: 20px;

        }

        .form-label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;


        }

        .img-pdf1 {
            width: 300px;
            /* Adjust image size as needed */
            height: 200px;
            /* Keep aspect ratio */
            object-fit: cover;
            border-radius: 8px;
            margin: 0px 4px 8px 4px !important;
            /* Rounded corners */
        }

        .image-br {
            margin-top: 48px !important;
        }

        .image-br-2 {
            margin-top: 32px !important;
        }

        .br-image-text-1 {
            margin-bottom: 48px !important;
        }

        .page-break {
            page-break-before: always;
        }
    </style>

</head>

<body>

    <!-- Header -->
    <div class="pdf-header"
        style="margin-top: -20px; display: flex; align-items: center; justify-content: space-between; width: 100%;">
        <img src="{{ public_path('/assets/img/logo.jpg') }}" alt="Company Logo"
            style="border: none; width: 150px; height: auto;"> <!-- ปรับขนาดรูป -->
        <div class="date-time" style="font-size: 14px; white-space: nowrap;">
            {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
        </div>
    </div>

    <!-- Title -->
    <h1 class="pdf-title" style="margin-top: -20px;">รายงานการส่งมอบงาน</h1>

    <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-top: -10px;">
        <label class="form-label">ชื่อโปรเจกต์:</label>
        <span class="form-control" style="font-weight: normal;">{{ $data->project_name }}</span>
    </div>

    <div class="form-group"
        style="display: flex; align-items: center; justify-content: space-between; white-space: nowrap; margin-top: -10px;">
        <!-- ประเภทงาน -->
        <div style="display: flex; align-items: center; gap: 5px; flex-grow: 1;">
            <label class="form-label" style="width: 120px;">ประเภทงาน:</label>
            <span class="form-control" style="font-weight: normal;">{{ $data->work_type }}</span>

            <label class="form-label" style="text-align: right;margin-left: 70px;">Solution:</label>
            <span class="form-control" style="font-weight: normal;">{{ $data->solution }}</span>
        </div>
    </div>



    <div class="form-group" style="margin-top: -10px;">
        <label class="form-label">คำอธิบายงาน:</label>
        <span class="form-control" style="font-weight: normal;">{{ $data->work_description }}</span>
    </div>

    <div class="form-group"
        style="display: flex; align-items: center; gap: 30px; white-space: nowrap; margin-top: -10px;">
        <label class="form-label">วันที่นัดหมาย:</label>
        <span class="form-control" style="font-weight: normal;">{{ $data->meeting_date }}</span>

        <label class="form-label" style="margin-left: 70px;">เวลานัดหมาย:</label>
        <span class="form-control" style="font-weight: normal;">{{ $data->meeting_time }}</span>

        <label class="form-label" style="margin-left: 70px;">วันที่สิ้นสุดงาน:</label>
        <span class="form-control" style="font-weight: normal;">{{ $data->end_date }}</span>
    </div>




    <!-- Customer Information -->
    <h2 class="section-title" style="margin-top: -10px;">ข้อมูลลูกค้า</h2>

    <div class="form-group" style="margin-top: -10px;">
        <label class="form-label">ชื่อบริษัท:</label>
        <span class="form-control" style="font-weight: normal;">{{ $data->company_name }}</span>
    </div>
    <div class="form-group"
        style="display: flex; align-items: center; justify-content: space-between; white-space: nowrap; margin-top: -10px;">
        <div style="display: flex; align-items: center; gap: 5px; flex-grow: 1;">
            <label class="form-label" style="width: 120px;">ชื่อผู้ติดต่อ:</label>
            <span class="form-control" style="font-weight: normal;">{{ $data->contact_name }}</span>

            <label class="form-label" style="text-align: right;margin-left: 225px;">เบอร์ติดต่อ:</label>
            <span class="form-control" style="font-weight: normal;">{{ $data->contact_phone }}</span>
        </div>
    </div>

    <div class="form-group" style="margin-top: -10px;">
        <label class="form-label">ตำแหน่งของผู้ติดต่อ: </label>
        <span class="form-control" style="font-weight: normal;">{{ $data->contact_position }}</span>
    </div>
    <div class="form-group" style="margin-top: -10px;">
        <label class="form-label">พิกัด (ลิงก์จาก Google Map): </label>
        <span class="form-control" style="font-weight: normal;">{{ $data->location }}</span>
    </div>

    <h2 class="section-title" style="margin-top: -10px;">รายละเอียดเพิ่มเติมเกี่ยวกับงาน</h2>
    <div class="form-group" style="margin-top: -10px;">
        <label class="form-label">การรับประกัน: </label>
        <dspan class="form-control" style="font-weight: normal;">{{ $data->warranty }}</span>
    </div>
    <div class="form-group" style="margin-top: -10px;">
        <label class="form-label">หมายเหตุ/คำแนะนำเพิ่มเติม: </label>
        <span class="form-control" style="font-weight: normal;">{{ $data->additional_notes }}</span>
    </div>
    <div class="form-group" style="margin-top: -10px;">
        <label class="form-label">ต้องการเอกสารส่งหรือไม่: </label>
        <span class="form-control" style="font-weight: normal;">{{ $data->needs_documents }}</span>
    </div>

    <!-- Job Images -->
    <h2 class="section-title" style="margin-top: -10px;">รายละเอียดผู้ดูเเล</h2>
    <div class="form-group"
        style="display: flex; align-items: center; justify-content: space-between; white-space: nowrap; margin-top: -10px;">
        <div style="display: flex; align-items: center; gap: 5px; flex-grow: 1;">
            <label class="form-label" style="width: 120px;">Sale:</label>
            <span class="form-control"
                style="font-weight: normal;">{{ $data->sale_prefix . ' ' . $data->sale_first_name . ' ' . $data->sale_last_name }}</span>

            <label class="form-label" style="text-align: right;margin-left: 195px;">เบอร์ติดต่อ:</label>
            <span class="form-control" style="font-weight: normal;">{{ $data->sale_phone }}</span>
        </div>
    </div>
    <div class="form-group"
        style="display: flex; align-items: center; justify-content: space-between; white-space: nowrap; margin-top: -10px;">
        <div style="display: flex; align-items: center; gap: 5px; flex-grow: 1;">
            <label class="form-label" style="width: 120px;">Admin:</label>
            <span class="form-control"
                style="font-weight: normal;">{{ $data->admin_prefix . ' ' . $data->admin_first_name . ' ' . $data->admin_last_name }}</span>

            <label class="form-label" style="text-align: right;margin-left: 159px;">เบอร์ติดต่อ:</label>
            <span class="form-control" style="font-weight: normal;">{{ $data->admin_phone }}</span>
        </div>
    </div>

    <div class="form-group"
        style="display: flex; align-items: center; justify-content: space-between; white-space: nowrap; margin-top: -10px;">
        <div style="display: flex; align-items: center; gap: 5px; flex-grow: 1;">
            <label class="form-label" style="width: 120px;">ผู้จัดการโครงการ:</label>
            <span class="form-control"
                style="font-weight: normal;">{{ $data->pm_prefix . ' ' . $data->pm_first_name . ' ' . $data->pm_last_name }}</span>

            <label class="form-label" style="text-align: right;margin-left: 143px;">เบอร์ติดต่อ:</label>
            <span class="form-control" style="font-weight: normal;">{{ $data->pm_phone }}</span>
        </div>
    </div>

    <div class="form-group"
        style="display: flex; align-items: center; justify-content: space-between; white-space: nowrap; margin-top: -10px;">
        <div style="display: flex; align-items: center; gap: 5px; flex-grow: 1;">
            <label class="form-label" style="width: 120px;">ผู้รับเหมา: </label>
            <span class="form-control"
                style="font-weight: normal;">{{ $data->contractor_prefix . ' ' . $data->contractor_first_name . ' ' . $data->contractor_last_name }}</span>

            <label class="form-label" style="text-align: right;margin-left: 109px;">เบอร์ติดต่อ:</label>
            <span class="form-control" style="font-weight: normal;">{{ $data->contractor_phone }}</span>
        </div>
    </div>

    @php
        $image = json_decode($data->images, true);
    @endphp

    <!-- Page Break ก่อนแสดงรูปภาพ -->
    <div class="page-break"></div>

    <h2 class="section-title">รายละเอียดรูปภาพงานที่ผู้รับเหมาส่งมอบ</h2>

    @if (!empty($image))
        @foreach ($image as $index => $item)
            <div class="image-group">
                <div class="form-label @if (count($image) == 1) br-image-text-1 @endif">


                    รายละเอียด รายการที่ {{ $loop->iteration }} :
                    {{ is_array($item['details']) ? implode(', ', $item['details']) : $item['details'] }}
                </div>
                <div class="image-gallery @if (count($item['images']) > 1) image-br @endif">

                    @if (!empty($item['images']) && is_array($item['images']))
                        @foreach ($item['images'] as $img)
                            <img src="{{ public_path('storage/uploads/' . $img) }}" alt="Uploaded Image"
                                class="img-pdf1">
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <p>ไม่มีรูปภาพ</p>
    @endif

</body>

</html>
