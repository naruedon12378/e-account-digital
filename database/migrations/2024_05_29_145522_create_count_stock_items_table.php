<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('count_stock_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('count_stock_id');
            $table->unsignedBigInteger('product_id');
            $table->string('product_name', 100);
            $table->unsignedBigInteger('branch_id');
            $table->string('location', 100);
            $table->double('stock_amount', 15, 2)->default(0);
            $table->double('count_amount', 15, 2)->default(0);
            $table->boolean('is_check')->default(0);
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->foreign('count_stock_id')->references('id')->on('count_stocks')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('count_stock_items');
    }
};
