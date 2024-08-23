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
        Schema::create('inventory_stock_adjustment_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_stock_adjustment_id');
            $table->unsignedBigInteger('inventory_id');
            $table->unsignedBigInteger('product_id');
            $table->double('add_amount')->default(0)->nullable();
            $table->double('minus_amount')->default(0)->nullable();
            $table->text('remark')->nullable();
            $table->foreign('inventory_stock_adjustment_id','stock_adjust_items_stock_adjust_id_foreign')->references('id')->on('inventory_stock_adjustments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('inventory_stock_adjustment_items');
        Schema::enableForeignKeyConstraints();
    }
};
