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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name_th')->nullable()->comment('หัวข้อบทความภาษาไทย');
            $table->string('name_en')->nullable()->comment('หัวข้อบทความภาษาอังกฤษ');
            $table->string('slug')->nullable()->comment('slug');
            $table->text('sub_detail_th')->nullable()->comment('รายละเอียดย่อยภาษาไทย');
            $table->text('sub_detail_en')->nullable()->comment('รายละเอียดย่อยภาษาอังกฤษ');
            $table->longText('detail_th')->nullable()->comment('รายละเอียดภาษาไทย');
            $table->longText('detail_en')->nullable()->comment('รายละเอียดภาษาอังกฤษ');
            $table->text('seo_keyword')->nullable()->comment('Seo Keyword');
            $table->text('seo_description')->nullable()->comment('Seo Description');
            $table->string('date')->nullable()->comment('วันที่เผยแพร่บทความ');
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
        Schema::dropIfExists('articles');
    }
};
