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
        Schema::create('setting_doc_types', function (Blueprint $table) {
            $table->id();
            $table->string('header')->comment('ตัวอักษรเริ่มต้น');
            $table->string('special_characters')->default('-')->comment('ตัวอักษรพิเศษ');
            $table->integer('year_type')->default(1)->comment('1= เลขสี่หลัก ปี ค.ศ., 2 = เลขสี่หลัก ปี พ.ศ., 3 = เลขสองหลัก ปี ค.ศ., 4 = เลขสองหลัก ปี พ.ศ., 5 = ไม่ต้องแสดงปี');
            $table->integer('month_type')->default(1)->comment('1= แสดงเดือน, 2 = ไม่แสดง');
            $table->integer('date_type')->default(1)->comment('1= แสดงเดือน, 2 = ไม่แสดง');
            $table->integer('length_number_doc')->default(5)->comment('2,3,4,5,6,7,8,9');
            $table->integer('doc_type')->comment(
                '-
                    1=ใบเสนอราคา,
                    2=ใบส่งของชั่วคราว,
                    3=ใบแจ้งหนี้,
                    4=ใบแจ้งหนี้/ใบกำกับภาษี,
                    5=ใบส่่งของ,
                    6=ใบเสร็จรับเงิน,
                    7=ใบเสร็จรับเงิน/ใบกำกับภาษี,
                    8=ใบกำกับภาษีขาย,
                    9=ใบลดหนี้,
                    10=ใบลดหนี้/ใบกำกับภาษี,
                    11=ใบวางบิล,
                    12=ใบเพิ่มหนี้,
                    13=ใบเพิ่มหนี้/ใบกำกับภาษี,
                    14=ใบสั่งซื้อ,
                    15=ใบสั่งซื้อสินทรัพย์,
                    16=ใบขอซื้อ,
                    17=ค่าใช้จ่าย,
                    18=รับใบลดหนี้,
                    19=ใบรวมจ่าย,
                    20=ซื้อสินทรัพย์
                '
            );
            $table->integer('account_type')->comment('1=เอกสารรายรับ,2=เอกสารรายจ่าย');
            $table->string('remark')->comment('หมายเหตุเอกสาร')->nullable();
            $table->boolean('company_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_doc_types');
    }
};
