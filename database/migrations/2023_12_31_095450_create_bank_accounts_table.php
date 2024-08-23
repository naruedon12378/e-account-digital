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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_code')->nullable()->comment('รหัสบัญชี');
            $table->integer('advance_type')->nullable()->default(1)->comment('1 => พื้นฐาน. 2 => ขั้นสูง');
            $table->integer('financial_type')->nullable()->comment('1 => เงินสด, 2 => ธนาคาร, 3 => สำรองจ่าย ');
            $table->integer('account_type')->nullable()->comment('ประเภทบัญชี 1 => กระแสรายวัน, 2 => ออมทรัพย์, 3 => ฝากประจำ');
            $table->string('account_name')->nullable()->comment('ชื่อบัญชีธนาคาร, ชื่อช่องทางเงินสด, ชื่อผู้ที่สำรองจ่าย');
            $table->string('account_number')->nullable()->comment('หมายเลขบัญชี');
            $table->string('branch_name')->nullable()->comment('ชื่อสาขา');
            $table->string('branch_code')->nullable()->comment('หมายเลขสาขา');
            $table->integer('service_provider_type')->nullable()->comment('รูปแบบผู้ให้บริการ 1 => รับชำระ, 2 => e-Commerce');
            $table->integer('service_provider_id')->nullable()->comment('ผู้ให้บริการ (รอ payment gateway แล้วขึ้น Table ใหม่มา relation)');
            $table->string('remark')->nullable()->comment('คำอธิบายอื่นๆ');
            $table->integer('income_status')->nullable()->comment('สถานะใช้รับเงิน');
            $table->integer('expense_status')->nullable()->comment('สถานะใช้จ่ายเงิน');
            $table->integer('pay_check_status')->nullable()->comment('สถานะใช้บัญชีเช็ค');
            $table->unsignedBigInteger('bank_id')->nullable()->comment('FK banks');
            $table->unsignedBigInteger('chart_account_id')->nullable()->comment('FK chart_of_account');
            $table->unsignedBigInteger('company_id')->nullable()->comment('FK companies');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('chart_account_id')->references('id')->on('chart_of_accounts')->onDelete('cascade');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
