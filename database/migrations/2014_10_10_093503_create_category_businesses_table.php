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
        Schema::create('category_businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name_th')->nullable();
            $table->string('name_en')->nullable();
            $table->float('sort')->default(0)->comment('ลำดับ');
            $table->boolean('publish')->default(1)->comment('สถานะการเผยแพร่ (0, 1)');
            $table->unsignedBigInteger('type_business_id')->nullable()->comment('FK type_businesses');

            $table->foreign('type_business_id')->references('id')->on('type_businesses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_businesses');
    }
};
