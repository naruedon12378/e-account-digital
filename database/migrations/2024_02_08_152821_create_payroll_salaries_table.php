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
        Schema::create('payroll_salaries', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->date('issue_date')->comment('วันที่ทำรายการ');
            $table->date('due_date')->comment('กำหนดชำระ');
            $table->date('from_date')->comment('วันที่เริ่ม');
            $table->date('to_date')->comment('วันที่สิ้นสุด');
            $table->double('total')->comment('รวมเงินเดือน');
            $table->double('sum_revenue_item')->comment('รวมเงินเพิ่ม');
            $table->double('sum_deduct_item')->comment('รวมเงินหัก');
            $table->double('sum_holding_tax')->comment('ภาษีหัก ณ ที่จ่าย');
            $table->double('employee_social_security')->comment('ประกันสังคมส่วนลูกจ้าง');
            $table->double('company_social_security')->comment('ประกันสังคมส่วนนายจ้าง');
            $table->double('payable_social_security')->comment('ประกันสังคมรอนำส่ง');
            $table->double('pvd')->comment('กองทุนสำรองเลี้ยงชีพ')->default(0);
            $table->double('payable_holding_tax')->comment('ภาษีหัก ณ ที่จ่ายรอนำส่ง');
            $table->double('net_amount')->comment('เงินจ่ายสุทธิ');
            $table->integer('emp_count')->comment('จำนวนพนักงานที่รับเงิน');
            $table->unsignedBigInteger('company_id')->nullable()->comment('FK Company');
            $table->tinyInteger('status')->default(0)->comment('0=แบบร่าง, 1=รออนุมัติ, 2=รอชำระ, 3=ชำระแล้ว, 4=ถังขยะ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_salaries');
    }
};
