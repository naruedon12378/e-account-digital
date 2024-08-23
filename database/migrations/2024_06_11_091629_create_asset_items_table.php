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
        Schema::create('asset_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->integer('line_item_no')->nullable();
            $table->string('depreciation_date',10)->nullable();
            $table->double('depreciation_amount')->nullable();
            $table->double('par_day_dep_amt')->nullable();
            $table->integer('period')->nullable();
            $table->integer('number_of_days')->nullable();
            $table->double('balance_amt')->nullable();
            $table->string('journal_number',40)->nullable();
            $table->string('journal_date',10)->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('asset_items');
    }
};
