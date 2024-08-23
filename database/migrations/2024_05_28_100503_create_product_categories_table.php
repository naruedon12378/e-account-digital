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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("company_id");
            $table->unsignedBigInteger("product_type_id");
            $table->string("code")->nullable();
            $table->string("name_th");
            $table->string("name_en")->nullable();
            $table->text("description")->nullable();
            $table->enum("cost_calculation_type", ['average','fifo'])->nullable()->default('average')->comment('ประเภทในการคำนวนต้นทุน');
            $table->boolean("is_active")->default(true);
            $table->timestamps();
            $table->unique(['name_th', 'company_id']);
            // $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            // $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
