<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('beginning_balance_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('beginning_balance_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('inventory_stock_id');
            $table->integer('line_item_no')->default(0);
            $table->string('code', 100)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('account_code', 20)->nullable();//account
            $table->string('location', 100)->nullable();
            $table->double('amount', 10, 2);//price
            $table->double('discount', 10, 2);//price
            $table->double('qty')->default(1);
            $table->double('vat_rate')->nullable();//1
            $table->double('vat_amt')->nullable();//1
            $table->double('wht_rate')->nullable();//2
            $table->double('wht_amt')->nullable();//2
            $table->double('total_price', 10, 2)->default(0);//pre_vat_amt
            $table->double('price', 10, 2)->default(0);// price - discount
            $table->text('remark')->nullable();
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->foreign('beginning_balance_id')->references('id')->on('beginning_balances')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('inventory_stock_id')->references('id')->on('inventory_stocks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beginning_balance_items');
    }
};
