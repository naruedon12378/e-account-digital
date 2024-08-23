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
        Schema::create('product_set_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_set_id');
            $table->unsignedBigInteger('product_id');
            $table->double('amount')->default(0);
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('product_set_id')->references('id')->on('product_sets')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_set_items');
    }
};
