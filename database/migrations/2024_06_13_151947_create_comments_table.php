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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('line_item_number');
            $table->string('table_name', 100);
            $table->string('primary_key_name', 100);
            $table->bigInteger('primary_key_value');
            $table->text('comment')->nullable();
            $table->boolean("is_active")->default(1);
            $table->unsignedBigInteger("company_id");
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
