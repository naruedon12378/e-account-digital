<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receipt_plannings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->constrained();
            $table->string('code', 100)->nullable();
            $table->string('currency_code', 100)->nullable();
            $table->string('tax_type', 100)->nullable();
            $table->string('title', 100)->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->text('remark')->nullable();
            $table->dateTime('receipt_plan_datetime')->nullable();
            $table->unsignedBigInteger('user_creator_id')->constrained();
            $table->unsignedBigInteger('user_receiver_id')->nullable();
            $table->unsignedBigInteger('user_checker_id')->nullable();
            $table->unsignedBigInteger('user_approver_id')->nullable();
            $table->enum('status', ['pending', 'approved', 'reject'])->default('pending');
            $table->boolean("is_active")->default(1);
            $table->string('deleted_by', 100)->nullable();
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->string('deleted_at', 100)->nullable();
            $table->foreign('user_creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_checker_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_approver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_plannings');
    }
};
