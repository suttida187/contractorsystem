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
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('/assets/img/icon.jpg') }}" />
    {{--   <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap" rel="stylesheet">
 --}}

    <!-- thai font -->

    <style>
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
            border: 1px solid #ccc;
            border-radius: 3px;
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
            padding-bottom: 5px;
        }

        /* จัดกลุ่มรูปภาพแต่ละชุด */
        .image-group {
            margin-bottom: 20px;
            margin-top: 24px;
        }

        /* Image Display */
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 32px;
        }

        .image-gallery img {
            width: 120px;
            /* ✅ ปรับขนาดรูปภาพ */
            height: auto;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 5px;
            object-fit: cover;
            /* ✅ ให้ภาพคงสัดส่วน */
        }


        /* Page Layout */
        .page-break {
            page-break-before: always;
        }
    </style>


</head>

<body>

    <!-- Header -->
    <div class="pdf-header">
        <img src="{{ public_path('/assets/img/logo.jpg') }}" alt="Company Logo">
        <div class="date-time">
            {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
        </div>
    </div>

    <!-- Title -->
    <h1 class="pdf-title">รายงานการส่งมอบงาน</h1>

    <!-- Project Details -->
    <div class="form-group">
        <label class="form-label">ชื่อโปรเจกต์:</label>
        <div class="form-control">{{ $data->project_name }}</div>
    </div>

    <div class="form-group">
        <label class="form-label">ประเภทงาน:</label>
        <div class="form-control">{{ $data->work_type }}</div>
    </div>

    <div class="form-group">
        <label class="form-label">Solution:</label>
        <div class="form-control">{{ $data->solution }}</div>
    </div>


    <div class="form-group">
        <label class="form-label">คำอธิบายงาน:</label>
        <div class="form-control">{{ $data->work_description }}</div>
    </div>

    <div class="form-group">
        <label class="form-label">วันที่นัดหมาย: </label>
        <div class="form-control">{{ $data->meeting_date }}</div>
    </div>

    <div class="form-group">
        <label class="form-label">เวลานัดหมาย: </label>
        <div class="form-control">{{ $data->meeting_time }}</div>
    </div>

    <div class="form-group">
        <label class="form-label">วันที่สิ้นสุดงาน: </label>
        <div class="form-control">{{ $data->end_date }}</div>

    </div>

    <!-- Customer Information -->
    <h2 class="section-title">ข้อมูลลูกค้า</h2>

    <div class="form-group">
        <label class="form-label">ชื่อบริษัท:</label>
        <div class="form-control">{{ $data->company_name }}</div>
    </div>

    <div class="form-group">
        <label class="form-label">ชื่อผู้ติดต่อ:</label>
        <div class="form-control">{{ $data->contact_name }}</div>
    </div>

    <div class="form-group">
        <label class="form-label">เบอร์ติดต่อ:</label>
        <div class="form-control">{{ $data->contact_phone }}</div>
    </div>
    <div class="form-group">
        <label class="form-label">ตำแหน่งของผู้ติดต่อ: </label>
        <div class="form-control">{{ $data->contact_position }}</div>
    </div>
    <div class="form-group">
        <label class="form-label">พิกัด (ลิงก์จาก Google Map): </label>
        <div class="form-control">{{ $data->location }}</div>
    </div>
    <h2 class="section-title">รายละเอียดเพิ่มเติมเกี่ยวกับงาน</h2>
    <div class="form-group">
        <label class="form-label">การรับประกัน: </label>
        <div class="form-control">{{ $data->warranty }}</div>
    </div>
    <div class="form-group">
        <label class="form-label">หมายเหตุ/คำแนะนำเพิ่มเติม: </label>
        <div class="form-control">{{ $data->additional_notes }}</div>
    </div>
    <div class="form-group">
        <label class="form-label">ต้องการเอกสารส่งหรือไม่: </label>
        <div class="form-control">{{ $data->needs_documents }}</div>
    </div>
    <!-- Job Images -->
    <h2 class="section-title">รายละเอียดผู้ดูเเล</h2>
    <div class="form-group">
        <label class="form-label">Sale: </label>
        <div class="form-control">{{ $data->sale_prefix . ' ' . $data->sale_first_name . ' ' . $data->sale_last_name }}
        </div>
    </div>
    <div class="form-group">
        <label class="form-label">เบอร์ติดต่อ: </label>
        <div class="form-control">{{ $data->sale_phone }}</div>
    </div>
    <div class="form-group">
        <label class="form-label">Admin: </label>
        <div class="form-control">
            {{ $data->admin_prefix . ' ' . $data->admin_first_name . ' ' . $data->admin_last_name }}
        </div>
    </div>
    <div class="form-group">
        <label class="form-label">เบอร์ติดต่อ: </label>
        <div class="form-control">{{ $data->admin_phone }}</div>
    </div>
    <div class="form-group">
        <label class="form-label">ผู้จัดการโครงการ: </label>
        <div class="form-control">{{ $data->pm_prefix . ' ' . $data->pm_first_name . ' ' . $data->pm_last_name }}</div>
    </div>
    <div class="form-group">
        <label class="form-label">เบอร์ติดต่อ: </label>
        <div class="form-control">{{ $data->pm_phone }}</div>
    </div>
    <div class="form-group">
        <label class="form-label">ผู้รับเหมา: </label>
        <div class="form-control">
            {{ $data->contractor_prefix . ' ' . $data->contractor_first_name . ' ' . $data->contractor_last_name }}
        </div>
    </div>
    <div class="form-group">
        <label class="form-label">เบอร์ติดต่อ: </label>
        <div class="form-control">
            {{ $data->contractor_phone }}</div>
    </div>

    @php
        $image = json_decode($data->images, true);
    @endphp

    <h2 class="section-title">ภาพงานที่ส่งมอบ</h2>


    @if (!empty($image))
        @foreach ($image as $item)
            <div class="image-group">
                <label class="form-label">Details: {{ $item['details'][0] }}</label>
                <div class="image-gallery">
                    @if (!empty($item['images']) && is_array($item['images']))
                        @foreach ($item['images'] as $img)
                            <img src="{{ public_path('storage/uploads/' . $img) }}" alt="Uploaded Image">
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
