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
            $table->string('sales_projectname')->nullable();
            $table->string('sales_worktype')->nullable();
            $table->string('sales_solution')->nullable();
            $table->string('sale_workdescription')->nullable();
            $table->date('sales_meetingdate')->nullable();
            $table->time('sales_meetingtime')->nullable();
            $table->date('sales_enddate')->nullable();
            $table->string('sales_companyname')->nullable();
            $table->string('sales_contactname')->nullable();
            $table->string('sales_contactphone', 10)->nullable();
            $table->string('sales_contactposition')->nullable();
            $table->string('sales_location')->nullable();
            $table->string('sales_warranty')->nullable();
            $table->text('sales_additionalnotes')->nullable();
            $table->string('sales_needsdocuments')->nullable();
            $table->string('status')->nullable();
            $table->string('responsible_admin')->nullable();
            $table->string('responsible_pm')->nullable();
            $table->string('responsible_contractor')->nullable();
            $table->string('tax_id')->nullable();
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