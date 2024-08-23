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
        Schema::create('setting_due_dates', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type', 10)->comment(
                '
                    QO=ใบเสนอราคา,
                    IV=ใบแจ้งหนี้,
                    BN=ใบวางบิล,
                    EXP=ค่าใช้จ่าย,
                    CPN=ใบรวมจ่าย,
                    PA=ซื้อสินทรัพย์,
                '
            );
            $table->integer('format')->default(1)->comment(
                '
                    1= X วันหลังวันที่ออกเอกสาร,
                    2= วันที่ X ของเดือนถัดไป,
                    3= สิ้นเดือนของวันที่ออกเอกสาร,
                    4= สิ้นเดือนของเดือนถัดไป,
                '
            );
            $table->integer('period')->default(0);
            $table->unsignedBigInteger('company_id');
            $table->string("created_by", 100)->nullable();
            $table->string("updated_by", 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_due_dates');
    }
};
