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
        Schema::create('payroll_departments', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->comment('เลขที่แผนก');
            $table->string('name_th')->nullable()->comment('ชื่อแผนก (ภาษาไทย)');
            $table->string('name_en')->nullable()->comment('ชื่อแผนก (ภาษาอังกฤษ)');
            $table->boolean('publish')->default(1)->comment('สถานะการเผยแพร่ (0, 1)');
            $table->boolean('record_status')->default(1)->comment('soft delete (0, 1)');

            $table->unsignedBigInteger('account_id')->nullable()->comment('FK Account');
            $table->unsignedBigInteger('company_id')->nullable()->comment('FK Company');

            // ยังไม่รู้ว่าต้องเชื่อม key กับตารางไหน
            // $table->foreign('')->references('id')->on('')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_departments');
    }
};
