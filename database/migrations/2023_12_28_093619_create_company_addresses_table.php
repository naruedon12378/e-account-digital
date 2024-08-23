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
        Schema::create('company_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('detail_th')->nullable();
            $table->string('detail_en')->nullable();
            $table->string('sub_district_th')->nullable();
            $table->string('sub_district_en')->nullable();
            $table->string('district_th')->nullable();
            $table->string('district_en')->nullable();
            $table->string('province_th')->nullable();
            $table->string('province_en')->nullable();
            $table->string('postcode')->nullable();
            $table->integer('company_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_addresses');
    }
};
