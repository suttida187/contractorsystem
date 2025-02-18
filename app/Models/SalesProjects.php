<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesProjects extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_name',          // ชื่อโปรเจกต์
        'work_type',             // ประเภทงาน
        'other_work_type',       // ประเภทงานอื่น ๆ
        'solution',              // Solution
        'other_solution',        // โซลูชันอื่น ๆ
        'work_description',      // คำอธิบายงาน
        'meeting_date',          // วันที่นัดหมาย
        'meeting_time',          // เวลานัดหมาย
        'end_date',              // วันที่สิ้นสุดงาน
        'company_name',          // ชื่อบริษัทลูกค้า
        'contact_name',          // ชื่อผู้ติดต่อ
        'contact_phone',         // เบอร์ติดต่อ
        'contact_position',      // ตำแหน่งผู้ติดต่อ
        'location',              // พิกัด (Google Map)
        'warranty',              // การรับประกัน
        'additional_notes',      // หมายเหตุเพิ่มเติม
        'needs_documents',       // ต้องการเอกสารหรือไม่
        'status',                // สถานะของโปรเจค
        'responsible_sale',     // sale ที่รับผิดชอบ
        'responsible_admin',     // admin ที่รับผิดชอบ
        'responsible_pm',        // pm ที่รับงาน
        'responsible_contractor', // ผู้รับเหมาที่รับผิดชอบ
    ];
}