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
        Schema::create('expense_record_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_record_id');
            $table->integer('line_item_no');
            $table->string('code', 100);
            $table->string('name', 255);
            $table->string('account_code', 20);
            $table->double('qty')->default(1);
            $table->double('price')->default(0);
            $table->double('vat_rate')->nullable();
            $table->double('vat_amt')->nullable();
            $table->double('wht_rate')->nullable();
            $table->double('wht_amt')->nullable();
            $table->double('pre_vat_amt')->default(0);
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_record_items');
    }
};
