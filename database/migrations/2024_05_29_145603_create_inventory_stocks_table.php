<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('order_item_id');
            $table->enum('transaction', ['lot', 'adjustment', 'quotation', "beginning_balance", 'issue_requisition', 'reture_issue_stock','receipt_planning','receive_finish_stock','transfer_requistion','other']);
            $table->string('lot_number', 50);
            $table->double('add_amount')->nullable()->default(0);
            $table->double('adjust_amount')->nullable()->default(0);
            $table->double('used_amount')->nullable()->default(0);
            $table->double('remaining_amount')->default(0);
            $table->double('cost_price')->nullable();
            $table->unsignedBigInteger('user_creator_id');
            $table->text('remark')->nullable();
            $table->enum('type',['add', 'adjust', 'used'])->default('add');
            $table->string("created_by", 100)->nullable();
            $table->string("updated_by", 100)->nullable();
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');
            $table->foreign('user_creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_stocks');
    }
};
