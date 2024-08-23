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
        Schema::create('inventory_lot_adjustment_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_lot_adjustment_id');
            $table->unsignedBigInteger('inventory_lot_item_id');
            $table->unsignedBigInteger('product_id');
            $table->double('add_amount')->nullable();
            $table->double('minus_amount')->nullable();
            $table->double('cost_price')->nullable();
            $table->text('remark')->nullable();
            $table->foreign('inventory_lot_adjustment_id','lot_adjustment_lot_adjustment_id_foreign')->references('id')->on('inventory_lot_adjustments')->onDelete('cascade');
            $table->foreign('inventory_lot_item_id')->references('id')->on('inventory_lot_items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_adjustment_items');
    }
};
