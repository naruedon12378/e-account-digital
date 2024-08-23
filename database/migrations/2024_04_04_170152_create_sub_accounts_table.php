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
        Schema::create('sub_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('primary_account_id');
            $table->unsignedInteger('secondary_account_id');
            $table->string('primary_prefix', 2);
            $table->string('secondary_prefix', 2);
            $table->string('prefix', 2);
            $table->string('name_en', 255);
            $table->string('name_th', 255)->nullable();
            $table->integer('sequence')->nullable();
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('sub_accounts');
    }
};
