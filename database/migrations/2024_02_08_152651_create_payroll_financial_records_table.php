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
        Schema::create('payroll_financial_records', function (Blueprint $table) {
            $table->id();
            // $table->string('code')->nullable()->comment('เลขที่เงินได้/เงินหัก');
            $table->string('name_th')->nullable()->comment('ชื่อรายการเงินได้/เงินหัก (ภาษาไทย)');
            $table->string('name_en')->nullable()->comment('ชื่อรายการเงินได้/เงินหัก (ภาษาอังกฤษ)');
            $table->boolean('publish')->default(1)->comment('สถานะการเผยแพร่ (0, 1)');
            $table->boolean('record_status')->default(1)->comment('soft delete (0, 1)');
            $table->boolean('type_form')->default(1)->comment('1=basic,2=advance');

            $table->boolean('type_account')->default(0)->comment('ประเภทบัญชี, เงินได้ => 0, เงินหัก => 1');
            $table->boolean('type')->default(0)->comment('ประเภทรายการเงินได้/เงินหัก, ไม่ประจำ => 0, ประจำ => 1');
            $table->boolean('annual_revenue')->default(0)->comment('คำนวณเงินได้ทั้งปี, ไม่รวมรายการนี้ => 0, รวมคำนวณรายการนี้ => 1');
            $table->boolean('ssc_base_salary')->default(0)->comment('คำนวณฐานประกันสังคม, ไม่รวมรายการนี้ => 0, รวมคำนวณรายการนี้ => 1');

            $table->unsignedBigInteger('account_id')->nullable()->comment('FK Account');
            $table->unsignedBigInteger('company_id')->nullable()->comment('FK Company');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_financial_categories');
    }
};
