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
        Schema::create('inventory_lot_adjustments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('inventory_lot_id')->default(0);
            $table->unsignedBigInteger('user_creator_id');
            $table->unsignedBigInteger('user_approver_id')->nullable();
            $table->text('remark');
            $table->enum('status', ['pending', 'approve', 'cancel'])->default('pending');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('user_creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('inventory_lot_id')->references('id')->on('inventory_lots')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('inventory_lot_adjustments');
    }
};
