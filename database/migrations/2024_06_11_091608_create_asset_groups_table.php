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
        Schema::create('asset_groups', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code',100);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->string('curr_code',3)->nullable();
            $table->string('name_th',255)->nullable();
            $table->string('name_en', 255)->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->string('barcode', 40)->nullable();
            $table->text('description')->nullable();
            $table->string('asset_acc_code', 20);
            $table->string('depreciation_acc_code', 20);
            $table->string('accrum_depreciation_acc_code',20);
            $table->integer('depreciation_period')->nullable();
            $table->double('salvage_amt')->nullable();
            $table->string('depreciation_policy',255)->nullable();
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
        Schema::dropIfExists('asset_groups');
    }
};
