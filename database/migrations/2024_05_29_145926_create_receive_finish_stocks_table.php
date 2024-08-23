<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receive_finish_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->constrained();
            $table->unsignedBigInteger('receipt_planning_id')->constrained();
            $table->string('receipt_document_code', 100)->nullable();
            $table->string('code', 100)->nullable();
            $table->string('currency_code', 100)->nullable();
            $table->string('tax_type', 10)->nullable();
            $table->string('title', 100)->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->text('remark')->nullable();
            $table->unsignedBigInteger('user_creator_id')->constrained();
            $table->unsignedBigInteger('user_receiver_id')->nullable();
            $table->unsignedBigInteger('user_checker_id')->nullable();
            $table->unsignedBigInteger('user_approve_id')->nullable();
            $table->enum('status', ['pending', 'approved', 'reject'])->default('pending');
            $table->boolean("is_active")->default(1);
            $table->string('created_date')->nullable();
            $table->softDeletes();
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->foreign('user_creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_checker_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_approve_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('receipt_planning_id')->references('id')->on('receipt_plannings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receive_finish_stocks');
    }
};
