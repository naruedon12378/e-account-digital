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
        Schema::create('payroll_salary_details', function (Blueprint $table) {
            $table->id();
            $table->integer('payroll_salary_id')->comment('Ref tbl_payroll_salaries');
            $table->integer('employee_id')->comment('Ref tbl_payroll_employees');
            $table->double('salary');
            $table->double('withholding_tax');
            $table->double('social_security');
            $table->double('pvd')->default(0);
            $table->double('total_revenue');
            $table->double('total_deduct');
            $table->double('net_salary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_salary_details');
    }
};
