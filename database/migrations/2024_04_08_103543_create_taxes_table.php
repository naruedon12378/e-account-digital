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
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3);
            $table->string('name_en', 191);
            $table->string('name_th', 191);
            $table->boolean('is_include');
            $table->double('rate')->nullable();
            $table->unsignedInteger('input_account_id')->nullable();
            $table->unsignedInteger('output_account_id')->nullable();
            $table->unsignedInteger('paid_input_account_id')->nullable();
            $table->unsignedInteger('paid_output_account_id')->nullable();
            $table->integer('sequence')->nullable();
            $table->boolean('is_active');
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxes');
    }
};
