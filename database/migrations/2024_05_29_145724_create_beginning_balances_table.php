<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beginning_balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('code', 100)->nullable();
            $table->string('currency_code', 100)->nullable();
            $table->date('created_date')->nullable();
            $table->string('tax_type', 100)->nullable();
            $table->string('title', 100)->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->double('total_price', 10, 2)->default(0);
            $table->text('remark')->nullable();
            $table->unsignedBigInteger('user_creator_id');
            $table->unsignedBigInteger('user_checker_id')->nullable();
            $table->unsignedBigInteger('user_approver_id')->nullable();
            $table->unsignedBigInteger('user_receiver_id')->nullable();
            $table->enum('status', ['pending', 'approved', 'transferring', 'transferred', 'reject'])->default('pending');
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->string('deleted_by', 100)->nullable();
            $table->string('deleted_at', 100)->nullable();
            $table->boolean("is_active")->default(1);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('user_creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_checker_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_approver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beginning_balances');
    }
};
