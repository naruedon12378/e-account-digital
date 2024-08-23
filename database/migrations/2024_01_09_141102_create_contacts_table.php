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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 14)->unique();
            $table->enum('party_type', ['all','customer','seller','disable']);
            $table->enum('region', ['TH','OV']);
            $table->string('tax_id', 40)->nullable();
            $table->string('branch', 5)->nullable();
            $table->enum('business_type', ['P','C']);
            $table->integer('sub_business_type_id');
            $table->string('prefix', 10)->nullable();
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('company_name', 255)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('website', 50)->nullable();
            $table->string('fax', 20)->nullable();
            $table->unsignedInteger('sale_credit_term_id')->nullable();
            $table->unsignedInteger('purchase_credit_term_id')->nullable();
            $table->unsignedInteger('sale_account_id');
            $table->unsignedInteger('purchase_account_id');
            $table->enum('credit_limit_type', ['default','unlimit','custom']);
            $table->double('credit_limit_amt')->nullable();
            $table->unsignedBigInteger("company_id");
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('contacts');
    }
};
