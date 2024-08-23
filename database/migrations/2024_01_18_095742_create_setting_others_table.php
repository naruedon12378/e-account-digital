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
        Schema::create('setting_others', function (Blueprint $table) {
            $table->id();
            $table->boolean('status_signature')->default(1)->comment('ลายเซ็น (0, 1)');
            $table->boolean('status_company_seal')->default(1)->comment('ตราประทับองค์กร (0, 1)');
            $table->boolean('status_doc_access_code')->default(0)->comment('รหัสเข้าเอกสาร (0, 1)');
            $table->boolean('status_issue_invoice')->default(2)->comment('ค่าเริ่มต้นการออกใบแจ้งหนี้ (0, 1, 2)');
            $table->boolean('status_issue_receipt')->default(1)->comment('ค่าเริ่มต้นการออกใบเสร็จรับเงิน (0, 1, 2)');
            $table->boolean('status_tax_invoice_no_vat')->default(0)->comment('สร้างใบกำกับภาษีโดยที่ไม่มีภาษีมูลค่าเพิ่ม (0, 1)');
            $table->boolean('status_pp_30_not_tax_invoice')->default(0)->comment('เอกสารที่ไม่ใช่ใบกำกับภาษี (0, 1, 2)');
            $table->boolean('status_pp_30_sale_submit')->default(1)->comment('เอกสารที่ใช้ยื่นยอดขาย (0, 1, 2)');
            $table->boolean('status_link_document')->default(1)->comment('ลิงก์เข้าเอกสารที่หน้า (0, 1)');
            $table->unsignedBigInteger('company_id')->nullable()->comment('FK companies');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_others');
    }
};
