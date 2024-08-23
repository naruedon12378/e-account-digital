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
        Schema::create('setting_payments', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->nullable()->comment('หมายเลขบัญชี');
            $table->string('remark')->nullable()->comment('หมายเหตุ');
            $table->boolean('advance_type')->default(0)->comment('ค่าเริ่มต้นของระบบ => 0, กำหนดเอง => 1');
            $table->boolean('account_type')->default(1)->comment('ประเภทบัญชี');
            $table->boolean('payment_button_publish')->default(0)->comment('สถานะ การแสดงปุ่มชำระเงินในเอกสาร');
            $table->boolean('payment_type')->default(1)->comment('ธนาคาร => 1, API => 2');

            $table->unsignedBigInteger('payment_option_one_id')->nullable()->comment('FK bank_accounts');
            $table->unsignedBigInteger('payment_option_two_id')->nullable()->comment('FK bank_accounts');
            $table->unsignedBigInteger('payment_option_three_id')->nullable()->comment('FK bank_accounts');
            $table->unsignedBigInteger('bank_id')->nullable()->comment('FK banks');
            $table->unsignedBigInteger('company_id')->nullable()->comment('FK companies');

            $table->foreign('payment_option_one_id')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->foreign('payment_option_two_id')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->foreign('payment_option_three_id')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_payments');
    }
};
