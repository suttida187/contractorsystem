<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name')->nullable()->comment('ชื่อโปรเจค');
            $table->string('work_type')->nullable()->comment('ประเภทงาน');
            $table->string('other_work_type')->nullable()->comment('ประเภทงานอื่น ๆ');
            $table->string('solution')->nullable()->comment('โซลูชันที่นำเสนอ');
            $table->string('other_solution')->nullable()->comment('โซลูชันอื่น ๆ');
            $table->string('work_description')->nullable()->comment('รายละเอียดงาน');
            $table->date('meeting_date')->nullable()->comment('วันที่นัดประชุม');
            $table->time('meeting_time')->nullable()->comment('เวลานัดประชุม');
            $table->date('end_date')->nullable()->comment('วันที่สิ้นสุดงาน');
            $table->string('company_name')->nullable()->comment('ชื่อบริษัทลูกค้า');
            $table->string('contact_name')->nullable()->comment('ชื่อผู้ติดต่อ');
            $table->string('contact_phone', 10)->nullable()->comment('เบอร์โทรผู้ติดต่อ');
            $table->string('contact_position')->nullable()->comment('ตำแหน่งของผู้ติดต่อ');
            $table->text('location')->nullable()->comment('สถานที่ปฏิบัติงาน');
            $table->string('warranty')->nullable()->comment('รายละเอียดการรับประกัน');
            $table->text('additional_notes')->nullable()->comment('หมายเหตุเพิ่มเติมจากแอดมิน');
            $table->string('needs_documents')->nullable()->comment('เอกสารที่ต้องใช้');
            $table->string('status')->nullable()->comment('สถานะของโปรเจค');
            $table->string('responsible_admin')->nullable()->comment('แอดมินที่รับผิดชอบ');
            $table->string('responsible_pm')->nullable()->comment('ผู้จัดการโครงการที่รับผิดชอบ');
            $table->string('responsible_contractor')->nullable()->comment('ผู้รับเหมาที่รับผิดชอบ');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_projects');
    }
};