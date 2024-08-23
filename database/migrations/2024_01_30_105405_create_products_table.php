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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->enum('item_class', ['basic', 'advance']);
            $table->enum('type', ['product', 'service']);
            $table->string("code", 100)->unique();
            $table->string("name_en", 255);
            $table->string("name_th", 255);
            $table->boolean("is_barcode")->default(0);
            $table->string("barcode_symbology", 191)->nullable();
            $table->unsignedInteger("unit_id");
            $table->double("sale_price");
            $table->double("purchase_price")->nullable();
            $table->unsignedInteger("sale_tax_id")->nullable();
            $table->unsignedInteger("purchase_tax_id")->nullable();
            $table->unsignedInteger("sale_account_id")->nullable();
            $table->unsignedInteger("purchase_account_id")->nullable();
            $table->unsignedInteger("cost_account_id")->nullable();
            $table->boolean("is_cost_calculation")->default(0);
            $table->enum('cost_calculation', ['', 'FIFO'])->nullable();
            $table->double("qty")->nullable();
            $table->double("min_qty")->nullable();
            $table->text("product_details")->nullable();
            $table->boolean("is_active")->default(1);
            $table->unsignedBigInteger("company_id");
            $table->string("created_by", 100)->nullable();
            $table->string("updated_by", 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
