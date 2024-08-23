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
        Schema::create('purchase_asset_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 50)->nullable();
            $table->string('doc_number', 20)->unique();
            $table->string('transaction_type', 10);
            $table->unsignedBigInteger('seller_id');
            $table->text('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('issue_date', 10)->nullable();
            $table->string('due_date', 10)->nullable();
            $table->string('post_date', 10)->nullable();
            $table->string('approved_date', 10)->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('tax_expense_id')->nullable();
            $table->string('vat_type',1)->nullable();
            $table->string('currency_code', 3)->nullable();
            $table->string('tax_invoice_date', 10)->nullable();
            $table->string('tax_invoice_number', 50)->nullable();
            $table->boolean('is_discount')->default(0);
            $table->double('discount_amt')->nullable();
            $table->double('total_exm_amt')->nullable();
            $table->double('total_zer_amt')->nullable();
            $table->double('total_std_amt')->nullable();
            $table->double('total_vat_amt')->nullable();
            $table->double('total_wht_amt')->nullable();
            $table->double('grand_total')->nullable();
            $table->string('file', 255)->nullable();
            $table->text('remark')->nullable();
            $table->enum('status_code', ['draft', 'await_approval', 'outstanding', 'overdue','await_receipt', 'got_receipt', 'voided', 'recurring']);
            $table->enum('progress', ['pai', 'pv']);
            $table->boolean("is_active")->default(1);
            $table->unsignedBigInteger("company_id");
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
        Schema::dropIfExists('purchase_asset_invoices');
    }
};
