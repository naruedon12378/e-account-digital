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
        Schema::create('payroll_salary_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->date('issue_date')->comment('วันที่ทำรายการ');
            $table->date('from_date')->comment('วันที่เริ่ม');
            $table->date('to_date')->comment('วันที่สิ้นสุด');
            $table->double('total')->comment('รวมเงินเดือน');
            $table->double('sum_revenue_item')->comment('รวมเงินเพิ่ม');
            $table->double('sum_deduct_item')->comment('รวมเงินหัก');
            $table->double('sum_holding_tax')->comment('ภาษีหัก ณ ที่จ่าย');
            $table->double('employee_social_security')->comment('ประกันสังคมส่วนลูกจ้าง');
            $table->double('company_social_security')->comment('ประกันสังคมส่วนนายจ้าง');

            $table->double('total_tax_base')->comment('รวมเงินรับสุทธิฐานภาษี');
            $table->double('total_sso_base')->comment('รวมเงินรับสุทธิฐานประกันสังคม');

            $table->double('net_amount')->comment('เงินจ่ายสุทธิ');
            $table->integer('emp_count')->comment('จำนวนพนักงานที่รับเงิน');
            $table->integer('payrun_count')->comment('จำนวนครั้งการจ่าย');
            $table->unsignedBigInteger('company_id')->nullable()->comment('FK Company');
            $table->tinyInteger('status')->default(1)->comment('0=ถังขยะ, 1=อนุมัติแล้ว');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_salary_summaries');
    }
};
