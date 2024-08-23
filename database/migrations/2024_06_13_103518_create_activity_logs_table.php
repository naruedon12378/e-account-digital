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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('line_item_number')->nullable();
            $table->string('table_name', 100);
            $table->string('primary_key_name', 100);
            $table->bigInteger('primary_key_value');
            $table->string('activity', 255)->nullable();
            $table->boolean("is_active")->default(1);
            $table->unsignedBigInteger("company_id");
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('activity_logs');
    }
};
