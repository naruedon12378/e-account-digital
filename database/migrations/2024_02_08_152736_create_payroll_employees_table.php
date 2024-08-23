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
        Schema::create('payroll_employees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('company_id')->nullable()->comment('FK Company');
            $table->boolean('record_status')->default(1)->comment('soft delete (0, 1)');
            $table->string('type_form')->nullable()->comment('ชนิดของฟอร์ม');

            // General
            $table->string('profie_img')->nullable()->comment('โปรไฟล์');
            $table->string('citizen_no')->nullable()->comment('บัตรประชาชน');
            $table->string('citizen_file')->nullable()->comment('ไฟล์บัตรประชาชน');
            $table->date('start_date')->nullable()->comment('วันเริ่มงาน');
            $table->unsignedBigInteger('prefix_id')->nullable()->comment('คำนำหน้า FK');
            $table->string('first_name_th')->nullable()->comment('ชื่อ (ภาษาไทย)');
            $table->string('mid_name_th')->nullable()->comment('ชื่อกลาง (ภาษาไทย)');
            $table->string('last_name_th')->nullable()->comment('นามสกุล (ภาษาไทย)');
            $table->string('first_name_en')->nullable()->comment('ชื่อ (ภาษาอังกฤษ)');
            $table->string('mid_name_en')->nullable()->comment('ชื่อกลาง (ภาษาอังกฤษ)');
            $table->string('last_name_en')->nullable()->comment('นามสกุล (ภาษาอังกฤษ)');
            $table->unsignedBigInteger('department_id')->nullable()->comment('แผนก FK');
            $table->tinyInteger('contract_type')->nullable()->comment('1=รายเดือน , 2=รายวัน');
            $table->string('position')->nullable()->comment('ตำแหน่ง');

            // Contact
            $table->string('email')->nullable()->comment('อีเมล');
            $table->string('phone')->nullable()->comment('เบอร์โทร');
            $table->string('urgent_name')->nullable()->comment('ผู้ติดต่อ (กรณีฉุกเฉิน)');
            $table->string('urgent_phone')->nullable()->comment('เบอร์โทร (กรณีฉุกเฉิน)');

            // Address
            $table->string('address')->nullable()->comment('ที่อยู่');
            $table->string('sub_district')->nullable()->comment('แขวง/ตำบล');
            $table->string('district')->nullable()->comment('เขต/อำเภอ');
            $table->string('province')->nullable()->comment('จังหวัด');
            $table->string('zipcode')->nullable()->comment('รหัสไปรษณีย์');

            // Salary
            $table->integer('salary')->default(0)->comment('เงินเดือน');
            $table->unsignedBigInteger('account_id')->nullable()->comment('บัญชี FK');
            $table->tinyInteger('scc_chkbox')->default(1)->comment('ขึ้นทะเบียนประกันสังคม 0=ไม่,1=ใช่');
            $table->tinyInteger('tax_holding_chkbox')->default(1)->comment('หัก ณ ที่จ่าย 0=ไม่,1=ใช่');
            $table->float('tax_holding')->nullable()->comment('หัก ณ ที่จ่าย');
            $table->integer('pnd_type')->nullable()->comment('ชนิดของ ภงด ที่หัก ณ ที่จ่าย 1=ภงด.1');

            // Salary Payment
            $table->string('payment_channel')->nullable()->comment('ช่องทางจ่ายเงินเดือน');
            $table->unsignedBigInteger('bank_id')->nullable()->comment('ธนาคาร FK');
            $table->integer('account_type')->nullable()->comment('ประเภทบัญชี 1 => กระแสรายวัน, 2 => ออมทรัพย์, 3 => ฝากประจำ');
            $table->string('account_name')->nullable()->comment('ชื่อบัญชีธนาคาร, ชื่อช่องทางเงินสด, ชื่อผู้ที่สำรองจ่าย');
            $table->string('account_number')->nullable()->comment('หมายเลขบัญชี');
            $table->string('branch_name')->nullable()->comment('ชื่อสาขา');
            $table->string('branch_code')->nullable()->comment('หมายเลขสาขา');
            $table->string('promptpay_type')->nullable()->comment('ประเภทของพร้อมเพย์');
            $table->string('promptpay_number')->nullable()->comment('หมายเลขพร้อมเพย์');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_employees');
    }
};
