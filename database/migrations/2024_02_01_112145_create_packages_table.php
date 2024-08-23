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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name_th')->nullable()->comment('ชื่อแพ็คเกจ');
            $table->string('name_en')->nullable()->comment('ชื่อแพ็คเกจ');
            $table->string('description_th')->nullable()->comment('รายละเอียดย่อย');
            $table->string('description_en')->nullable()->comment('รายละเอียดย่อย');
            $table->string('price')->nullable()->comment('ราคา');
            $table->string('discount')->nullable()->comment('ส่วนลด');
            $table->string('user_limit')->nullable()->comment('จำนวนผู้ใช้งานในระบบ');
            $table->string('storage_limit')->nullable()->comment('หน่วยความจำสูงสุด');
            $table->float('sort')->nullable()->comment('ลำดับ');
            $table->boolean('publish')->default(1)->comment('สถานะการเผยแพร่ (0, 1)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
