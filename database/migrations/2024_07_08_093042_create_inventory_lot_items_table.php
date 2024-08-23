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
        Schema::create('inventory_lot_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_lot_id');
            $table->unsignedBigInteger('inventory_id');
            $table->unsignedBigInteger('product_id');
            $table->double('add_amount')->nullable();
            $table->double('adjust_amount')->nullable();
            $table->double('remaining_amount');
            $table->double('cost_price')->nullable();
            $table->text('remark')->nullable();
            $table->foreign('inventory_lot_id')->references('id')->on('inventory_lots')->onDelete('cascade');
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_lot_items');
    }
};
