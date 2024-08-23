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
        Schema::create('product_component_sets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            // $table->unsignedBigInteger('product_parent_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->double('amount')->default(0);
            $table->string('description')->nullable();
            $table->boolean('show_parent_price')->default(true);
            $table->boolean('show_child_price')->default(true);
            $table->boolean('is_active')->default(false);
            $table->unsignedBigInteger("user_creator_id");
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            // $table->foreign('product_parent_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_component_sets');
    }
};
