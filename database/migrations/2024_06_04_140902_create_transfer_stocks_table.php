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
        Schema::create('transfer_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_id');
            $table->string('code', 50);
            $table->string('document_number', 50);
            $table->string('condition_type', 50);
            $table->unsignedBigInteger('user_creator_id');
            $table->unsignedBigInteger('user_counter_id');
            $table->unsignedBigInteger('user_approver_id');
            $table->text('remark');
            $table->string("created_by", 100)->nullable();
            $table->string("updated_by", 100)->nullable();
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');
            $table->foreign('user_creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_counter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_approver_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_stocks');
    }
};
