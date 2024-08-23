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
        Schema::create('product_sets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('code')->nullable();
            $table->string('name_th');
            $table->string('name_en')->nullable();
            $table->double('sale_price')->default(0);
            $table->string('description')->nullable();
            $table->boolean('show_set_price')->default(true);
            $table->boolean('show_item_price')->default(true);
            $table->boolean('is_active')->default(false);
            $table->unsignedBigInteger("user_creator_id");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sets');
    }
};
