<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{



// Table "receipt_planning_items" {
//   "id" integer [primary key]
//   "receipt_planning_id" "integer unsigned" [not null]
//   "product_id" "integer unsigned" [not null]
//   "inventory_stock_id" "integer unsigned" [not null]
//   "location" varchar [null]
//   "amount" double(10,2) [null]
//   "remark" text [null]
//   "created_at" datetime [not null, default: "now()"]
//   "updated_at" datetime [not null]
// }

    public function up(): void
    {
        Schema::create('receipt_planning_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receipt_planning_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('inventory_stock_id');
            $table->string('location', 100)->nullable();
            $table->double('amount', 10, 2)->nullable();
            $table->text('remark')->nullable();
            $table->softDeletes();
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            // $table->foreign('receipt_planning_id')->references('id')->on('receipt_plannings')->onDelete('cascade');
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
        Schema::dropIfExists('receipt_planning_items');
    }
};
