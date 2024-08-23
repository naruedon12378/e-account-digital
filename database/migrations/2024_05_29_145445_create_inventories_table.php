<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->double('amount')->nullable();
            $table->boolean('is_negative_amount')->default(false);
            $table->double('limit_min_amount')->nullable();
            $table->double('limit_max_amount')->nullable();
            $table->boolean('limit_amount_notification')->default(true)->comment('show notification if amount over limit');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive', 'onhold'])->default('onhold');
            $table->string("created_by", 100)->nullable();
            $table->string("updated_by", 100)->nullable();
            $table->unsignedBigInteger("user_creator_id");
            $table->unsignedBigInteger("user_updater_id")->nullable();
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
