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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_group_id');
            $table->string('asset_number',100);
            $table->string('reference',20);
            $table->string('name_th',255);
            $table->string('name_en',255);
            $table->string('serial_number',40)->nullable();
            $table->string('location',100)->nullable();
            $table->text('description')->nullable();
            $table->string('purchase_date',10);
            $table->string('depreciation_date',10);
            $table->double('purchase_amount')->nullable();
            $table->double('depreciation_amount')->nullable();
            $table->double('accrum_depreciation_amount')->nullable();
            $table->double('booked_value')->nullable();
            $table->integer('time_in_used')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->string('asset_acc_code',20)->nullable();
            $table->string('depreciation_acc_code',20)->nullable();
            $table->string('accrum_depreciation_acc_code',20)->nullable();
            $table->integer('depreciation_period')->nullable();
            $table->double('salvage_amt')->nullable();
            $table->string('depreciation_policy',255)->nullable();
            $table->string('image',255)->nullable();
            $table->boolean("is_active")->default(1);
            $table->unsignedBigInteger("company_id");
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
        Schema::dropIfExists('assets');
    }
};
