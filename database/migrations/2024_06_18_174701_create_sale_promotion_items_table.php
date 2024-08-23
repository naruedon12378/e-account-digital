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
        Schema::create('sale_promotion_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_promotion_id');
            $table->unsignedBigInteger('product_id');
            $table->double('amount')->default(0);
            $table->enum('condition_key',['equal','greater_than','greater_than_or_equal',])->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->foreign('sale_promotion_id')->references('id')->on('sale_promotions')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_promotion_items');
    }
};
