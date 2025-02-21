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
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- thai font -->

    <style>
        @font-face {
            font-family: 'THSarabunNew';
            src: url('{{ public_path('fonts/THSarabunNew.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'THSarabunNew';
            src: url('{{ public_path('fonts/THSarabunNew-Bold.ttf') }}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }


        body {

            font-family: 'Sarabun', sans-serif !important;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
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



        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }

        .pdf-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .pdf-header img {
            height: 50px;
        }

        .pdf-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Grid System */
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .col-12 {
            width: 100%;
        }

        .col-md-6 {
            width: 48%;
            margin-right: 2%;
        }

        .col-md-6:last-child {
            margin-right: 0;
        }

        .col-md-4 {
            width: 31%;
            margin-right: 3.5%;
        }

        .col-md-4:last-child {
            margin-right: 0;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 10px;
        }

        .form-label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        /* Section Titles */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #007bff;
            margin-top: 15px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        /* Image Gallery */
        .image-group {
            margin-top: 10px;
        }

        .image-gallery img {
            max-width: 100px;
            height: auto;
            margin-right: 5px;
            border: 1px solid #ddd;
            padding: 3px;
            background-color: #fff;
        }






        /* Page Layout */
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


    <div class="form-container">
        <!-- ✅ ชื่อโปรเจกต์ -->
        <div class="form-group full-width">
            <label class="form-label">ชื่อโปรเจกต์:</label>
            <input type="text" class="form-control" value="{{ $data->project_name }}">
        </div>

        <div class="form-row">
            <!-- ✅ ประเภทงาน -->
            <div class="form-group">
                <label class="form-label">ประเภทงาน:</label>
                <input type="text" class="form-control" value="{{ $data->work_type }}">
            </div>

            <!-- ✅ Solution -->
            <div class="form-group">
                <label class="form-label">Solution:</label>
                <input type="text" class="form-control" value="{{ $data->solution }}">
            </div>
        </div>

        <!-- ✅ คำอธิบายงาน -->
        <div class="form-group full-width">
            <label class="form-label">คำอธิบายงาน:</label>
            <input type="text" class="form-control" value="{{ $data->work_description }}">
        </div>

        <div class="form-row">
            <!-- ✅ วันที่นัดหมาย -->
            <div class="form-group">
                <label class="form-label">วันที่นัดหมาย:</label>
                <input type="date" class="form-control" value="{{ $data->meeting_date }}">
            </div>

            <!-- ✅ เวลานัดหมาย -->
            <div class="form-group">
                <label class="form-label">เวลานัดหมาย:</label>
                <input type="time" class="form-control" value="{{ $data->meeting_time }}">
            </div>

            <!-- ✅ วันที่สิ้นสุดงาน -->
            <div class="form-group">
                <label class="form-label">วันที่สิ้นสุดงาน:</label>
                <input type="date" class="form-control" value="{{ $data->end_date }}">
            </div>
        </div>

        <!-- ✅ หัวข้อข้อมูลลูกค้า -->
        <h2 class="section-title">ข้อมูลลูกค้า</h2>

        <div class="form-group full-width">
            <label class="form-label">ชื่อบริษัท/นิติบุคคล:</label>
            <input type="text" class="form-control" value="{{ $data->company_name }}">
        </div>

        <div class="form-row">
            <!-- ✅ ชื่อผู้ติดต่อ -->
            <div class="form-group">
                <label class="form-label">ชื่อผู้ติดต่อ:</label>
                <input type="text" class="form-control" value="{{ $data->contact_name }}">
            </div>

            <!-- ✅ เบอร์ติดต่อ -->
            <div class="form-group">
                <label class="form-label">เบอร์ติดต่อ:</label>
                <input type="text" class="form-control" value="{{ $data->contact_phone }}">
            </div>
        </div>

        <div class="form-group full-width">
            <label class="form-label">ตำแหน่งของผู้ติดต่อ:</label>
            <input type="text" class="form-control" value="{{ $data->contact_position }}">
        </div>

        <div class="form-group full-width">
            <label class="form-label">พิกัด (ลิงก์จาก Google Map):</label>
            <input type="text" class="form-control" value="{{ $data->location }}">
        </div>
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
        <div class="form-control">
            {{ $data->sale_prefix . ' ' . $data->sale_first_name . ' ' . $data->sale_last_name }}
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
        <div class="form-control">{{ $data->pm_prefix . ' ' . $data->pm_first_name . ' ' . $data->pm_last_name }}
        </div>
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
