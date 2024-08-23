<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('transfer_requistion_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transfer_requistion_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('inventory_stock_id');
            $table->string('location', 100)->nullable();
            $table->double('amount', 10, 2)->nullable();
            $table->text('remark')->nullable();
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            // $table->foreign('transfer_requistion_id')->references('id')->on('transfer_requistions')->onDelete('cascade');
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            // $table->foreign('inventory_stock_id')->references('id')->on('inventory_stocks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_requistion_items');
    }
};
