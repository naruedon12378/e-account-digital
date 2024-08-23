<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_requistions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('code', 50)->nullable();
            $table->string('currency_code', 50)->nullable();
            $table->string('tax_type', 50)->nullable();
            $table->string('title', 100)->nullable();
            $table->enum('type', ['in', 'out'])->default('in');
            $table->unsignedBigInteger('from_branch_id')->nullable();
            $table->string('from_location', 100)->nullable();
            $table->unsignedBigInteger('to_branch_id')->nullable();
            $table->string('to_location', 100)->nullable();
            $table->text('remark')->nullable();
            $table->unsignedBigInteger('user_creator_id');
            $table->unsignedBigInteger('user_drawer_id')->nullable();
            $table->unsignedBigInteger('user_checker_id')->nullable();
            $table->unsignedBigInteger('user_approver_id')->nullable();
            $table->unsignedBigInteger('user_drawee_id')->nullable();
            $table->unsignedBigInteger('user_receiver_id')->nullable();
            $table->enum('status', ['pending','approved','transferring','transferred','reject'])->default('pending');
            $table->boolean("is_active")->default(1);
            $table->string('deleted_by', 50)->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_drawer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_checker_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_approver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_drawee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('from_branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('to_branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_requistions');
    }
};
