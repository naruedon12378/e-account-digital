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
        Schema::create('sale_promotions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('code')->nullable();
            $table->string('name_th');
            $table->string('name_en')->nullable();
            $table->string('description')->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->enum('discount_type', ['percent','price'])->default('percent');
            $table->double('discount_price')->default(0);
            $table->double('discount_percent')->default(0);
            $table->double('discount_limit')->nullable();
            $table->boolean('is_active')->default(false);
            $table->unsignedBigInteger("user_creator_id");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_promotions');
    }
};
